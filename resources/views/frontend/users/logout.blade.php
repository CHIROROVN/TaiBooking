@extends('frontend.frontend')

@section('content')
    <!-- content logout -->
    <section id="page">
      <div class="container">
        <div class="row content mar-bottom30 content--list">
          <h3>ログアウト</h3>
          <p class="text-center">正常にログアウトしました。</p>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <a href="{{URL::route('frontend.users.login')}}" class="btn btn-sm btn-primary">ログイン画面へ</a>
          </div>
        </div>
      </div>
    </section>
    <!-- End content logout -->
@endsection