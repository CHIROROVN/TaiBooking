@extends('backend.ortho.ortho')

@section('content')
    {!! Form::open(array('url' => 'ortho/belongs/edit/' . $belong->belong_id, 'method' => 'post')) !!}
      <section id="page">
        <div class="container">

          <div class="row content-page">
            <h3>ユーザー管理　＞　所属の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="belong_name">所属名 (*)</label></td>
                    <td>
                      <input type="text" name="belong_name" id="belong_name " class="form-control" value="{{ $belong->belong_name }}" />
                      <span class="error-input">@if ($errors->first('belong_name')) {!! $errors->first('belong_name') !!} @endif</span>
                    </td>
                  </tr>
                  <!-- belong_kind -->
                  <tr>
                    <td class="col-title"><label for="belong_kind">所属区分 (*)</label></td>
                    <td>
                      <select name="belong_kind" id="belong_kind" class="form-control form-control--small">
                        <option value="1" @if($belong->belong_kind == 1) selected="" @endif>医師</option>
                        <option value="2" @if($belong->belong_kind == 2) selected="" @endif>衛生士（相談業務あり）</option>
                        <option value="3" @if($belong->belong_kind == 3) selected="" @endif>衛生士（相談業務なし）</option>
                        <option value="4" @if($belong->belong_kind == 4) selected="" @endif>事務</option>
                        <option value="5" @if($belong->belong_kind == 5) selected="" @endif>受付</option>
                        <option value="6" @if($belong->belong_kind == 6) selected="" @endif>放射線技師</option>
                        <option value="7" @if($belong->belong_kind == 7) selected="" @endif>滅菌</option>
                      </select>
                      <span class="error-input">@if ($errors->first('belong_kind')) {!! $errors->first('belong_kind') !!} @endif</span>
                    </td>
                  </tr>
                </table>
              </div>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page">
              <!-- Trigger the modal with a button -->
              <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ asset('ortho/belongs/delete/' . $belong->belong_id) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ asset('ortho/belongs') }}" class="btn btn-sm btn-page">登録済み所属一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@endsection