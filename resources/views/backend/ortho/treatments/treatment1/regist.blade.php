@extends('backend.ortho.ortho')

@section('content')
	<!-- Content treatment1 regist -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　治療内容の新規登録</h3>
      {!! Form::open(array('route' => ['ortho.treatments.treatment1.regist'], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="treatment_name">治療内容 <span class="note_required">※</span></label></td>
            <td>
              <input class="form-control" type="text" name="treatment_name" id="treatment_name" />
              @if ($errors->first('treatment_name'))
                    <span class="error-input">※ {!! $errors->first('treatment_name') !!}</span>
              @endif
            </td>
          </tr>
          <tr>
            <td class="col-title"><label for="treatment_time">時間 <span class="note_required">※</span></label></td>
            <td>
              <select id="treatment_time" name="treatment_time">
                <option value="15">15分</option>
                <option value="30">30分</option>
                <option value="45">45分</option>
                <option value="60">60分</option>
                <option value="75">75分</option>
                <option value="90">90分</option>
                <option value="105">105分</option>
                <option value="120">120分</option>
              </select>
              @if ($errors->first('treatment_time'))
                    <span class="error-input">※ {!! $errors->first('treatment_time') !!}</span>
              @endif
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
          <input type="button" name="btnBack" value="登録済み治療内容一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.treatments.treatment1.index')}}'">
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  <!-- End content treatment1 regist -->
@endsection