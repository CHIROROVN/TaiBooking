@extends('backend.backend')

@section('content')
<section id="login">
  <div class="container">
    <div class="content-login">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1>ログイン</h1>
        <!-- <form class="form-horizontal"> -->
        {!! Form::open(array('route' => 'backend.login', 'class' => 'form-horizontal')) !!}
          <div class="form-group">
            <label class="col-xs-12 col-md-4 control-label" for="u_login">ログインID</label>
            <div class="col-xs-12 col-md-6">
              <input type="text" class="form-control" id="u_login" name="u_login" value="{{ old('u_login') }}" >
              <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('u_login')) {!! $errors->first('u_login') !!} @endif</li></ul></div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-md-4 control-label" for="u_password" >パスワード</label>
            <div class="col-xs-12 col-md-6">
              <input type="password" class="form-control" id="u_password" name="u_password" value="" >
              <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('u_password')) {!! $errors->first('u_password') !!} @endif</li></ul></div>
              @if (Session::has('error'))
              <div class="help-block with-errors"><ul class="list-unstyled"><li>
                {{ Session::get('error') }}
              </li></ul></div>
              @endif
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-4"></div>
            <div class="col-xs-12 col-md-6">
              <button type="submit" class="btn btn-blue">ログイン</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
@endsection