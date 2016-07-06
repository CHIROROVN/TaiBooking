@extends('backend.ortho.ortho')

@section('content')

<section id="page">
  <div class="container content-page">
    <h3>予約管理　＞　予約枠の検索結果（リスト表示）</h3>
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

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
            <td class="col-title" align="center">日付</td>
            <td class="col-title" align="center">時間帯</td>
            <td class="col-title" align="center">設備</td>
            <td class="col-title" align="center">業務</td>
            <td class="col-title" align="center">予約簿の表示</td>
            <td class="col-title" align="center">予約の登録</td>
        </tr>
        @if(!count($bookings))
          <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
        @else
          @foreach($bookings as $booking)
            <tr>
              <td>{{formatDate($booking->booking_date)}} ({{DayJp($booking->booking_date)}})</td>
              <td>{{splitHourMin($booking->booking_start_time)}}～{{toTime($booking->booking_start_time, $booking->booking_total_time)}}</td>
              <td>{{@$facilities[$booking->facility_id]}}</td>
              <td>
                @if($booking->service_1_kind == 1)
                  {{@$services[$booking->service_1]}}
                @elseif($booking->service_1_kind == 2)
                  {{@$treatment1s[$booking->service_1]}}
                @endif
                、
                @if($booking->service_2_kind == 1)
                  {{@$services[$booking->service_2]}}
                @elseif($booking->service_2_kind == 2)
                  {{@$treatment1s[$booking->service_2]}}
                @endif

              </td>
              <td align="center">
                <input onclick="location.href='booking-daily.html'" value="予約簿の表示" type="button" class="btn btn-xs btn-page"></td>
                <td align="center"><input onclick="location.href='{{route('ortho.bookings.booking.regist', $booking->booking_id)}}'" value="予約の登録" type="button" class="btn btn-xs btn-page"/></td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
      <div class="row margin-bottom" style="display: block; float: right;">
        <div class="col-md-12 text-center">
          {!! $bookings->render(new App\Pagination\SimplePagination($bookings))  !!}
        </div>
      </div>

   <!--  <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="button" value="前の10件を表示" disabled="disabled" type="submit" class="btn btn-sm btn-page mar-right">
        <input name="button2" value="次の10件を表示" type="submit" class="btn btn-sm btn-page">
      </div>
    </div> -->
  </div>    
</section>


@endsection