@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.gpamphlets.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="gpamph_number">一括資料請求番号 <span class="note_required">※</span></label></td>
          <td>
            <input name="gpamph_number" id="gpamph_number" type="text" class="form-control form-control--small" value="{{ old('gpamph_number') }}">
            @if ($errors->first('gpamph_number'))<span class="error-input">{!! $errors->first('gpamph_number') !!}</span>@endif
          </td>
          <td class="col-title"><label for="pamph_id">資料請求番号 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_number" id="pamph_id" type="text" class="form-control form-control--default" value="{{ old('pamph_number') }}">
            <input name="pamph_id" type="hidden" id="pamph_id-id" value="">
            @if ($errors->first('pamph_id'))<span class="error-input">{!! $errors->first('pamph_id') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
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