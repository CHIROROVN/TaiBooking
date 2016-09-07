@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.insurances.edit', $insurance->insurance_id], 'enctype'=>'multipart/form-data')) !!}
<div class="content-page">
  <h3>ユーザー管理　＞　登録済み保険診療の編集</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="col-title"><label for="insurance_name">保険診療名 <span class="note_required">※</span></label></td>
        <td>
          @if ( old('insurance_name') )
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="{{ old('insurance_name') }}" />
          @elseif ( $insurance->insurance_name )
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="{{ $insurance->insurance_name }}" />
          @else
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="" />
          @endif
          
          <span class="error-input">@if ($errors->first('insurance_name')) ※{!! $errors->first('insurance_name') !!} @endif</span>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
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
              <a href="{{ route('ortho.insurances.delete', [$insurance->insurance_id]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
              <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
    </div>
  </div>
  <div class="row">
    <div class="text-center">
      <input type="submit" name="button" value="登録済み保険診療一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{ route('ortho.insurances.index') }}'">
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection