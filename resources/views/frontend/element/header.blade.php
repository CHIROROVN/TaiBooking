<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="widtd=device-widtd, initial-scale=1">
    <title>キッズ業務管理システム</title>

    <!-- Bootstrap -->
    <link href="{{asset('public/backend/common/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('public/backend/common/css/page.css') }}" rel="stylesheet">

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
            <h1 class="fl-left">進学ナビ資料請求管理システム</h1>
          </div>
          <div class="col-md-6">
            <div class="fl-right mar-left40">
              <input type="button" class="btn btn-sm btn-info" name="button" value="ログアウト" onclick='location.href="{{URL::route('frontend.users.logout')}}"'/>
            </div>
            <div class="fl-right mar-top5">ようこそ、岡山理科大学・山田花子さん（<a href="{{URL::route('frontend.customer.detail')}}" class="text-orange">登録内容の参照</a> / <a href="{{URL::route('frontend.users.change_passwd')}}" class="text-orange">パスワード変更</a>）</div>
          </div>
        </div>
      </div>
    </header>
    <!-- End Header -->