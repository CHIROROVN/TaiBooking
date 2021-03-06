@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => 'ortho.interviews.set', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>初診業務　＞　初診者の登録</h3>

      <div class="table-responsive">
        <table class="table table-bordered">
          <!-- p_name -->
          <tr>
            <td class="col-title"><label for="p_name_f">初診者の名前 <span class="note_required">※</span></label></td>
            <td>
              <input type="text" name="p_name_f" id="p_name_f" class="form-control form-control--medium" value="{{ old('p_name_f') }}" />
              <input type="text" name="p_name_g" id="p_name_g" class="form-control form-control--medium" value="{{ old('p_name_g') }}" />
              <span class="error-input">@if ($errors->first('p_name_f')) ※{!! $errors->first('p_name_f') !!} @endif</span>
              <span class="error-input">@if ($errors->first('p_name_g')) ※{!! $errors->first('p_name_g') !!} @endif</span>
            </td>
          </tr>

          <!-- p_name_kana -->
          <tr>
            <td class="col-title"><label for="p_name_f_kana">初診者よみ <span class="note_required">※</span></label></td>
            <td>
              <input type="text" name="p_name_f_kana" id="p_name_f_kana" class="form-control form-control--medium" value="{{ old('p_name_f_kana') }}" />
              <input type="text" name="p_name_g_kana" id="p_name_g_kana" class="form-control form-control--medium" value="{{ old('p_name_g_kana') }}" />
              <span class="error-input">@if ($errors->first('p_name_f_kana')) ※{!! $errors->first('p_name_f_kana') !!} @endif</span>
              <span class="error-input">@if ($errors->first('p_name_g_kana')) ※{!! $errors->first('p_name_g_kana') !!} @endif</span>
            </td>
          </tr>

          <!-- p_sex -->
          <tr>
            <td class="col-title">性別 <span class="note_required">※</span></td>
            <td>
              <div class="row">
                <div class="col-xs-4 col-sm-2 col-md-1">
                  <input type="radio" name="p_sex" value="1" @if(old('p_sex') == 1) checked="" @endif /> 男
                </div>
                <div class="col-xs-4 col-sm-2 col-md-1">
                  <input type="radio" name="p_sex" value="2" @if(old('p_sex') == 2) checked="" @endif /> 女
                </div>
              </div>
              <span class="error-input">@if ($errors->first('p_sex')) ※{!! $errors->first('p_sex') !!} @endif</span>
            </td>
          </tr>

          <!-- p_tel -->
          <tr>
            <td class="col-title"><label for="p_tel">電話番号 <span class="note_required">※</span></label></td>
            <td>
              <input type="text" name="p_tel" id="p_tel" class="form-control" value="{{ old('p_tel') }}" />
              <span class="error-input">@if ($errors->first('p_tel')) ※{!! $errors->first('p_tel') !!} @endif</span>
            </td>
          </tr>
          <tr>
        </table>
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="" id="button" value="登録する" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='{{ route('ortho.interviews.index') }}'" value="初診者一覧に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>
@endsection