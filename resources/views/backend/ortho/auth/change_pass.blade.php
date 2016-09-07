@extends('backend.ortho.ortho')

@section('content')
    <!-- change password -->
  <section id="page">
      <div class="container">
        <div class="row content content--changepass">
          <div class="col-md-12">
            <h1>パスワードを変更する</h1>

            <div class="msg-alert-action margin-top-15">
              @if ($message = Session::get('success'))
                <div class="alert alert-success  alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
                </div>
              @elseif($message = Session::get('danger'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
                </div>
              @endif
            </div>

            {!! Form::open(array('route' => ['ortho.change.password', Auth::user()->id], 'method' => 'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}
              <!-- current username -->
              <div class="form-group">
                <label class="col-md-3 control-label" for="u_login">ログインID</label>
                <div class="col-md-6">
                  <!-- <input type="text" name="u_login" class="form-control" id="u_login" value="{{ old('u_login') }}"> -->
                  <label class="control-label">{{ Auth::user()->u_login }}</label>
                </div>
              </div>

              <!-- current password -->
              <div class="form-group">
                <label class="col-md-3 control-label" for="password">現在のパスワード <span class="note_required">※</span></label>
                <div class="col-md-6">
                  <input type="password" name="password" class="form-control" id="password">
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('password')) ※{!! $errors->first('password') !!} @endif</li></ul></div>
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($message = Session::get('password-wrong')) {{ $message }} @endif</li></ul></div>
                </div>
              </div>

              <!-- confim current password -->
              <div class="form-group">
                <label class="col-md-3 control-label" for="new_password">新しいパスワード <span class="note_required">※</span></label>
                <div class="col-md-6">
                  <input type="password" name="new_password" class="form-control" id="new_password">
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('new_password')) ※{!! $errors->first('new_password') !!} @endif</li></ul></div>
                </div>
              </div>
              
              <!-- new password -->
              <div class="form-group">
                <label class="col-md-3 control-label" for="confim_new_password">新しいパスワードの確認 <span class="note_required">※</span></label>
                <div class="col-md-6">
                  <input type="password" name="confim_new_password" class="form-control" id="confim_new_password">
                  <div class="help-block with-errors"><ul class="list-unstyled"><li>@if ($errors->first('confim_new_password')) ※{!! $errors->first('confim_new_password') !!} @endif</li></ul></div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-offset-3 col-md-6">
                  <button type="submit" class="btn btn-primary btn-page">変更する</button>
                  <button type="reset" class="btn btn-default btn-page">リセット</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- End change password -->
@endsection