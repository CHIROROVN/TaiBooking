@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.pamphlets.index', 'method' => 'get')) !!}
<div class="container">
  <div class="row content">
    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.pamphlets.regist') }}'" value="資料請求番号の新規登録" type="button" class="btn btn-sm btn-primary">
      </div>
    </div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="s_pamph_number">資料請求番号</label></td>
          <td>
            <input name="s_pamph_number" id="s_pamph_number" type="text" class="form-control form-control--small" value="{{ $s_pamph_number }}">
          </td>
          <td class="col-title"><label for="s_pamph_name">資料名</label></td>
          <td>
            <input name="s_pamph_name" id="s_pamph_name" type="text" class="form-control form-control--small" value="{{ $s_pamph_name }}">
          </td>
          <td class="col-title"><label for="ckKind">番号種別</label></td>
          <td>
            <input name="s_pamph_kind_school" id="ckKind" value="0" type="checkbox" @if($s_pamph_kind_school == '0') {{'checked'}} @endif> 学校　　　
            <input name="s_pamph_kind_reserve" value="1" type="checkbox" @if($s_pamph_kind_reserve == '1') {{'checked'}} @endif> 予備　　　
            <input name="s_pamph_kind_bundle" id="ckNewOld" value="2" type="checkbox" @if($s_pamph_kind_bundle == '2') {{'checked'}} @endif> 一括
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="ckUseSegment">使用区分</label></td>
          <td>
            <input name="s_pamph_class_unused" id="ckUseSegment" value="1" type="checkbox" @if($s_pamph_class_unused == '1') {{'checked'}} @endif> 未使用　　　
            <input name="s_pamph_class_used" value="0" type="checkbox" @if($s_pamph_class_used == '0') {{'checked'}} @endif> 使用済
          </td>
          <td class="col-title"><label for="s_pamph_cus_id">学校コード</label></td>
          <td>
            <input name="s_pamph_cus_name" id="s_pamph_cus_id" type="text" class="form-control form-control--small" value="{{ $s_pamph_cus_name }}">
            <input name="s_pamph_cus_id" type="hidden" id="s_pamph_cus_id-id" value="{{ $s_pamph_cus_id }}">
            </td>
          <td class="col-title"><label for="s_pamph_send">配送の有無</label></td>
          <td>
            <input name="s_pamph_send_none" value="0" type="checkbox" @if($s_pamph_send_none == '0') {{'checked'}} @endif> なし　　　
            <input name="s_pamph_send_yes" id="ckPresence" value="1" type="checkbox" @if($s_pamph_send_yes == '1') {{'checked'}} @endif> あり
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="s_pamph_bunya_id">分野コード</label></td>
          <td>
            <input name="s_pamph_bunya_name" id="s_pamph_bunya_id" type="text" class="form-control form-control--small" value="{{ $s_pamph_bunya_name }}">
            <input name="s_pamph_bunya_id" type="hidden" id="s_pamph_bunya_id-id" value="{{ $s_pamph_bunya_id }}">
          </td>
          <td class="col-title"><label for="s_pamph_pref">都道府県</label></td>
          <td>
            <select name="s_pamph_pref[]" id="s_pamph_pref" class="form-control form-control--small" multiple="multiple">
              @if ( !empty($s_pamph_pref) )
                @if ( in_array(0, $s_pamph_pref) )
                <option value="0" selected="">選択なし</option>
                @else
                <option value="0">選択なし</option>
                @endif
                @foreach ( $prefs as $pref )
                <option value="{{ $pref->pref_id }}" @if(in_array($pref->pref_id, $s_pamph_pref)) selected @endif>{{ $pref->pref_name }}</option>
                @endforeach
              @else
                <option value="0" selected="">選択なし</option>
                @foreach ( $prefs as $pref )
                <option value="{{ $pref->pref_id }}">{{ $pref->pref_name }}</option>
                @endforeach
              @endif
            </select>
            OR
            <select name="s_pamph_area[]" id="s_pamph_area" class="form-control form-control--small" multiple="multiple">
              @if ( !empty($s_pamph_area) )
                @if ( in_array(0, $s_pamph_area) )
                <option value="0" selected="">選択なし</option>
                @else
                <option value="0">選択なし</option>
                @endif
                @foreach ( $areas as $area )
                <option value="{{ $area->area_id }}" @if(in_array($area->area_id, $s_pamph_area)) selected @endif>{{ $area->area_name }}</option>
                @endforeach
              @else
                <option value="0" selected="">選択なし</option>
                @foreach ( $areas as $area )
                <option value="{{ $area->area_id }}">{{ $area->area_name }}</option>
                @endforeach
              @endif
            </select>
          </td>
          <td class="col-title"><label for="s_pamph_sex_unspecified">性別</label></td>
          <td>
            <input name="s_pamph_sex_unspecified" id="s_pamph_sex_unspecified" value="0" type="checkbox" @if($s_pamph_sex_unspecified == '0') {{'checked'}} @endif> 共通　　　
            <input name="s_pamph_sex_men" value="1" type="checkbox" @if($s_pamph_sex_men == '1') {{'checked'}} @endif> 男　　　
            <input name="s_pamph_sex_women" id="s_pamph_sex_women" value="2" type="checkbox" @if($s_pamph_sex_women == '2') {{'checked'}} @endif> 女
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input value="検索開始（AND検索）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
      <input name="button5" id="button5" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.pamphlets.search', array('where' => 'null')) }}'">
    </div>
  </div>
</div>
</form>


<script>
  $(document).ready(function(){
    // bunya
    $( "#s_pamph_bunya_id" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#s_pamph_bunya_id').val();
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
        $( "#s_pamph_bunya_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#s_pamph_bunya_id" ).val( ui.item.label );
        $( "#s_pamph_bunya_id-id" ).val( ui.item.value );
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
    $( "#s_pamph_cus_id" ).autocomplete({
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
        $( "#s_pamph_cus_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#s_pamph_cus_id" ).val( ui.item.label );
        $( "#s_pamph_cus_id-id" ).val( ui.item.value );
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
</script>

@endsection