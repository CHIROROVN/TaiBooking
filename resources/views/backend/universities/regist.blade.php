@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.universities.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="univ_code">大学コード <span class="note_required">※</span></label></td>
          <td>
            <input name="univ_code" id="univ_code" type="text" class="form-control form-control--small" value="{{ old('univ_code') }}">
            @if ($errors->first('univ_code'))<span class="error-input">{!! $errors->first('univ_code') !!}</span>@endif
          </td>
          <td class="col-title"><label for="univ_name">大学名 <span class="note_required">※</span></label></td>
          <td>
            <input name="univ_name" id="univ_name" type="text" class="form-control form-control--default" value="{{ old('univ_name') }}">
            @if ($errors->first('univ_name'))<span class="error-input">{!! $errors->first('univ_name') !!}</span>@endif
          </td>
          <td class="col-title"><label for="univ_name_kana">大学名かな <span class="note_required">※</span></label></td>
          <td>
            <input name="univ_name_kana" id="univ_name_kana" type="text" class="form-control form-control--default" value="{{ old('univ_name_kana') }}">
            @if ($errors->first('univ_name_kana'))<span class="error-input">{!! $errors->first('univ_name_kana') !!}</span>@endif
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="univ_pref_id">都道府県 <span class="note_required">※</span></label></td>
          <td colspan="5">
            <select name="univ_pref_id" id="univ_pref_id" class="form-control form-control--small">
              @foreach ( $prefs as $pref )
              <option value="{{ $pref->pref_id }}">{{ $pref->pref_name }}</option>}
              option
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
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
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