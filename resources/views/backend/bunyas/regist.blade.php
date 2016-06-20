@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.bunyas.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="bunya_code">分野コード <span class="note_required">※</span></label></td>
          <td>
            <input name="bunya_code" id="bunya_code" type="text" class="form-control form-control--small" value="{{ old('bunya_code') }}">
            @if ($errors->first('bunya_code'))<span class="error-input">{!! $errors->first('bunya_code') !!}</span>@endif
          </td>
          <td class="col-title"><label for="bunya_name">分野名 <span class="note_required">※</span></label></td>
          <td>
            <input name="bunya_name" id="bunya_name" type="text" class="form-control form-control--default" value="{{ old('bunya_name') }}">
            @if ($errors->first('bunya_name'))<span class="error-input">{!! $errors->first('bunya_name') !!}</span>@endif
          </td>
          <td class="col-title"><label for="rdType">種類 <span class="note_required">※</span></label></td>
          <td>
            <input name="bunya_kind" id="rdType" value="1" type="radio" @if(old('bunya_kind') == 1) {{'checked'}} @endif> 職業　　　
            <input name="bunya_kind" value="2" type="radio" @if(old('bunya_kind') == 2) {{'checked'}} @endif> 学問
            @if ($errors->first('bunya_kind'))<span class="error-input">{!! $errors->first('bunya_kind') !!}</span>@endif
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="rdClassification">区分 <span class="note_required">※</span></label></td>
          <td colspan="5">
            <input name="bunya_class" id="rdClassification" value="1" type="radio" @if(old('bunya_class') == 1) {{'checked'}} @endif> メイン　　　
            <input name="bunya_class" value="2" type="radio" @if(old('bunya_class') == 2) {{'checked'}} @endif> サブ
            @if ($errors->first('bunya_class'))<span class="error-input">{!! $errors->first('bunya_class') !!}</span>@endif
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
      <input onclick="location.href='{{ route('backend.bunyas.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection