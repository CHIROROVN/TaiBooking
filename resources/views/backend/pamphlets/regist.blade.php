@extends('backend.backend')

@section('content')

<script>
  function delete_div(span) {
    var group_child_id = $(span).attr('div-group');
    $('#' + group_child_id).remove();
  }

  function check_id(id) {
    if ( !$('#group').find('#group-' + id).length ) {
      return id;
    } 

    return check_id(id + 1);
  }

  function after_add() {
    // customer
    $( ".group-child" ).each(function( index ) {
      var id = 'pamph_cus_id-' + $(this).attr('id');
      
      $( '#' + id ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#' + id).val();
            $.ajax({
                url: "{{ route('backend.pamphlets.autocomplete.customer') }}",
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
          $( '#' + id ).val( ui.item.label );
          return false;
        },
        select: function( event, ui ) {
          $( '#' + id ).val( ui.item.label );
          $( "#" + id + '-id' ).val( ui.item.value );
          // $( "#pamph_bunya_id-description" ).html( ui.item.desc );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
    });
  }
</script>

{!! Form::open(array('route' => 'backend.pamphlets.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <!-- pamph_number -->
          <td class="col-title"><label for="pamph_number">資料請求番号 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_number" id="pamph_number" type="text" class="form-control form-control--small" value="{{ old('pamph_number') }}">
            @if ($errors->first('pamph_number'))<span class="error-input">{!! $errors->first('pamph_number') !!}</span>@endif
          </td>

          <!-- pamph_name -->
          <td class="col-title"><label for="pamph_name">資料名 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_name" id="pamph_name" type="text" class="form-control form-control--default" value="{{ old('pamph_name') }}">
            @if ($errors->first('pamph_name'))<span class="error-input">{!! $errors->first('pamph_name') !!}</span>@endif
          </td>

          <!-- pamph_kind -->
          <td class="col-title"><label for="pamph_kind">種別 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_kind" id="pamph_kind" value="0" type="radio" @if ( old('pamph_kind') == '0' ) checked @endif> 学校　　　
            <input name="pamph_kind" value="1" type="radio" @if ( old('pamph_kind') == '1' ) checked @endif> 予備　　　
            <input name="pamph_kind" id="" value="2" type="radio" @if ( old('pamph_kind') == '2' ) checked @endif> 一括
            @if ($errors->first('pamph_kind'))<span class="error-input">{!! $errors->first('pamph_kind') !!}</span>@endif
          </td>
        </tr>
        <tr>
          <!-- pamph_class -->
          <td class="col-title"><label for="pamph_class">使用区分 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_class" id="pamph_class" value="1" type="radio" @if(old('pamph_class') == '1') checked @endif> 使用済み　　　
            <input name="pamph_class" value="0" type="radio" @if(old('pamph_class') == '0') checked @endif> 未使用
            @if ($errors->first('pamph_class'))<span class="error-input">{!! $errors->first('pamph_class') !!}</span>@endif
          </td>

          <!-- pamph_cus_id -->
          <td class="col-title"><label for="pamph_cus_id">学校名</label></td>
          <td>
            <div id="group">
              @if ( old('pamph_cus_id') )
                @foreach ( old('pamph_cus_id') as $key => $value )
                  <div class="group-child" id="group-{{ $key + 1 }}" @if ($key > 0) style="margin-top: 5px;" @endif>
                    <input name="pamph_cus_name[]" id="pamph_cus_id-group-{{ $key + 1 }}" type="text" class="form-control form-control--default input-auto-complete" value="{{ old('pamph_cus_name')[$key] }}">
                    <input name="pamph_cus_id[]" type="hidden" id="pamph_cus_id-group-{{ $key + 1 }}-id" value="{{ $value }}">
                    <span id="" div-group="group-{{ $key + 1 }}" class="btn btn-default btn-xs delete" onClick="delete_div(this)">削除</span>
                  </div>
                @endforeach
              @else
              <div class="group-child" id="group-1">
                <input name="pamph_cus_name[]" id="pamph_cus_id-group-1" type="text" class="form-control form-control--default input-auto-complete" value="">
                <input name="pamph_cus_id[]" type="hidden" id="pamph_cus_id-group-1-id" value="">
                <span id="" div-group="group-1" class="btn btn-default btn-xs delete" onClick="delete_div(this)">削除</span>
              </div>
              @endif
            </div>
            <button style="margin-top: 5px;" class="btn btn-primary btn-xs" id="add">加算</button>
            <!-- <p id="pamph_bunya_id-description"></p> -->
            @if ($errors->first('pamph_cus_id'))<span class="error-input">{!! $errors->first('pamph_cus_id') !!}</span>@endif
            @if ($message = Session::get('error-input-cus-exits'))<span class="error-input">{!! $message !!}</span>@endif
          </td>

          <!-- pamph_send -->
          <td class="col-title"><label for="pamph_send">発送の有無 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_send" id="pamph_send" value="1" type="radio" @if(old('pamph_send') == '1') checked @endif> あり　　　
            <input name="pamph_send" value="0" type="radio" @if(old('pamph_send') == '0') checked @endif> なし
            @if ($errors->first('pamph_send'))<span class="error-input">{!! $errors->first('pamph_send') !!}</span>@endif
          </td>
        </tr>
        <tr>
          <!-- pamph_bunya_id -->
          <td class="col-title"><label for="pamph_bunya_id">分野</label></td>
          <td>
            <input name="pamph_bunya_name" id="pamph_bunya_id" type="text" class="form-control form-control--small" value="{{ old('pamph_bunya_name') }}">
            <input name="pamph_bunya_id" type="hidden" id="pamph_bunya_id-id" value="{{ old('pamph_bunya_id') }}">
            <!-- <p id="pamph_bunya_id-description"></p> -->
            @if ($errors->first('pamph_bunya_id'))<span class="error-input">{!! $errors->first('pamph_bunya_id') !!}</span>@endif
          </td>

          <!-- pamph_pref_area -->
          <td class="col-title"><label for="pamph_pref">都道府県・エリア <span class="note_required">※</span></label></td>
          <td>
            <select name="pamph_pref" id="pamph_pref" class="form-control form-control--small">
              <option value="0">▼都道府県</option>
              @foreach ( $prefs as $pref )
              <option value="{{ $pref->pref_id }}" @if(old('pamph_pref') == $pref->pref_id) {{'selected'}} @endif>{{ $pref->pref_name }}</option>
              @endforeach
            </select>
            または
            <select name="pamph_area" id="pamph_area" class="form-control form-control--small">
              <option value="0">▼エリア</option>
              @foreach ( $areas as $area )
              <option value="{{ $area->area_id }}" @if(old('pamph_area') == $area->area_id) {{'selected'}} @endif>{{ $area->area_name }}</option>
              @endforeach
            </select>
            @if ($errors->first('pamph_pref'))<span class="error-input">{!! $errors->first('pamph_pref') !!}</span>@endif
            @if ($errors->first('pamph_area'))<span class="error-input">{!! $errors->first('pamph_area') !!}</span>@endif
            @if ($message = Session::get('error-input'))<span class="error-input">{!! $message !!}</span>@endif
          </td>

          <!-- pamph_sex -->
          <td class="col-title"><label for="pamph_sex">対象 <span class="note_required">※</span></label></td>
          <td>
            <input name="pamph_sex" id="pamph_sex" value="0" type="radio" @if(old('pamph_sex') == '0') checked @endif> 共通　　　
            <input name="pamph_sex" value="1" type="radio" @if(old('pamph_sex') == '1') checked @endif> 男　　　
            <input name="pamph_sex" id="" value="2" type="radio" @if(old('pamph_sex') == '2') checked @endif> 女
            @if ($errors->first('pamph_sex'))<span class="error-input">{!! $errors->first('pamph_sex') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input name="" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input onclick="location.href='{{ route('backend.pamphlets.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>

<script>
  $(document).ready(function(){
    // bunya
    $( "#pamph_bunya_id" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#pamph_bunya_id').val();
          $.ajax({
              url: "{{ route('backend.pamphlets.autocomplete.bunya') }}",
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
        $( "#pamph_bunya_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#pamph_bunya_id" ).val( ui.item.label );
        $( "#pamph_bunya_id-id" ).val( ui.item.value );
        // $( "#pamph_bunya_id-description" ).html( ui.item.desc );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };

    // first customer : group 1
    $( "#pamph_cus_id-group-1" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#pamph_cus_id-group-1').val();
          $.ajax({
              url: "{{ route('backend.pamphlets.autocomplete.customer') }}",
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
        $( "#pamph_cus_id-group-1" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#pamph_cus_id-group-1" ).val( ui.item.label );
        $( "#pamph_cus_id-group-1-id" ).val( ui.item.value );
        // $( "#pamph_bunya_id-description" ).html( ui.item.desc );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };


    // add new customer
    $('#add').click(function(event) {
      event.preventDefault();

      var count_group_child = $('#group').find('.group-child').length;
      count_group_child += 1;
      count_group_child = check_id(count_group_child);

      $('#group').append('<div style="margin-top: 5px;" class="group-child" id="group-' + count_group_child + '"><input name="pamph_cus_name[]" id="pamph_cus_id-group-' + count_group_child + '" type="text" class="form-control form-control--default input-auto-complete" value=""><input name="pamph_cus_id[]" type="hidden" id="pamph_cus_id-group-' + count_group_child + '-id" value=""><span style="margin-left: 5px;" id="" div-group="group-' + count_group_child + '" class="btn btn-default btn-xs delete" onClick="delete_div(this);">削除</span></div>');

      after_add();
    });
  });
</script>
@endsection