@extends('ortho.ortho')

@section('content')
    {!! Form::open(array('url' => 'ortho/belongs/regist', 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>ユーザー管理　＞　所属の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="belong_name">所属名 (*)</label></td>
                    <td>
                      <input type="text" name="belong_name" id="belong_name " class="form-control" value="{{ old('belong_name') }}" />
                      <span class="error-input">@if ($errors->first('belong_name')) {!! $errors->first('belong_name') !!} @endif</span>
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
              <a href="{{ asset('ortho/belongs') }}" class="btn btn-sm btn-page mar-right">登録済み所属一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@endsection