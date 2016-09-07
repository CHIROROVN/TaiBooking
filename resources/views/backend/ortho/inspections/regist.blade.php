@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => 'ortho.inspections.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="content-page">
  <h3>共通マスタ管理　＞　検査の新規登録</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="col-title"><label for="inspection_name">検査名 <span class="note_required">※</span></label></td>
        <td>
          <input class="form-control" type="text" name="inspection_name" id="inspection_name" value="{{ old('inspection_name') }}" />
          <span class="error-input">@if ($errors->first('inspection_name')) ※{!! $errors->first('inspection_name') !!} @endif</span>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
    </div>
  </div>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="button" name="button" value="登録済み検査一覧に戻る" class="btn btn-sm btn-page mar-right" onclick="location.href='{{ route('ortho.inspections.index') }}'">
    </div>
  </div>
</div>
{!! Form::close() !!}
@endsection