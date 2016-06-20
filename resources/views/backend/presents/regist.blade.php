@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.presents.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="present_code">プレゼントコード <span class="note_required">※</span></label></td>
          <td>
            <input name="present_code" id="present_code" type="text" class="form-control form-control--small" maxlength="3" value="{{ old('present_code') }}">
            @if ($errors->first('present_code'))<span class="error-input">※{!! $errors->first('present_code') !!}</span>@endif
          </td>
          <td class="col-title"><label for="present_name">プレゼント名 <span class="note_required">※</span></label></td>
          <td>
            <input name="present_name" id="present_name" type="text" class="form-control form-control--default" value="{{ old('present_name') }}">
            @if ($errors->first('present_name'))<span class="error-input">※{!! $errors->first('present_name') !!}</span>@endif
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
      <input onclick="location.href='{{ route('backend.presents.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection