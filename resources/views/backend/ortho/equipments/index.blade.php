@extends('backend.ortho.ortho')

@section('content')
<!-- Content equipment list -->
    <div class="content-page">
    <div class="msg-alert-action">
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

      <h3>共通マスタ管理　＞　登録済み装置の一覧</h3>
      <div class="row">
          <div class="col-md-12 text-right">
            <input type="button" name="button" value="業務名の新規登録" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.equipments.regist')}}'">
          </div>
      </div>
      <table class="table table-bordered table-striped treatment2-list">
        <tbody>
          <tr>
              <td align="center" class="col-title">装置名</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
          <?php 
            $i = 0;
            $max = count($equipments);
          ?>
            @if($max > 0)
              @foreach($equipments as $equipment)
              <?php $i++; ?>
                <tr>
                  <td>{{$equipment->equipment_name}}</td>
                  <td align="center"><a href="{{route('ortho.equipments.edit', $equipment->equipment_id)}}" class="btn btn-sm btn-edit">編集</a></td>
                  <td align="center">
                    <button onclick="location.href='{{ url('ortho/equipments/orderby-top?id=' . $equipment->equipment_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">TOP
                  </td>
                  <td align="center" class="">
                    <button onclick="location.href='{{ url('ortho/equipments/orderby-up?id=' . $equipment->equipment_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">↑</button>
                  </td>
                  <td align="center">
                    <button onclick="location.href='{{ url('ortho/equipments/orderby-down?id=' . $equipment->equipment_id) }}'" class="@if($i == $max) {{'hidden'}} @endif">↓</button>
                  </td>
                  <td align="center" class="">
                    <button onclick="location.href='{{ url('ortho/equipments/orderby-last?id=' . $equipment->equipment_id) }}'" class="@if($i == $max) {{'hidden'}} @endif">LAST</button>
                  </td>

                </tr>
              @endforeach
            @else
              <tr><td colspan="3" style="text-align: center;">該当するデータがありません。</td></tr>
            @endif
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-12 text-right">
          <input type="button" name="button" value="業務名の新規登録" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.equipments.regist')}}'">
        </div>
      </div>
    </div>
  <!-- End content equipment list -->
@endsection
