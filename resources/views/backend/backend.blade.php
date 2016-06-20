<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1">
    <title>キッズ業務管理システム</title>

    <!-- Bootstrap -->
    <link href="{{ asset('') }}public/backend/common/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('') }}public/backend/common/css/jquery-ui.css" rel="stylesheet">
    <link href="{{ asset('') }}public/backend/common/css/page.css" rel="stylesheet">
    <link href="{{ asset('public/backend/common/css/style.css')}}" rel="stylesheet">

    <!-- <script src="{{ asset('') }}/public/backend/common/js/jquery-1.9.1.min.js"></script> -->
    <!-- End content burya list -->
    <!-- <script src="{{ asset('') }}/public/backend/common/js/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="{{ asset('') }}/public/backend/common/js/bootstrap.min.js"></script>
    <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <!-- <script src="{{ asset('') }}/public/backend/common/js/me.jquery.js"></script> -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <h1 class="fl-left">キッズコーポレーション業務管理システム</h1>
            <h1 class="fl-right">{{@$title}}</h1>
          </div>
          @if(Auth::check())
          <div class="col-md-6">
            <div class="fl-right mar-left40">
              <input type="button" class="btn btn-sm btn-info  btn-mar-right" name="button2" value="メニューへ" onclick="location.href='{{ route('backend.menu') }}'"/><input type="button" class="btn btn-sm btn-info" name="button" value="ログアウト" onclick="location.href='{{ route('backend.logout') }}'"/>
            </div>
            <div class="fl-right mar-top5">ようこそ、{{@Auth::user()->u_name}}さん（<a href="{{URL::route('backend.users.change_passwd')}}" class="text-orange">パスワード変更</a>）</div>
          </div>
          @endif
        </div>
      </div>
    </header>
    <!-- End Header -->
    <!-- content burya list -->
    <section id="page">

      <!-- content -->
      @yield('content')
      <!-- end content -->

    </section>
    
  </body>
</html>