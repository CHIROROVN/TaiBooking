@extends('backend.ortho.ortho')

@section('content')
    {!! Form::open(array('url' => 'ortho/belongs/regist', 'method' => 'post')) !!}
      <section id="page">
        <div class="container">

          <!-- belong_name -->
          <div class="row content-page">
            <h3>ユーザー管理　＞　所属の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <!-- belong_name -->
                  <tr>
                    <td class="col-title"><label for="belong_name">所属名 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="text" name="belong_name" id="belong_name " class="form-control" value="{{ old('belong_name') }}" />
                      <span class="error-input">@if ($errors->first('belong_name')) ※{!! $errors->first('belong_name') !!} @endif</span>
                    </td>
                  </tr>
                  <!-- belong_kind -->
                  <tr>
                    <td class="col-title"><label for="belong_kind">所属区分 <span class="note_required">※</span></label></td>
                    <td>
                      <select name="belong_kind" id="belong_kind" class="form-control form-control--small">
                        <option value="1" @if(old('belong_kind') == 1) selected="" @endif>医師</option>
                        <option value="2" @if(old('belong_kind') == 2) selected="" @endif>衛生士（相談業務あり）</option>
                        <option value="3" @if(old('belong_kind') == 3) selected="" @endif>衛生士（相談業務なし）</option>
                        <option value="4" @if(old('belong_kind') == 4) selected="" @endif>事務</option>
                        <option value="5" @if(old('belong_kind') == 5) selected="" @endif>受付</option>
                        <option value="6" @if(old('belong_kind') == 6) selected="" @endif>放射線技師</option>
                        <option value="7" @if(old('belong_kind') == 7) selected="" @endif>滅菌</option>
                      </select>
                      <span class="error-input">@if ($errors->first('belong_kind')) ※{!! $errors->first('belong_kind') !!} @endif</span>
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