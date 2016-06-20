@extends('backend.backend')

@section('content')
	<!-- content change pass -->
    <section id="page">
      <div class="container">      
        <div class="row content content--changepass">        
          <div class="col-md-12">
        	<div class="msg-alert">
  		        @if ($message = Session::get('success'))
  					<div class="alert alert-success  alert-dismissible fade in" role="alert">
  					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					    <span aria-hidden="true">&times;</span>
  					  </button>
  					  <ul><strong><li> {{ $message }}</li></strong></ul>
  					</div>
  				@elseif($message = Session::get('danger'))
  					<div class="alert alert-danger alert-dismissible fade in" role="alert">
  					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					    <span aria-hidden="true">&times;</span>
  					  </button>
  					  <ul><strong><li> {{ $message }}</li></strong></ul>
  					</div>
  				@endif
  			</div>
        {!! Form::open( ['id' => 'frmChangePasswd', 'class' => 'form-horizontal','method' => 'post', 'route' => 'backend.users.change_passwd', 'enctype'=>'multipart/form-data'] ) !!} 
          <label class="col-md-3 control-label" for="currpasswd">現在のパスワード <span class="note_required">※</span></label>
            <div class="form-group">
              <div class="col-md-6">
                <input type="password" name="currpasswd" class="form-control" id="currpasswd" value="{{old('currpasswd')}}">
                <div class="help-block with-errors">
                @if ($errors->first('currpasswd'))
                    <div class="help-block with-errors">※ {!! $errors->first('currpasswd') !!}</div>
                  @endif
                </div>
              </div>
            </div>
            <label class="col-md-3 control-label" for="newpasswd">新しいパスワード <span class="note_required">※</span></label>
            <div class="form-group">                
              <div class="col-md-6">
                <input type="password" name="newpasswd" class="form-control" id="newpasswd">
                <div class="help-block with-errors">
                  @if ($errors->first('newpasswd'))
                    <div class="help-block with-errors">※ {!! $errors->first('newpasswd') !!}</div>
                  @endif
                </div>
              </div>
            </div>
            <label class="col-md-3 control-label" for="confnewpasswd">新しいパスワード（確認）</label>
            <div class="form-group" >                
              <div class="col-md-6">
                <input type="password" name="confnewpasswd" class="form-control" id="confnewpasswd">
                <div class="help-block with-errors">
                  @if ($errors->first('confnewpasswd'))
                    <div class="help-block with-errors">※ {!! $errors->first('confnewpasswd') !!}</div>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary">&nbsp;&nbsp;更新&nbsp;&nbsp;</button>
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </section>
  <!-- End content change pass -->
@endsection