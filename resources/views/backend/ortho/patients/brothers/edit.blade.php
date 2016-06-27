@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.patients.brothers.edit', $brother->brother_id, $patient_id], 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page content--patient-brother">
      <h3>患者管理　＞　兄弟関係の編集</h3>
        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- p_id -->
            <input type="hidden" name="p_id" value="{{ $patient_id }}">

            <!-- p_relation_id -->
            <tr>
              <td class="col-title"><label for="p_relation_id">対象者の名前</label></td>
              <td>
                <input name="p_relation_name" id="p_relation_id" type="text" class="form-control" value="{{ $brother->p_no }} {{ $brother->p_name }}({{ $brother->p_name_kana }})">
                <input name="p_relation_id" type="hidden" id="p_relation_id-id" value="{{ $brother->p_relation_id }}">
                <span class="error-input">@if ($errors->first('p_relation_id')) {!! $errors->first('p_relation_id') !!} @endif</span>
              </td>
            </tr>

            <!-- brother_relation -->
            <tr>
              <td class="col-title">関係</td>
              <td>
                <div class="radio">
                  <label><input type="radio" name="brother_relation" value="1" @if($brother->brother_relation == 1) checked="" @endif />兄　　　</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="brother_relation" value="2" @if($brother->brother_relation == 2) checked="" @endif />弟　　　　　</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="brother_relation" value="3" @if($brother->brother_relation == 3) checked="" @endif />姉　　　　　</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="brother_relation" value="4" @if($brother->brother_relation == 4) checked="" @endif />妹　　　　　</label>
                </div>
                <div class="radio">
                  <label><input type="radio" name="brother_relation" value="5" @if($brother->brother_relation == 5) checked="" @endif />いとこ</label>
                </div>
                <span class="error-input">@if ($errors->first('brother_relation')) {!! $errors->first('brother_relation') !!} @endif</span>
              </td>
            </tr>
          </table>
        </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="" id="button" value="登録する" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='{{ route('ortho.patients.brothers.index', [ $patient_id ]) }}'" value="関係の一覧に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
{!! Form::close() !!}

<script>
  $(document).ready(function(){
    // p_relation_id
    $( "#p_relation_id" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#p_relation_id').val();
          var id_not_me = '{{ $patient_id }}';
          $.ajax({
              url: "{{ route('ortho.patients.brothers.autocomplete.patient') }}",
              beforeSend: function(){
                  // alert("beforeSend");
              },
              async:    true,
              data: { key: key, id_not_me: id_not_me },
              dataType: "json",
              method: "get",
              success: response
          });
      },
      focus: function( event, ui ) {
        $( "#p_relation_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#p_relation_id" ).val( ui.item.label );
        $( "#p_relation_id-id" ).val( ui.item.value );
        // $( "#p_relation_id-description" ).html( ui.item.desc );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };
  });
</script>

@endsection