@extends('backend.backend')
@section('content')
	<!-- Content student update -->
    <section id="page">
      <div class="container">
        <div class="row content content--regist">
          <table class="table table-bordered">
              <tbody>
                <tr>
                  <td class="col-title"><label for="textname">氏名</label></td>
                  <td>
                    <input name="txtname" type="text" class="form-control form-control--small form-control--mar-right">
                    <input name="txtname" id="textname" type="text" class="form-control form-control--small">
                  </td>
                  <td class="col-title"><label for="textphone">ふりがな</label></td>
                  <td>
                    <input name="txtphone1" id="textphone" type="text" class="form-control form-control--small form-control--mar-right">
                    <input name="txtphone2" type="text" class="form-control form-control--small">
                  </td>
                  <td class="col-title"><label for="textbirtdday">誕生日</label></td>
                  <td>西暦
                      <input name="txtyear" id="textbirtdday" type="text" class="form-control form-control--small-xs"> 年 
                      <input name="txtmontd" type="text" class="form-control form-control--small-xs"> 月 
                      <input name="txtyear" type="text" class="form-control form-control--small-xs"> 日 
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="rdsex">性別</label></td>
                  <td>
                    <input name="rasex" id="rdsex" value="radio" type="radio"> 男　　　
                    <input name="rasex" value="radio2" type="radio"> 女
                  </td>
                  <td class="col-title"><label for="textschoolname">高校</label></td>
                  <td><input name="txtschoolname" id="textschoolname" type="text" class="form-control form-control--default"></td>
                  <td class="col-title"><label for="textschoolyear">学年</label></td>
                  <td><input name="txtschoolyear" id="textschoolyear" type="text" class="form-control form-control--small-xs"> 年生（4/1現在）</td>
                </tr>
                <tr>
                  <td class="col-title"><label for="textpostal">郵便番号</label></td>
                  <td><label for="textpostal">ハイフンなし7桁 </label>
                    <input name="txtpostal" id="textpostal" type="text" class="form-control form-control--smaller form-control--mar-right">
                    <input name="btsladdress" value="住所選択" type="submit" class="btn btn-sm btn-primary" style="margin-top: -4.5px;"></td>
                  <td class="col-title"><label for="sbprefecture">住所</label></td>
                  <td colspan="3">
                    <div class="mar-bottom">
                      <select name="sbprefecture" id="sbprefecture" class="form-control form-control--small">
                        <option selected="selected">▼都道府県</option>
                      </select>
                      <label for="textcity">（市区町村）</label>
                      <input name="txtcity" id="textcity" type="text" class="form-control form-control--default">
                    </div>
                    <div>
                      <label for="textaddress">（地名番地）</label>
                      <input name="txtaddress" id="textaddress" type="text"  class="form-control form-control--default">
                      <label for="textaddotder">（ビル等）</label>
                      <input name="txtaddotder" id="textaddotder" type="text"  class="form-control form-control--default">
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="textphone">電話番号</label></td>
                  <td>ハイフンなし
                    <input name="txtphone" id="textphone" type="text" class="form-control form-control--default"></td>
                  <td class="col-title"><label for="textemail">メールアドレス</label></td>
                  <td>
                    <input name="txtemail" id="textemail" type="email" class="form-control form-control--default form-control--mar-right">
                  </td>
                  <td class="col-title"><label for="rdstatus">ステータス</label></td>
                  <td>
                    <input name="rdstatus" id="rdstatus" value="radio" type="radio"> 仮登録　
                    <input name="rdstatus" value="radio2" type="radio"> 本登録
                  </td>
                </tr>
              </tbody>
            </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input name="button4" value="保存する" type="submit" class="btn btn-sm btn-primary">
          </div>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input onclick="location.href='student_detail.html'" value="詳細表示に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student update -->
@endsection