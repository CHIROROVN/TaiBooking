@extends('frontend.frontend')

@section('content')
	 <!-- content login -->
    <section id="login">
      <div class="container">
        <div class="content-login">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <h1>ログイン</h1>
            <form class="form-horizontal">
              <p class="text-center mar-bottom30" style="font-size:14px;">ログインIDとパスワードを入力し、「ログイン」ボタンをクリックしてください。</p>
              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for="iputid">ログインID</label>
                <div class="col-xs-12 col-md-6">
                  <input type="text" class="form-control" id="iputid" >
                  <!--<div class="help-block with-errors"><ul class="list-unstyled"><li>このフィールドに記入してください。</li></ul></div>-->
                </div>
              </div>
              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for="passinput" >パスワード</label>
                <div class="col-xs-12 col-md-6">
                  <input type="password" class="form-control" id="passinput" >
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-4"></div>
                <div class="col-xs-12 col-md-6">
                  <button type="button" class="btn btn-blue" onclick="location.href='home.html'">ログイン</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- End content login -->
@endsection