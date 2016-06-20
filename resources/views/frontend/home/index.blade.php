@extends('frontend.frontend')

@section('content')
<!-- content home -->
<section id="page">
  <div class="container">
    <div class="row content content--list">
      <h3 style="margin-bottom:0px;"><a href="home.html">ホーム</a>　＞　資料請求者の情報</h3>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title">資料請求期間</td>
            <td>
              <select name="select" id="select" class="form-control form-control--small  form-control--mar-right">
                <option selected="selected">----年</option>
              </select>
              <select name="select2" id="select2" class="form-control form-control--small  form-control--mar-right">
                <option>--月</option>
              </select>
              <select name="select3" id="select3" class="form-control form-control--small  form-control--mar-right">
                <option selected="selected">--日</option>
              </select>
              　から　
              <select name="select4" id="select4" class="form-control form-control--small  form-control--mar-right">
                <option selected="selected">----年</option>
              </select>
              <select name="select4" id="select5" class="form-control form-control--small  form-control--mar-right">
                <option>--月</option>
              </select>
              <select name="select4" id="select6" class="form-control form-control--small  form-control--mar-right">
                <option selected="selected">--日</option>
              </select>
              　を　
              <input name="button6" id="button6" value="表示" type="submit" class="btn btn-sm btn-primary">
            </td>
          </tr>
        </tbody>
      </table>
      <table class="table table-bordered table-striped clearfix">
        <tr>
          <td class="col-title" align="center">学生氏名</td>
          <td class="col-title" align="center">学生氏名かな</td>
          <td class="col-title" align="center">高等学校名</td>
          <td class="col-title" align="center">生年月日</td>
          <td class="col-title" align="center">性別</td>
          <td class="col-title" align="center">郵便番号</td>
          <td class="col-title" align="center">住所</td>
          <td class="col-title" align="center">電話番号</td>
          <td class="col-title" align="center">メールアドレス</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
        <tr>
          <td>杉元　俊彦</td>
          <td>すぎもと　としひこ</td>
          <td>岡山東西南北工業高等学校</td>
          <td>1980/11/27</td>
          <td>男</td>
          <td>700-0000</td>
          <td>岡山県倉敷市倉敷駅前筋下る123-456</td>
          <td>086-000-0000</td>
          <td>sugimoto@hoge.hogehoge.com</td>
        </tr>
      </table>
    </div>
    <div class="row">
      <div class="col-md-12 text-center">
        <input name="button" id="button" value="この一覧をCSV形式で保存" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
        <input name="button2" id="button2" value="この一覧を登録されているメールアドレスへ送信" type="submit" class="btn btn-sm btn-primary">
      </div>
    </div>
  </div>
</section>
<!-- End content home -->
@endsection