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
              <td>{{splitHourMin($booking->booking_start_time)}}</td>
              <td>{{@$facilities[$booking->facility_id]}}</td>
              <td>
              <!-- service 1 -->
                  @if($booking->service_1_kind == 1)
                    {{@$services[$booking->service_1]}}
                  @elseif($booking->service_1_kind == 2)
                    @if($booking->service_1 == -1)
                      治療
                    @else
                    {{$treatment1s[$booking->service_1]}}
                    @endif
                  @endif
                  <!-- Service 2 -->
                  @if($booking->service_2_kind == 1)
                    @if(!empty($services[$booking->service_2]))
                      @if(!empty($services[$booking->service_1]) && !empty($services[$booking->service_2]))、 @endif {{@$services[$booking->service_2]}}
                    @endif
                  @elseif($booking->service_2_kind == 2)
                    @if($booking->service_2 != -1)
                       @if(!empty($treatment1s[$booking->service_1]) && !empty($treatment1s[$booking->service_2]))、@endif {{$treatment1s[$booking->service_2]}}
                    @endif
                  @endif
              </td>
              <td align="center">
                <input onclick="location.href='{{route('ortho.bookings.booking.daily', [ 'clinic_id' => $booking->clinic_id, 'cur' => $booking->booking_date] )}}'" value="予約簿の表示" type="button" class="btn btn-xs btn-page">
                </td>
                <td align="center"><input onclick="location.href='{{route('ortho.bookings.list2_change_confirm', [$id, 'booking_id'=>$booking->booking_id])}}'" value="予約の登録" type="button" class="btn btn-xs btn-page"/></td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">

        </div>
      </div>

  </div>
</section>


@endsection