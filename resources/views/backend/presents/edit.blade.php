@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => array('backend.presents.edit', $present->presentlist_id), 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="present_code">プレゼントコード <span class="note_required">※</span></label></td>
          <td>
            <input name="present_code" id="present_code" type="text" class="form-control form-control--small" maxlength="3" value="{{ $present->present_code }}">
            @if ($errors->first('present_code'))<span class="error-input">※{!! $errors->first('present_code') !!}</span>@endif
          </td>
          <td class="col-title"><label for="present_name">プレゼント名 <span class="note_required">※</span></label></td>
          <td>
            <input name="present_name" id="present_name" type="text" class="form-control form-control--default" value="{{ $present->present_name }}">
            @if ($errors->first('present_name'))<span class="error-input">※{!! $errors->first('present_name') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input type="hidden" name="page" value="{{ $page }}">
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
      <!-- delete -->
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $present->presentlist_id }}">削除</button>
      <!-- popup -->
      <div class="modal fade bs-example-modal-sm" id="myModal-{{ $present->presentlist_id }}" role="dialog">
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
              <a href="{{ route('backend.presents.delete', [$present->presentlist_id, 'page' => $page]) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
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
      <input onclick="location.href='{{ route('backend.presents.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection