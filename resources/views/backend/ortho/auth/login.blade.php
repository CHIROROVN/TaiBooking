<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>オーソネットワーク予約管理システム</title>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="{{ asset('') }}public/backend/ortho/common/css/import.css" rel="stylesheet">
</head>
<body class="body-login">
  <!-- Header -->
    <header>
      <div class="container-fluid">
        <div class="row">
          <h1><img src="{{ asset('') }}public/backend/ortho/common/image/logo.png" /></h1>
        </div>
      </div>
    </header>
  <!-- End Header -->
  <!-- content login -->
    <section id="login">
      <div class="container">
        <div class="content-login">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <h1>ログイン</h1>
            {!! Form::open(array('route' => 'ortho.login', 'method' => 'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for=" u_login">ログインID</label>
                <div class="col-xs-12 col-md-6">
                  <input type="text" class="form-control" id="iputid" name="u_login" value="{{ old('u_login') }}" >
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('u_login')) {!! $errors->first('u_login') !!} @endif</li></ul></div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-xs-12 col-md-4 control-label" for="password" >パスワード</label>
                <div class="col-xs-12 col-md-6">
                  <input type="password" class="form-control" id="password" name="password" value="" >
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('password')) {!! $errors->first('password') !!} @endif</li></ul></div>
                  @if (Session::has('error'))
                    <div class="alert alert-info">{{ Session::get('error') }}</div>
                  @endif
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-4"></div>
                <div class="col-xs-12 col-md-6">
                  <button type="submit" class="btn btn-login" name="login" value="login">ログイン</button>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-6"></div>
                <div class="col-xs-12 col-md-6" style="top: 70px; left: -62px; width: 121px;">
                  [<a class="cls-forum" href="{{route('ortho.forums.forum_list')}}"> <strong>フォーラム</strong></a>]
                </div>
              </div>

            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </section>
  <!-- End content login -->
</body>
</html>