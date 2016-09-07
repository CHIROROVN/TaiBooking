@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.inspections.edit', $inspection->inspection_id], 'enctype'=>'multipart/form-data')) !!}
<div class="content-page">
  <h3>ユーザー管理　＞　登録済み検査の編集</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="col-title"><label for="inspection_name">検査名 <span class="note_required">※</span></label></td>
        <td>
          @if ( old('inspection_name') )
          <input class="form-control" type="text" name="inspection_name" id="inspection_name" value="{{ old('inspection_name') }}" />
          @elseif ( $inspection->inspection_name )
          <input class="form-control" type="text" name="inspection_name" id="inspection_name" value="{{ $inspection->inspection_name }}" />
          @else
          <input class="form-control" type="text" name="inspection_name" id="inspection_name" value="" />
          @endif
          
          <span class="error-input">@if ($errors->first('inspection_name')) ※{!! $errors->first('inspection_name') !!} @endif</span>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
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
              <a href="{{ route('ortho.inspections.delete', [$inspection->inspection_id]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
              <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
    </div>
  </div>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録済み検査一覧に戻る" class="btn btn-sm btn-page mar-right" onclick="location.href='{{ route('ortho.inspections.index') }}'">
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection