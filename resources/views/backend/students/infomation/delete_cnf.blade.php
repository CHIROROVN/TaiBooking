@extends('backend.backend')
@section('content')
	<!-- content student delete cnf -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <p class="note">このデータを削除しますか？　この操作は元に戻すことができません。</p>
          <table class="table table-bordered">
            <tr>
              <td class="col-title">氏名</td>
              <td>山田　太郎</td>
              <td class="col-title">ふりがな</td>
              <td>やまだ　たろう</td>
              <td class="col-title">誕生日</td>
              <td>西暦 1980 年 12 月 25 日</td>
            </tr>
            <tr>
              <td class="col-title">性別</td>
              <td>男</td>
              <td class="col-title">高校</td>
              <td>岡山高等学校</td>
              <td class="col-title">学年</td>
              <td>3 年生（4/1現在）</td>
            </tr>
            <tr>
              <td class="col-title">郵便番号</td>
              <td>700-0001</td>
              <td class="col-title">住所</td>
              <td colspan="3">岡山県　倉敷市　福井125-7　スギモトマンション1101</td>
            </tr>
            <tr>
              <td class="col-title">電話番号</td>
              <td>086-111-1111</td>
              <td class="col-title">メールアドレス</td>
              <td>sugimoto@chiroro.co.jp</td>
              <td class="col-title">ステータス</td>
              <td>本登録</td>
            </tr>
          </table>
          
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input name="button4" id="button4" value="削除する（確認済）" type="submit" class="btn btn-sm btn-primary btn-mar-right">
            <input onclick="location.href='student_detail.html'" value="やめる" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='student_detail.html'" value="詳細表示に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student delete cnf -->
@endsection