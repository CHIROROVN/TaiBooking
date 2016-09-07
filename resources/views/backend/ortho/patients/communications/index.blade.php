@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>患者情報管理　＞　コミュニケーションノート</h3>

    <div class="msg-alert-action margin-top-15">
      @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @elseif($message = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @endif
    </div>

    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title">患者名</td>
          <td><span class="mar-right">{{ $patient->p_name_f }} {{ $patient->p_name_g }}</span> <input onclick="location.href='{{ route('ortho.patients.detail', [ $patient->p_id ]) }}'" value="詳細表示" type="button"class="btn btn-xs btn-page"></td>
        </tr>
        <tr>
          <td class="col-title">担当</td>
          <td>{{ $patient->u_name }}</td>
        </tr>
        <tr>
          <td class="col-title">医院関連メモ</td>
          <td>{{ $patient->p_clinic_memo }}</td>
        </tr>
        <tr>
          <td class="col-title">個人情報メモ</td>
          <td>{{ $patient->p_personal_memo }}</td>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-md-12 text-right">
        <input onclick="location.href='{{ route('ortho.patients.communications.regist', [ $patient->p_id ]) }}'" value="ノートの新規登録" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td class="col-title" align="center">タイトル</td>
          <td class="col-title" align="center">日付</td>
          <td class="col-title" align="center">入力者</td>
          <td class="col-title" align="center">詳細</td>
        </tr>
        @if ( empty($communications) || count($communications) == 0 )
        <tr>
          <td colspan="8" align="center">{{ trans('common.no_data_correspond') }}</td>
        </tr>
        @else
          @foreach ( $communications as $communication )
          <tr>
            <td>{{ $communication->com_title }}</td>
            <td>{{ $communication->last_date }}</td>
            <td>{{ $communication->u_name }}</td>
            <td align="center">
              <input onclick="location.href='{{ route('ortho.patients.communications.detail', [ $communication->com_id, $patient->p_id ]) }}'" value="詳細" type="button" class="btn btn-xs btn-page"/>
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.patients.index') }}'" value="患者一覧に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
@endsection