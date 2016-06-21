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
<body>
  <!-- Header -->
    <header>
      <div class="container-fulid">
        <div class="row">
          <div class="col-md-6">
            <span class="mar-right"><img src="{{ asset('') }}public/backend/ortho/common/image/logo.png" /></span>
            <span>ようこそ、@if(Auth::check()) {{ Auth::user()->u_name_display }} @endif (<a href="{{ route('ortho.change.password', [Auth::user()->id]) }}" class="text-orange">パスワード変更</a>）</span>
          </div>
          <div class="col-md-6 page-right mar-top">
            <input type="button" class="btn btn-sm btn-header" name="button2" onclick="location.href='mycalendar.html'" value="院長・自分カレンダー" />
            <input type="button" class="btn btn-sm btn-header" name="button" onclick="location.href='booking-monthly.html'" value="予約簿" />
            <input type="button" class="btn btn-sm btn-header" name="button" onclick="location.href='carte_patient_search.html'" value="カルテ" />
            <input type="button" class="btn btn-sm btn-header" name="button" onclick="location.href='{{ route('ortho.menus.index') }}'" value="メニューへ" />
            <input type="button" class="btn btn-sm btn-header" name="button" onclick="location.href='{{ route('ortho.logout') }}'" value="ログアウト" />
          </div>
        </div>
      </div>
    </header>
  <!-- End Header -->
  
  <!-- Content belong regist -->
    @yield('content')
  <!-- End content belong regist -->

  <script src="{{ asset('') }}public/backend/ortho/common/js/jquery.min.js"></script>
  <script src="{{ asset('') }}public/backend/ortho/common/js/bootstrap.min.js"></script>
</body>
</html>