@extends('backend.backend')
@section('content')
	<!-- content student contact delete cnf -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h3>お問い合わせ管理　＞　登録済みお問い合わせ情報の削除</h3>
          <p>この情報を削除しますか？</p>
          <table class="table table-bordered">
            <tr>
              <td class="col-title">日付</td>
              <td>西暦 2016 年 4 月 15 日</td>
              <td class="col-title">応対者</td>
              <td>山田花子</td>
            </tr>
            <tr>
              <td class="col-title">タイトル</td>
              <td colspan="3">資料請求番号の変更について</td>
            </tr>
            <tr>
              <td class="col-title">内容</td>
              <td colspan="3">番号を間違えたので修正したい。<br />12345→11111<br />資料請求情報管理から修正済みです</td>
            </tr>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input type="submit" name="button3" value="削除する" class="btn btn-sm btn-primary mar-right btn-mar-right">
            <input type="button" onClick="history.back()" value="やめる" class="btn btn-sm btn-primary">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input type="button" onClick="location.href='student_contact_list.html'" value="お問い合わせ情報一覧に戻る" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student contact delete cnf -->
@endsection