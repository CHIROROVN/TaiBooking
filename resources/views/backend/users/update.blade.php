@extends('backend.backend')

@section('content')
	<!-- content baitai regist -->
	{!! Form::open( ['id' => 'frmProUpdate', 'class' => 'form-horizontal','method' => 'post', 'route' => ['backend.users.update', $user->u_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
   
    <section id="page">
      <div class="container">
        <div class="row content">        
        <div class="msg-alert-action">        
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
        <?php $power =  json_decode($user->u_power, true);?>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="u_name">名前 <span class="note_required">※</span></label></td>
                <td>
                  <input name="u_name" id="u_name" type="text" class="form-control form-control--default" value="{{$user->u_name}}">
                  @if ($errors->first('u_name'))
                    <div class="help-block with-errors">※ {!! $errors->first('u_name') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="u_login">ユーザーID <span class="note_required">※</span></label></td>
                <td>
                  <input name="u_login" id="u_login" type="text" class="form-control form-control--default" value="{{$user->u_login}}">
                  @if ($errors->first('u_login'))
                    <div class="help-block with-errors">※ {!! $errors->first('u_login') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="u_passwd">パスワード <span class="note_required">※</span></label></td>
                <td>
                  <input name="u_passwd" id="u_passwd" type="password" class="form-control form-control--default" value="">
                  @if ($errors->first('u_passwd'))
                    <div class="help-block with-errors">※ {!! $errors->first('u_passwd') !!}</div>
                  @endif
                </td>
              </tr>
              <tr>
                <td class="col-title"><label for="u_belong">所属</label></td>
                <td>
                  <input name="u_belong" id="u_belong" type="text" class="form-control form-control--default" value="{{$user->u_belong}}">
                  @if ($errors->first('u_belong'))
                    <div class="help-block with-errors">※ {!! $errors->first('u_belong') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="u_power">権限 <span class="note_required">※</span></label></td>
                <td colspan="5">
                  <input name="u_power[000]" id="ckAdmin" value="000" type="checkbox" @if (@$power['000']) checked="checked" @endif > Ｓ管理者　　
                  <input name="u_power[010]" id="ckManagement" value="010" type="checkbox" @if (@$power['010']) checked="checked" @endif > 管理　　　
                  <input name="u_power[020]" id="ckSale" value="020" type="checkbox" @if (@$power['020']) checked="checked" @endif > 営業　　　
                  <input name="u_power[030]" id="ckPrint" value="030" type="checkbox" @if (@$power['030']) checked="checked" @endif > 印刷　　　　
                  <input name="u_power[040]" id="ckchina" value="040" type="checkbox" @if (@$power['040']) checked="checked" @endif > 中国                  
                  @if ($errors->first('u_power'))
                    <div class="help-block with-errors">※ {!! $errors->first('u_power') !!}</div>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input type="hidden" name="page" value="{{ $page }}">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-primary">
            <!-- delete -->
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $user->u_id }}">削除</button>
            <!-- popup -->
            <div class="modal fade bs-example-modal-sm" id="myModal-{{ $user->u_id }}" role="dialog">
              <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                  </div>
                  <div class="modal-body">
                    <p>{{ trans('common.modal_content_delete') }}</p>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ route('backend.users.delete', array($user->u_id, 'page' => $page)) }}" class="btn btn-xs btn-primary">削除</a>
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
                <!-- End Modal content-->
              </div>
            </div>
            <!-- end popup -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{ route('backend.users.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    {!! Form::close() !!}
    <!-- End content baitai regist -->
@endsection