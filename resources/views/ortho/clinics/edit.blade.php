@extends('ortho.ortho')

@section('content')
  {!! Form::open(array('url' => 'ortho/clinics/edit/' . $clinic->clinic_id, 'method' => 'post')) !!}
    <section id="page">
      <div class="container">
        <div class="row content-page content-page--td-middle">
          <h3>医院情報管理　＞　医院情報の新規登録</h3>
            <div class="table-responsive clinic">
              <table class="table table-bordered">
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_name">医院名 (*)</label></td>
                  <td>
                    <input type="text" name="clinic_name" id="clinic_name" class="form-control" value="{{ $clinic->clinic_name }}" />
                    <span class="error-input">@if ($errors->first('clinic_name')) {!! $errors->first('clinic_name') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_name_yomi">医院名よみ (*)</label></td>
                  <td>
                    <input type="text" name="clinic_name_yomi" id="clinic_name_yomi " class="form-control" value="{{ $clinic->clinic_name_yomi }}" />
                    <span class="error-input">@if ($errors->first('clinic_name_yomi')) {!! $errors->first('clinic_name_yomi') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_display_name">（表示用）医院名 (*)</label></td>
                  <td>
                    <input type="text" name="clinic_display_name" id="clinic_display_name " class="form-control" value="{{ $clinic->clinic_display_name }}" />
                    <span class="error-input">@if ($errors->first('clinic_display_name')) {!! $errors->first('clinic_display_name') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="area">地域</label></td>
                  <td colspan="2">
                    <select name="area" id="area" class="form-control form-control--small">
                      <option value="">▼選択/Select</option>
                      @if(!empty($areas) && count($areas) > 0)
                        @foreach($areas as $area)
                        <option value="{{ $area->area_id }}" @if(isset($area_clinics[$area->area_id])) {{'selected'}} @endif>{{ $area->area_name }}</option>
                        @endforeach
                      @endif
                    </select>
                  </td>
                </tr>
                <tr>
                  <td rowspan="5" class="col-title">ステータス</td>
                  <td><label for="clinic_status1">処理</label></td>
                  <td>
                    <select name="clinic_status1" id="clinic_status1" class="form-control form-control--smaller">
                      <option value="1" @if($clinic->clinic_status1 == 1) {{'selected'}} @endif>はい</option>
                      <option value="0" @if($clinic->clinic_status1 == 0) {{'selected'}} @endif>いいえ</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="clinic_status2">X-ray</label></td>
                  <td>
                    <select name="clinic_status2" id="clinic_status2" class="form-control form-control--smaller">
                        <option value="1" @if($clinic->clinic_status2 == 1) {{'selected'}} @endif>はい</option>
                        <option value="0" @if($clinic->clinic_status2 == 0) {{'selected'}} @endif>いいえ</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="clinic_status3">SP</label></td>
                  <td>
                    <select name="clinic_status3" id="clinic_status3" class="form-control form-control--smaller">
                      <option value="1" @if($clinic->clinic_status3 == 1) {{'selected'}} @endif>はい</option>
                      <option value="0" @if($clinic->clinic_status3 == 0) {{'selected'}} @endif>いいえ</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="clinic_status4">TBI</label></td>
                  <td>
                    <select name="clinic_status4" id="clinic_status4" class="form-control form-control--smaller">
                      <option value="1" @if($clinic->clinic_status4 == 1) {{'selected'}} @endif>はい</option>
                      <option value="0" @if($clinic->clinic_status4 == 0) {{'selected'}} @endif>いいえ</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td><label for="clinic_status5">出張</label></td>
                  <td>
                    <select name="clinic_status5" id="clinic_status5" class="form-control form-control--smaller">
                      <option value="1" @if($clinic->clinic_status5 == 1) {{'selected'}} @endif>はい</option>
                      <option value="0" @if($clinic->clinic_status5 == 0) {{'selected'}} @endif>いいえ</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_zip3">郵便番号 (*)</label></td>
                  <td><input name="clinic_zip3" type="text" id="clinic_zip3" class="form-control form-control--small" maxlength="3" value="{{ $clinic->clinic_zip3 }}" />
                    -
                    <input name="clinic_zip4" type="text" class="form-control form-control--small" maxlength="4" value="{{ $clinic->clinic_zip4 }}" />
                    <span class="error-input">@if ($errors->first('clinic_zip3')) {!! $errors->first('clinic_zip3') !!} @endif</span>
                    <span class="error-input">@if ($errors->first('clinic_zip4')) {!! $errors->first('clinic_zip4') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_address1">住所 (*)</label></td>
                  <td>
                    <input name="clinic_address1" type="text" id="clinic_address1" class="form-control" value="{{ $clinic->clinic_address1 }}" />
                    <span class="error-input">@if ($errors->first('clinic_address1')) {!! $errors->first('clinic_address1') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_address2">住所（ビル名等） (*)</label></td>
                  <td>
                    <input name="clinic_address2" type="text" id="clinic_address2" class="form-control" value="{{ $clinic->clinic_address2 }}" />
                    <span class="error-input">@if ($errors->first('clinic_address2')) {!! $errors->first('clinic_address2') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_ownername">院長名 (*)</label></td>
                  <td>
                    <input type="text" name="clinic_ownername" id="clinic_ownername" class="form-control form-control--small" value="{{ $clinic->clinic_ownername }}" />
                    <span class="error-input">@if ($errors->first('clinic_ownername')) {!! $errors->first('clinic_ownername') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_tel">TEL (*)</label></td>
                  <td>
                    <input type="text" name="clinic_tel" id="clinic_tel" class="form-control form-control--small" value="{{ $clinic->clinic_tel }}" />
                    <span class="error-input">@if ($errors->first('clinic_tel')) {!! $errors->first('clinic_tel') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_tel_ip">TEL（IP電話）</label></td>
                  <td><input type="text" name="clinic_tel_ip" id="clinic_tel_ip" class="form-control form-control--small" value="{{ $clinic->clinic_tel_ip }}" /></td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_fax">FAX</label></td>
                  <td><input type="text" name="clinic_fax" id="clinic_fax" class="form-control form-control--small" value="{{ $clinic->clinic_fax }}" /></td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_email">E-mail (*)</label></td>
                  <td>
                    <input type="text" name="clinic_email" id="clinic_email" class="form-control form-control--small" value="{{ $clinic->clinic_email }}" />
                    <span class="error-input">@if ($errors->first('clinic_email')) {!! $errors->first('clinic_email') !!} @endif</span>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" class="col-title"><label for="clinic_memo">メモ</label></td>
                  <td><textarea name="clinic_memo" cols="50" rows="3" id="clinic_memo" class="form-control">{{ $clinic->clinic_memo }}</textarea></td>
                </tr>
              </table>
              <table class="table table-bordered">
                <tbody>
                  <tr class="col-title">
                  <td align="center">曜日</td>
                  <td align="center">休診日</td>
                  <td align="center">午前</td>
                  <td align="center">午後</td>
                </tr>
                <!-- sunday -->
                <tr>
                  <td align="center">日</td>
                  <td><div class="checkbox"><label><input type="checkbox" name="clinic_sun_work" id="clinic_sun_work" value="1" @if($clinic->clinic_sun_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_sun_am_start_h" id="clinic_sun_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                      <option value="{{ $clinic_am_start }}" @if($clinic->clinic_sun_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sun_am_start_m" id="clinic_sun_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sun_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_sun_am_end_h" id="clinic_sun_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_sun_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sun_am_end_m" id="clinic_sun_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sun_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select></td>
                  <td>
                    <select name="clinic_sun_pm_start_h" id="clinic_sun_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_sun_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sun_pm_start_m" id="clinic_sun_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sun_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_sun_pm_end_h" id="clinic_sun_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_sun_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sun_pm_end_m" id="clinic_sun_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sun_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select></td>
                </tr>

                <!-- monday -->
                <tr>
                  <td align="center">月</td>
                  <td>
                    <div class="checkbox"><label><input type="checkbox" name="clinic_mon_work" id="clinic_mon_work" value="1" @if($clinic->clinic_mon_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_mon_am_start_h" id="clinic_mon_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                      <option value="{{ $clinic_am_start }}" @if($clinic->clinic_mon_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_mon_am_start_m" id="clinic_mon_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_mon_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_mon_am_end_h" id="clinic_mon_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_mon_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_mon_am_end_m" id="clinic_mon_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_mon_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="clinic_mon_pm_start_h" id="clinic_mon_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_mon_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_mon_pm_start_m" id="clinic_mon_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_mon_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_mon_pm_end_h" id="clinic_mon_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_mon_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_mon_pm_end_m" id="clinic_mon_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_mon_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <!-- tueday -->
                <tr>
                  <td align="center">火</td>
                  <td><div class="checkbox"><label><input type="checkbox" name="clinic_tue_work" id="clinic_tue_work" value="1" @if($clinic->clinic_tue_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_tue_am_start_h" id="clinic_tue_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                      <option value="{{ $clinic_am_start }}" @if($clinic->clinic_tue_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_tue_am_start_m" id="clinic_tue_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_tue_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_tue_am_end_h" id="clinic_tue_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_tue_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_tue_am_end_m" id="clinic_tue_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_tue_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select></td>
                  <td>
                    <select name="clinic_tue_pm_start_h" id="clinic_tue_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_tue_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_tue_pm_start_m" id="clinic_tue_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_tue_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_tue_pm_end_h" id="clinic_tue_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_tue_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_tue_pm_end_m" id="clinic_tue_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_tue_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <!-- wednesday -->
                <tr>
                  <td align="center">水</td>
                  <td><input name="clinic_wed_work" id="clinic_wed_work" type="checkbox" value="1" @if($clinic->clinic_wed_work == 1) {{'checked'}} @endif>
                    はい</td>
                  <td>
                    <select name="clinic_wed_am_start_h" id="clinic_wed_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                        <option value="{{ $clinic_am_start }}" @if($clinic->clinic_wed_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_wed_am_start_m" id="clinic_wed_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_wed_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_wed_am_end_h" id="clinic_wed_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_wed_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_wed_am_end_m" id="clinic_wed_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_wed_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select></td>
                  <td>
                    <select name="clinic_wed_pm_start_h" id="clinic_wed_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_wed_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_wed_pm_start_m" id="clinic_wed_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_wed_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_wed_pm_end_h" id="clinic_wed_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_wed_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_wed_pm_end_m" id="clinic_wed_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_wed_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <!-- thursday -->
                <tr>
                  <td align="center">木</td>
                  <td><div class="checkbox"><label><input type="checkbox" name="clinic_thu_work" id="clinic_thu_work" value="1" @if($clinic->clinic_thu_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_thu_am_start_h" id="clinic_thu_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                        <option value="{{ $clinic_am_start }}" @if($clinic->clinic_thu_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_thu_am_start_m" id="clinic_thu_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_thu_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_thu_am_end_h" id="clinic_thu_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_thu_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_thu_am_end_m" id="clinic_thu_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_thu_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="clinic_thu_pm_start_h" id="clinic_thu_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_thu_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_thu_pm_start_m" id="clinic_thu_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_thu_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_thu_pm_end_h" id="clinic_thu_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_thu_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_thu_pm_end_m" id="clinic_thu_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_thu_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <!-- friday -->
                <tr>
                  <td align="center">金</td>
                  <td><div class="checkbox"><label><input type="checkbox" name="clinic_fri_work" id="clinic_fri_work" value="1" @if($clinic->clinic_fri_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_fri_am_start_h" id="clinic_fri_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                        <option value="{{ $clinic_am_start }}" @if($clinic->clinic_fri_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_fri_am_start_m" id="clinic_fri_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_fri_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_fri_am_end_h" id="clinic_fri_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_fri_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_fri_am_end_m" id="clinic_fri_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_fri_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td>
                    <select name="clinic_fri_pm_start_h" id="clinic_fri_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_fri_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_fri_pm_start_m" id="clinic_fri_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_fri_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_fri_pm_end_h" id="clinic_fri_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_fri_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_fri_pm_end_m" id="clinic_fri_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_fri_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>

                <!-- saturday -->
                <tr>
                  <td align="center">土</td>
                  <td><div class="checkbox"><label><input type="checkbox" name="clinic_sat_work" id="clinic_sat_work" value="1" @if($clinic->clinic_sat_work == 1) {{'checked'}} @endif />はい</label></div></td>
                  <td>
                    <select name="clinic_sat_am_start_h" id="clinic_sat_am_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_starts as $clinic_am_start)
                        <option value="{{ $clinic_am_start }}" @if($clinic->clinic_sat_am_start_h == $clinic_am_start) {{'selected'}} @endif>{{ $clinic_am_start }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sat_am_start_m" id="clinic_sat_am_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sat_am_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_sat_am_end_h" id="clinic_sat_am_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_am_ends as $clinic_am_end)
                      <option value="{{ $clinic_am_end }}" @if($clinic->clinic_sat_am_end_h == $clinic_am_end) {{'selected'}} @endif>{{ $clinic_am_end }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sat_am_end_m" id="clinic_sat_am_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sat_am_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select></td>
                  <td>
                    <select name="clinic_sat_pm_start_h" id="clinic_sat_pm_start_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_sat_pm_start_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sat_pm_start_m" id="clinic_sat_pm_start_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sat_pm_start_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                    ～　
                    <select name="clinic_sat_pm_end_h" id="clinic_sat_pm_end_h" class="form-control form-control--smaller">
                      <option value="">--時</option>
                      @foreach($clinic_pms as $clinic_pm)
                      <option value="{{ $clinic_pm }}" @if($clinic->clinic_sat_pm_end_h == $clinic_pm) {{'selected'}} @endif>{{ $clinic_pm }}</option>
                      @endforeach
                    </select>
                    <select name="clinic_sat_pm_end_m" id="clinic_sat_pm_end_m" class="form-control form-control--smaller">
                      <option value="">--分</option>
                      @foreach($clinic_ms as $clinic_m)
                      <option value="{{ $clinic_m }}" @if($clinic->clinic_sat_pm_end_m == $clinic_m) {{'selected'}} @endif>{{ $clinic_m }}</option>
                      @endforeach
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
            </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="submit" id="button" name="save" value="登録する" class="btn btn-sm btn-page">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
              <div class="modal-dialog modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete confirm</h4>
                  </div>
                  <div class="modal-body">
                    <p>Are you sure to delete?</p>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ asset('ortho/clinics/delete/' . $clinic->clinic_id) }}" class="btn btn-sm btn-page">Yes</a>
                    <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">No</button>
                  </div>
                </div>
              </div>
            </div>

        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <a href="{{ asset('ortho/clinics') }}" class="btn btn-sm btn-page">登録済み医院一覧に戻る</a>
          </div>
        </div>
      </div>
    </section>
  {!! Form::close() !!}
@endsection