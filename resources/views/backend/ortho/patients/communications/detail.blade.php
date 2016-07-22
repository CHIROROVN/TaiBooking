@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>患者情報管理　＞　コミュニケーションノート</h3>

      <div class="table-responsive">
        <table class="table table-bordered">
          <!-- com_title -->
          <tr>
            <td class="col-title">タイトル</td>
            <td>{{ $communication->com_title }}</td>
          </tr>

          <!-- com_contents -->
          <tr>
            <td class="col-title">詳細</td>
            <td><?php echo nl2br($communication->com_contents);?></td>
          </tr>
        </table>
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.patients.communications.edit', [$communication->com_id, $patient_id ]) }}'" name="button" id="button" value="変更する" type="button" class="btn btn-sm btn-page mar-right">
        <input onclick="location.href='{{ route('ortho.patients.communications.delete', [$communication->com_id, $patient_id ]) }}'" name="button2" id="button2" value="削除する" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.patients.communications.index', [ $patient_id ]) }}'" value="ノート一覧に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
@endsection