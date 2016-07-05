@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.patients.communications.regist', $patient_id], 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page content--patient-brother">
      <h3>患者情報管理　＞　コミュニケーションノート</h3>
        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- p_id -->
            <input type="hidden" name="p_id" value="{{ $patient_id }}">

            <!-- com_title -->
            <tr>
              <td class="col-title"><label for="com_title">タイトル</label></td>
              <td>
                <input type="text" name="com_title" id="com_title" class="form-control form-control--default" value="{{ old('com_title') }}" />
                <span class="error-input">@if ($errors->first('com_title')) {!! $errors->first('com_title') !!} @endif</span>
              </td>
            </tr>

            <!-- com_contents -->
            <tr>
              <td class="col-title"><label for="com_contents">詳細</label></td>
              <td>
                <textarea name="com_contents" rows="10" id="com_contents" class="form-control">{{ old('com_contents') }}</textarea>
                <span class="error-input">@if ($errors->first('com_contents')) {!! $errors->first('com_contents') !!} @endif</span>
              </td>
            </tr>
          </table>
        </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="" id="" value="登録する" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.patients.communications.index', [ $patient_id ]) }}'" value="ノート一覧に戻る" type="button" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
{!! Form::close() !!}

@endsection