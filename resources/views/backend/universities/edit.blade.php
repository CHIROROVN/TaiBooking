@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => array('backend.universities.edit', $university->univ_id), 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="univ_code">大学コード <span class="note_required">※</span></label></td>
          <td>
            @if ( old('univ_code') )
            <input name="univ_code" id="univ_code" type="text" class="form-control form-control--small" value="{{ old('univ_code') }}">
            @elseif ( $university->univ_code )
            <input name="univ_code" id="univ_code" type="text" class="form-control form-control--small" value="{{ $university->univ_code }}">
            @else
            <input name="univ_code" id="univ_code" type="text" class="form-control form-control--small" value="">
            @endif
            @if ($errors->first('univ_code'))<span class="error-input">{!! $errors->first('univ_code') !!}</span>@endif
          </td>

          <td class="col-title"><label for="univ_name">大学名 <span class="note_required">※</span></label></td>
          <td>
            @if ( old('univ_name') )
            <input name="univ_name" id="univ_name" type="text" class="form-control form-control--default" value="{{ old('univ_name') }}">
            @elseif ( $university->univ_name )
            <input name="univ_name" id="univ_name" type="text" class="form-control form-control--default" value="{{ $university->univ_name }}">
            @else
            <input name="univ_name" id="univ_name" type="text" class="form-control form-control--default" value="">
            @endif
            @if ($errors->first('univ_name'))<span class="error-input">{!! $errors->first('univ_name') !!}</span>@endif
          </td>

          <td class="col-title"><label for="univ_name_kana">大学名かな <span class="note_required">※</span></label></td>
          <td>
            @if ( old('univ_name_kana') )
            <input name="univ_name_kana" id="univ_name_kana" type="text" class="form-control form-control--default" value="{{ old('univ_name_kana') }}">
            @elseif ( $university->univ_name_kana )
            <input name="univ_name_kana" id="univ_name_kana" type="text" class="form-control form-control--default" value="{{ $university->univ_name_kana }}">
            @else
            <input name="univ_name_kana" id="univ_name_kana" type="text" class="form-control form-control--default" value="">
            @endif
            @if ($errors->first('univ_name_kana'))<span class="error-input">{!! $errors->first('univ_name_kana') !!}</span>@endif
          </td>
        </tr>

        <tr>
          <td class="col-title"><label for="univ_pref_id">都道府県 <span class="note_required">※</span></label></td>
          <td colspan="5">
            <select name="univ_pref_id" id="univ_pref_id" class="form-control form-control--small">
              @foreach ( $prefs as $pref )
                @if ( old('univ_pref_id') == $pref->pref_id )
                <option value="{{ $pref->pref_id }}" selected="">{{ $pref->pref_name }}</option>
                @elseif ( $university->univ_pref_id == $pref->pref_id )
                <option value="{{ $pref->pref_id }}" selected="">{{ $pref->pref_name }}</option>
                @else
                <option value="{{ $pref->pref_id }}">{{ $pref->pref_name }}</option>
                @endif
              @endforeach
            </select>
            @if ($errors->first('univ_pref_id'))<span class="error-input">{!! $errors->first('univ_pref_id') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <!-- search -->
      <input type="hidden" name="s_univ_code" value="{{ $s_univ_code }}">
      <input type="hidden" name="s_univ_name" value="{{ $s_univ_name }}">
      @if ( isset($s_univ_pref_id) )
        @foreach ( $s_univ_pref_id as $item )
          <input type="hidden" name="s_univ_pref_id[]" value="{{ $item }}">
        @endforeach
      @endif
      <input type="hidden" name="page" value="{{ $page }}">
      <!-- save -->
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
      <!-- delete -->
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $pref->pref_id }}">削除</button>
      <!-- popup -->
      <div class="modal fade bs-example-modal-sm" id="myModal-{{ $pref->pref_id }}" role="dialog">
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
              <a href="{{ route('backend.baitais.delete', array($pref->pref_id, 
                's_univ_code'         => $s_univ_code,
                's_univ_name'         => $s_univ_name,
                's_univ_pref_id'     => $s_univ_pref_id,
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
      <input onclick="location.href='{{ route('backend.universities.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection