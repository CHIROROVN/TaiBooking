@extends('backend.ortho.ortho')

@section('content')

{!! Form::open(array('route' => 'ortho.bookings.booking.1st.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　新患予約の新規登録</h3>
        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="textName">患者名</label></td>
              <td><input type="text" name="txtName" id="textName" class="form-control"/></td>
            </tr>
            <tr>
              <td class="col-title"><label for="textNameRead">患者名よみ</label></td>
              <td><input type="text" name="txtNameRead" id="textNameRead" class="form-control"/></td>
            </tr>
            <tr>
              <td class="col-title">性別</td>
              <td>
                <div class="row">
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="radio" value="radio" /> 男
                  </div>
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="radio" value="radio" /> 女
                  </div>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textPhone">電話番号</label></td>
              <td><input type="text" name="txtPhone" id="textPhone" class="form-control"/></td>
            </tr>
            <tr>
              <td class="col-title"><label for="ckQues">問診票の入力</label></td>
              <td>
                <div class="checkbox">
                  <label><input type="checkbox" name="ckQues" id="ckQues"/>初診者一覧にも自動登録（＝問診票の新規登録）</label>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="cbReservation">予約日時</label></td>
              <td>2016年6月15日(水)　10:00～11:30
              </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>たい矯正歯科</td>
            </tr>
            <tr>
              <td class="col-title"><label for="cbChair">設備</label></td>
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
                    <select name="select9" id="select9" class="form-control form-control--sm">
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
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="history.back()" value="前の画面に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>

@endsection