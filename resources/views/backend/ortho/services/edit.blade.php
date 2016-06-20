@extends('backend.ortho.ortho')

@section('content')
<!-- Content service edit -->
    <div class="content-page">
          <div class="msg-alert-action">
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
      <h3>ユーザー管理　＞　登録済み業務名の編集</h3>
      {!! Form::open( ['id' => 'frmServiceEdit', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.services.edit', $service->service_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="service_name">業務名 <span class="note_required">※</span></label></label></td>
            <td>
              <input class="form-control" type="text" name="service_name" id="service_name" value="@if(old('service_name')) {{old('service_name')}}@else{{$service->service_name}}@endif" />
              @if ($errors->first('service_name'))
                    <span class="error-input">※ {!! $errors->first('service_name') !!}</span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="button" value="保存する" class="btn btn-sm btn-page mar-right">
              <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{trans('common.modal_content_delete')}}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.services.delete', $service->service_id) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Modal -->
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="button" name="button" value="登録済み業務名一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.services.index')}}'">
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  <!-- End content service edit -->
  @endsection