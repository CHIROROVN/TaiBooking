@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.gpamphlets.index', 'enctype'=>'multipart/form-data', 'method' => 'get')) !!}
<div class="container">
  <div class="row content">
    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.gpamphlets.regist') }}'" value="一括資料請求番号の新規登録" type="button" class="btn btn-sm btn-primary">
      </div>
    </div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="s_gpamph_number">一括資料請求番号</label></td>
          <td>
            <input name="s_gpamph_number" id="s_gpamph_number" type="text" class="form-control form-control--small" value="{{ $s_gpamph_number }}">
          </td>
          <td class="col-title"><label for="s_pamph_id">資料請求番号</label></td>
          <td>
            <!-- <input name="s_pamph_name" id="s_pamph_id" type="text" class="form-control form-control--small"> -->
            <input name="s_pamph_name" id="pamph_id" type="text" class="form-control form-control--default" value="{{ $s_pamph_name }}">
            <input name="s_pamph_id" type="hidden" id="pamph_id-id" value="{{ $s_pamph_id }}">
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input value="検索開始（AND検索）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
      <input name="button5" id="reset" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.gpamphlets.search', array('where' => 'null')) }}'">
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