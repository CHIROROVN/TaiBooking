@extends('ortho.ortho')

@section('content')
    {!! Form::open(array('url' => 'ortho/areas/regist', 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>共通マスタ管理　＞　地域の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="area_name">地域名 (*)</label></td>
                    <td>
                      <input type="text" name="area_name" id="area_name " class="form-control" value="{{ old('area_name') }}" />
                      <span class="error-input">@if ($errors->first('area_name')) {!! $errors->first('area_name') !!} @endif</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title">所属医院</td>
                    <td>
                      <div class="checkbox">
                        <label><input type="checkbox" name="clinic[]" value="-1" />たい矯正歯科</label>
                      </div>
                      @if(!empty($clinics) && count($clinics) > 0)
                        @foreach($clinics as $clinic)
                        <div class="checkbox">
                          <label><input type="checkbox" name="clinic[]" value="{{ $clinic->clinic_id }}" />{{ $clinic->clinic_name }}</label>
                        </div>
                        @endforeach
                      @endif
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ asset('ortho/areas') }}" class="btn btn-sm btn-page mar-right">登録済み地域一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@endsection