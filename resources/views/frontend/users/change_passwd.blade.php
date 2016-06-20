@extends('frontend.frontend')

@section('content')
<!-- content passwd -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h3><a href="home.html">ホーム</a>　＞　パスワードの変更</h3>
          <p>ログインパスワードを変更します。</p>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title">ログインID</td>
                <td>ous</td>
              </tr>
              <tr>
                <td class="col-title"><label for="textCurrentPass">現在のパスワード</label></td>
                <td><input name="txtCurrentPass" id="textCurrentPass" type="text" class="form-control form-control--default"></td>
              </tr>
              <tr>
                <td class="col-title"><label for="textNewPass">新しいパスワード</label></td>
                <td><input name="txtNewPass" id="textNewPass" type="text" class="form-control form-control--default"></td>
              </tr>
              <tr>
                <td class="col-title"><label for="textReNewPass">新しいパスワード（再入力）</label></td>
                <td><input name="txtReNewPass" id="textReNewPass" type="text" class="form-control form-control--default"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input name="button3" id="button3" value="変更する" type="submit" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content passwd-->
@endsection