@extends('ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>共通マスタ管理　＞　登録済み地域の一覧</h3>
    <div class="row">
      <div class="col-md-12 text-right">
        <a href="{{ asset('ortho/areas/regist') }}" class="btn btn-sm btn-page">地域の新規登録</a>
      </div>
    </div>
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr>
          <td align="center" class="col-title">地域名</td>
          <td align="center" class="col-title col-edit">編集</td>
          <td colspan="4" align="center" class="col-title col-action">表示順序</td>
        </tr>

        <?php 
          $i = 0;
          $max = count($areas);
        ?>
        @if(empty($areas) || count($areas) < 1)
          <tr>
            <td colspan="6">
              <h3 align="center">該当するデータがありません。</h3>
            </td>
          </tr>
        @else
          @foreach($areas as $area)
          <?php $i++; ?>
          <tr>
            <td>
              {{ $area->area_name }}
            </td>
            <td align="center">
              <a href="{{ asset('ortho/areas/edit/' . $area->area_id) }}" class="btn btn-default btn-edit">編集</a>
            </td>
            <td align="center">
              <button onclick="location.href='{{ asset('ortho/areas/orderby-top?id=' . $area->area_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">TOP
            </td>
            <td align="center" class="">
              <button onclick="location.href='{{ asset('ortho/areas/orderby-up?id=' . $area->area_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">↑</button>
            </td>
            <td align="center">
              <button onclick="location.href='{{ asset('ortho/areas/orderby-down?id=' . $area->area_id) }}'" class="@if($i == $max) {{'hidden'}} @endif">↓</button>
            </td>
            <td align="center" class="">
              <button onclick="location.href='{{ asset('ortho/areas/orderby-last?id=' . $area->area_id) }}'" class="@if($i == $max) {{'hidden'}} @endif">LAST</button>
            </td>
          </tr>
          @endforeach
        @endif

      </tbody>
    </table>
    <div class="row margin-bottom">
      <div class="col-md-12 text-right">
        <a href="{{ asset('ortho/areas/regist') }}" class="btn btn-sm btn-page">地域の新規登録</a>
      </div>
    </div>
  </div>    
</section>
@endsection