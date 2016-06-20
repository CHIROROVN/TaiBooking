@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>共通マスタ管理　＞　登録済み検査の一覧</h3>

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

    <div class="row">
      <div class="col-md-12 text-right">
        <a href="{{ route('ortho.inspections.regist') }}" class="btn btn-sm btn-page">検査の新規登録</a>
      </div>
    </div>
    
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr>
          <td align="center" class="col-title">検査名</td>
          <td align="center" class="col-title col-edit">編集</td>
          <td colspan="4" align="center" class="col-title col-action">表示順序</td>
        </tr>

        <?php 
          $i = 0;
          $max = count($inspections);
        ?>
        @if(empty($inspections) || count($inspections) < 1)
          <tr>
            <td colspan="6">
              <h3 align="center">該当するデータがありません。</h3>
            </td>
          </tr>
        @else
          @foreach($inspections as $inspection)
          <?php $i++; ?>
          <tr>
            <td>
              {{ $inspection->inspection_name }}
            </td>
            <td align="center">
              <a href="{{ route('ortho.inspections.edit', [$inspection->inspection_id]) }}" class="btn btn-default btn-edit">編集</a>
            </td>
            <td align="center">
              <button onclick="location.href='{{ route('ortho.inspections.orderby.top', ['id' => $inspection->inspection_id]) }}'" class="@if($i < 2) {{'hidden'}} @endif">TOP
            </td>
            <td align="center" class="">
              <button onclick="location.href='{{ route('ortho.inspections.orderby.up', ['id' => $inspection->inspection_id]) }}'" class="@if($i < 2) {{'hidden'}} @endif">↑</button>
            </td>
            <td align="center">
              <button onclick="location.href='{{ route('ortho.inspections.orderby.down', ['id' => $inspection->inspection_id]) }}'" class="@if($i == $max) {{'hidden'}} @endif">↓</button>
            </td>
            <td align="center" class="">
              <button onclick="location.href='{{ route('ortho.inspections.orderby.last', ['id' => $inspection->inspection_id]) }}'" class="@if($i == $max) {{'hidden'}} @endif">LAST</button>
            </td>
          </tr>
          @endforeach
        @endif

      </tbody>
    </table>
    <div class="row margin-bottom">
      <div class="col-md-12 text-right">
        <a href="{{ route('ortho.inspections.regist') }}" class="btn btn-sm btn-page">地域の新規登録</a>
      </div>
    </div>
  </div>    
</section>
@endsection