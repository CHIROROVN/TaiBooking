@extends('backend.backend')
@section('content')
<!-- content student search -->
<section id="page">
  <div class="container">
    <div class="row content">
      <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-title"><label for="textname">氏名</label></td>
              <td>
                <div class="mar-bottom">よみ：
                  <input name="txtname" type="text" class="form-control form-control--small form-control--mar-right">
                  <input name="txtname" id="textname" type="text" class="form-control form-control--small">
                </div>
                <div>漢字：
                  <input name="txtname" type="text" class="form-control form-control--small form-control--mar-right">
                  <input name="txtname" id="textname" type="text" class="form-control form-control--small">
                </div>
              </td>
              <td class="col-title"><label for="textID">会員ID</label></td>
              <td>
                <input name="txtID1" id="textID" type="text" class="form-control form-control--small form-control--mar-right">～&nbsp;
                <input name="txtID2" type="text" class="form-control form-control--small">
              </td>
              <td class="col-title"><label for="textbirthday">誕生日</label></td>
              <td>
                <div class="mar-bottom">西暦
                  <input name="txtyearbirth" id="textbirthday" type="text" class="form-control form-control--small-xs"> 年 
                  <input name="txtmontdbirth" type="text" class="form-control form-control--small-xs"> 月 
                  <input name="txtyearbirth" type="text" class="form-control form-control--small-xs"> 日 
                </div>
                <div> ～&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="txtyearbirth2" type="text" class="form-control form-control--small-xs"> 年 
                  <input name="txtmonthbirth2" type="text" class="form-control form-control--small-xs"> 月 
                  <input name="txtyearbirth2" type="text" class="form-control form-control--small-xs"> 日
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="ckbsex">性別</label></td>
              <td>
                <input name="ckbsex1" id="ckbsex" value="1" type="checkbox"> 男　　　
                <input name="ckbsex2" value="2" type="checkbox"> 女
              </td>
              <td class="col-title"><label for="textschoolname">高校</label></td>
              <td><input name="txtschoolname" id="textschoolname" type="text" class="form-control form-control--default"></td>
              <td class="col-title"><label for="textschoolyear">学年</label></td>
              <td>
                <input name="txtschoolyear" id="textschoolyear" type="text" class="form-control form-control--small-xs"> 年生 ～ 
                <input name="txtschoolyearto" type="text" class="form-control form-control--small-xs"> 年生 （4/1現在）
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textpostal">郵便番号</label></td>
              <td>ハイフンなし7桁
                <input name="txtpostal" id="textpostal" type="text" class="form-control form-control--small"></td>
              <td class="col-title"><label for="sbprefecture">住所</label></td>
              <td colspan="3">
                <select name="sbprefecture" id="sbprefecture" class="form-control form-control--small">
                  <option selected="selected">▼都道府県</option>
                </select>
                <label for="textcity">（市区町村）</label>
                <input name="txtcity" id="textcity" type="text" class="form-control form-control--small">
                <label for="textaddress">（地名番地）</label>
                <input name="txtaddress" id="textaddress" type="text"  class="form-control form-control--small">
                <label for="textaddotder">（ビル等）</label>
                <input name="txtaddotder" id="textaddotder" type="text"  class="form-control form-control--small">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textphone">電話番号</label></td>
              <td>ハイフンなし
                <input name="txtphone" id="textphone" type="text" class="form-control form-control--small"></td>
              <td class="col-title"><label for="textemail">メールアドレス</label></td>
              <td colspan="3">
                <input name="txtemail" id="textemail" type="email" class="form-control form-control--default form-control--mar-right">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textregistday">初回登録日</label></td>
              <td>
                <div class="mar-bottom">西暦
                  <input name="txtyearregist" id="textregistday" type="text" class="form-control form-control--small-xs"> 年 
                  <input name="txtmonthregist" type="text" class="form-control form-control--small-xs"> 月 
                  <input name="txtdayregist" type="text" class="form-control form-control--small-xs"> 日
                </div>
                <div> ～&nbsp;&nbsp;&nbsp;&nbsp;
                  <input name="txtyearregist2" type="text" class="form-control form-control--small-xs"> 年 
                  <input name="txtmonthregist2" type="text" class="form-control form-control--small-xs"> 月 
                  <input name="txtdayregist2" type="text" class="form-control form-control--small-xs"> 日
                </div>
              </td>
              <td class="col-title"><label for="ckstatus">ステータス</label></td>
              <td colspan="3">
                <input name="ckstatus" id="ckstatus" value="" type="checkbox"> 本登録　　　
                <input name="ckstatus" value="" type="checkbox"> 仮登録
              </td>
            </tr>
          </tbody>
        </table>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <input onclick="location.href='student_list.html'" value="検索開始（OR検索）" type="button" class="btn btn-sm btn-primary btn-mar-right">
        <input name="button5" id="button5" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary">
      </div>
    </div>
  </div>
</section>
<!-- End content student search -->
@endsection