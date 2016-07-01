@extends('backend.ortho.ortho')

@section('content')

{!! Form::open(array('route' => 'ortho.bookings.booking.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約の新規登録</h3>
      <table class="table table-bordered">
        <tr>
          <td class="col-title"><label for="textName">患者名</label></td>
          <td><input type="text" name="txtName" id="textName" class="form-control" value="123456 杉元　俊彦"/><input type="button" name="button3" id="button" value="新患です" class="btn btn-sm btn-page" onclick="location.href='{{ route('ortho.bookings.booking.1st.regist') }}'"></td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbReservation">予約日時</label></td>
          <td>2016年5月1日（日）　15:00～15:15
          </td>
        </tr>
        <tr>
          <td class="col-title">医院</td>
          <td>たい矯正歯科</td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbChair">チェアー</label></td>
          <td>
            <select name="cbChair" id="cbChair" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbDoctor">ドクター</label></td>
          <td>
            <select name="cbDoctor" id="cbDoctor" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbHygienist">衛生士</label></td>
          <td>
            <select name="cbHygienist" id="cbHygienist" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbApparatus">装置</label></td>
          <td>
            <select name="cbApparatus" id="cbApparatus" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbTreatContent1">業務内容-1</label></td>
          <td>
            <select name="cbTreatContent1" id="cbTreatContent1" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbTreatContent2">業務内容-2</label></td>
          <td>
            <select name="cbTreatContent2" id="cbTreatContent2" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbInspection">検査</label></td>
          <td>
            <select name="cbInspection" id="cbInspection" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbHealth">保険診療</label></td>
          <td>
            <select name="cbHealth" id="cbHealth" class="form-control">
              <option>▼選択</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="ckEmergency">救急</label></td>
          <td>
            <div class="checkbox">
              <label><input name="checkbox" value="checkbox" type="checkbox" id="ckEmergency">救急です</label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <div class="radio">
              <label><input name="radio" value="radio" type="radio">通常</label>
            </div>
            <div class="radio">
              <label><input name="radio" value="radio" type="radio">「TEL待ち」です</label>
            </div>
            <div class="radio">
              <label>
                <input name="radio" value="radio" type="radio">「リコール」です→
                <select name="select9" id="select9" class="form-control form-control--xs">
                  <option selected="selected">▼選択</option>
                  <option>1ヶ月後</option>
                  <option>2ヶ月後</option>
                  <option>3ヶ月後</option>
                  <option>4ヶ月後</option>
                  <option>5ヶ月後</option>
                  <option>6ヶ月後</option>
                </select>
              </label>
            </div>
            <div class="radio">
              <label><input name="radio" value="radio" type="radio">未作成技工物TEL待ち</label>
            </div>
            <div class="radio">
              <label><input name="radio" value="radio" type="radio">作成済み技工物キャンセル</label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="textRemarks">備考</label></td>
          <td><textarea name="txtRemarks" cols="60" rows="3" id="textRemarks" class="form-control"></textarea></td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="button2" value="登録する" type="submit" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>

@endsection