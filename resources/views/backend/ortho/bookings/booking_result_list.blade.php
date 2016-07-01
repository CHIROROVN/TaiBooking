@extends('backend.ortho.ortho')

@section('content')

<section id="page">
  <div class="container content-page">
    <h3 class="margin-bottom">予約管理　＞　予約の検索結果（リスト表示）</h3>
    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td  class="col-title" align="center">日付</td>
          <td  class="col-title" align="center">時間帯</td>
          <td class="col-title" align="center">医院</td>
          <td  class="col-title"align="center">患者名</td>
          <td class="col-title" align="center">予定処置内容</td>
          <td class="col-title" align="center">予約の編集</td>
        </tr>
        <tr>
          <td>2016/04/30（土）</td>
          <td>11:30～11:45</td>
          <td>たい矯正歯科</td>
          <td>杉元　俊彦</td>
          <td>SET</td>
          <td align="center"><input onclick="location.href='booking_edit.html'" value="予約の編集" type="button" class="btn btn-xs btn-page"></td>
        </tr>
         <tr>
          <td>2016/04/30（土）</td>
          <td>11:30～11:45</td>
          <td>たい矯正歯科</td>
          <td>杉元　俊彦</td>
          <td>SET</td>
          <td align="center"><input onclick="location.href='booking_edit.html'" value="予約の編集" type="button" class="btn btn-xs btn-page"></td>
        </tr>
      </tbody>
    </table>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="button" value="前の10件を表示" disabled="disabled" type="submit" class="btn btn-sm btn-page mar-right">
        <input name="button2" value="次の10件を表示" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>


@endsection