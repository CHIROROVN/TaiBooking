@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => array('backend.baitais.edit', $baitai->baitai_id), 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="baitai_code">媒体コード <span class="note_required">※</span></label></td>
          <td>
            <input name="baitai_code" id="baitai_code" type="text" class="form-control form-control--default" value="{{ $baitai->baitai_code }}">
            @if ($errors->first('baitai_code'))<span class="error-input">{!! $errors->first('baitai_code') !!}</span>@endif
          </td>
          <td class="col-title"><label for="baitai_name">媒体名 <span class="note_required">※</span></label></td>
          <td>
            <input name="baitai_name" id="baitai_name" type="text" class="form-control form-control--default" value="{{ $baitai->baitai_name }}">
            @if ($errors->first('baitai_name'))<span class="error-input">{!! $errors->first('baitai_name') !!}</span>@endif
          </td>
          <td class="col-title"><label for="rdNewOld">新旧<!-- 性別 --> <span class="note_required">※</span></label></td>
          <td>
            <input name="baitai_kind" id="rdNewOld" value="2" type="radio" @if($baitai->baitai_kind == 2) {{'checked'}} @endif> 新　　　
            <input name="baitai_kind" value="1" type="radio" @if($baitai->baitai_kind == 1) {{'checked'}} @endif> 旧
            @if ($errors->first('baitai_kind'))<span class="error-input">{!! $errors->first('baitai_kind') !!}</span>@endif
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="baitai_year">発行年</label></td>
          <td colspan="5">
            <input name="baitai_year" id="baitai_year" type="text" class="form-control form-control--small" value="{{ $baitai->baitai_year }}" maxlength="4">  年
            @if ($errors->first('baitai_year'))<span class="error-input">{!! $errors->first('baitai_year') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <!-- search -->
      <input type="hidden" name="s_baitai_code" value="{{ $s_baitai_code }}">
      <input type="hidden" name="s_baitai_name" value="{{ $s_baitai_name }}">
      <input type="hidden" name="s_baitai_kind_old" value="{{ $s_baitai_kind_old }}">
      <input type="hidden" name="s_baitai_kind_new" value="{{ $s_baitai_kind_new }}">
      <input type="hidden" name="s_baitai_year_begin" value="{{ $s_baitai_year_begin }}">
      <input type="hidden" name="s_baitai_year_end" value="{{ $s_baitai_year_end }}">
      <input type="hidden" name="page" value="{{ $page }}">
      <!-- save -->
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
      <!-- delete -->
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $baitai->baitai_id }}">削除</button>
      <!-- popup -->
      <div class="modal fade bs-example-modal-sm" id="myModal-{{ $baitai->baitai_id }}" role="dialog">
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
              <a href="{{ route('backend.baitais.delete', array($baitai->baitai_id, 
                      's_baitai_code'         => $s_baitai_code,
                      's_baitai_name'         => $s_baitai_name,
                      's_baitai_kind_old'     => $s_baitai_kind_old,
                      's_baitai_kind_new'     => $s_baitai_kind_new,
                      's_baitai_year_begin'   => $s_baitai_year_begin,
                      's_baitai_year_end'     => $s_baitai_year_end,
                      'page'                  => $page
                    )) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
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
      <input onclick="location.href='{{ route('backend.baitais.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection