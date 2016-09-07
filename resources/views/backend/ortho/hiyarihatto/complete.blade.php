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
<link href="{{asset('public')}}/backend/ortho/common/css/import.css" rel="stylesheet">
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
  <!-- Content equiment list -->
  <section id="page">
    <div class="container">  
      <div class="content-page text-center">
        <h3>Your email has been sent successfully.</h3>
        
        <div class="row mar-top20 margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('ortho.login')}}'" value="ログイン画面に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
    </div>
  </section>
  <!-- End content equiment list -->
</body>
</html>