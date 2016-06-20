@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => ['backend.gpamphlets.edit', $gpamphlet->gpamph_id], 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="gpamph_number">一括資料請求番号 <span class="note_required">※</span></label></td>
          <td>
            <input name="gpamph_number" id="gpamph_number" type="text" class="form-control form-control--small" value="{{ $gpamphlet->gpamph_number }}">
            @if ($errors->first('gpamph_number'))<span class="error-input">{!! $errors->first('gpamph_number') !!}</span>@endif
          </td>
          <td class="col-title"><label for="pamph_id">資料請求番号 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_number" id="pamph_id" type="text" class="form-control form-control--default" value="{{ $gpamphlet->pamph_number }}">
            <input name="pamph_id" type="hidden" id="pamph_id-id" value="{{ $gpamphlet->pamph_id }}">
            @if ($errors->first('pamph_id'))<span class="error-input">{!! $errors->first('pamph_id') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <!-- search -->
      <input type="hidden" name="s_gpamph_number" value="{{ $s_gpamph_number }}">
      <input type="hidden" name="s_pamph_name" value="{{ $s_pamph_name }}">
      <input type="hidden" name="s_pamph_id" value="{{ $s_pamph_id }}">
      <input type="hidden" name="page" value="{{ $page }}">
      <!-- save -->
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
      <!-- delete -->
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $gpamphlet->gpamph_id }}">削除</button>
      <!-- popup -->
      <div class="modal fade bs-example-modal-sm" id="myModal-{{ $gpamphlet->gpamph_id }}" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
            </div>
            <div class="modal-body">
              <p>{{ trans('common.modal_content_delete') }}</p>
            </div>
            <div class="modal-footer">
              <a href="{{ route('backend.gpamphlets.delete', array($gpamphlet->gpamph_id, 
                      's_gpamph_number'       => $s_gpamph_number,
                      's_pamph_name'          => $s_pamph_name,
                      's_pamph_id'            => $s_pamph_id,
                      'page'                  => $page
                    )) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
            </div>
          </div>
          <!-- End Modal content-->
        </div>
      </div>
      <!-- end popup -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input onclick="location.href='{{ route('backend.gpamphlets.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>

<script>
  $(document).ready(function(){
    $( "#pamph_id" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#pamph_id').val();
          $.ajax({
              url: "{{ route('backend.gpamphlets.autocomplete') }}",
              beforeSend: function(){
                  // alert("beforeSend");
              },
              async:    true,
              data: { key: key },
              dataType: "json",
              method: "get",
              success: response
          });
      },
      focus: function( event, ui ) {
        $( "#pamph_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#pamph_id" ).val( ui.item.label );
        $( "#pamph_id-id" ).val( ui.item.value );
        // $( "#pamph_bunya_id-description" ).html( ui.item.desc );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };
  }); //end document
</script>
@endsection