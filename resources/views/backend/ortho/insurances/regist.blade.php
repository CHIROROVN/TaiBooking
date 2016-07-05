@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => 'ortho.insurances.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="content-page">
  <h3>共通マスタ管理　＞　保険診療の新規登録</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="col-title"><label for="insurance_name">保険診療名</label></td>
        <td>
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="{{ old('insurance_name') }}" />
          <span class="error-input">@if ($errors->first('insurance_name')) {!! $errors->first('insurance_name') !!} @endif</span>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
    </div>
  </div>
  <div class="row">
    <div class="text-center">
      <input type="button" name="button" value="登録済み保険診療一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{ route('ortho.insurances.index') }}'">
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection