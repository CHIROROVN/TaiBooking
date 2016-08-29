@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約の表示</h3>

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

      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">患者名</td>
          <td>{{ $booking->p_no }} {{ $booking->p_name_f }} {{ $booking->p_name_g }}</td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
          <td>
            {{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}<!-- ～{{toTime($booking->booking_start_time, $booking->booking_total_time)}} -->
            </td>
        </tr>
        <tr>
          <td class="col-title">医院</td>
          <td>{{ $booking->clinic_name }}</td>
        </tr>
        <tr>
          <td class="col-title">チェアー</td>
          <td>{{ $booking->facility_name }}</td>
        </tr>
        <tr>
          <td class="col-title">ドクター</td>
          <td>
            @foreach ( $doctors as $doctor )
              @if ( $doctor->id == $booking->doctor_id )
              {{ $doctor->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">衛生士</td>
          <td>
            @foreach ( $hys as $hy )
              @if ( $hy->id == $booking->hygienist_id )
              {{ $hy->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">装置</td>
          <td>{{ $booking->equipment_name }}</td>
        </tr>
        <tr>
          <td class="col-title">処置内容-1</td>
          <td>
            @if($booking->service_1_kind == '1')
            {{@$services[$booking->service_1]}}
            @elseif($booking->service_1_kind == '2')
            {{@$treatment1s[$booking->service_1]}}
            @endif
          </td>
        </tr>
        <!-- <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            @if($booking->service_2_kind == '1')
            {{@$services[$booking->service_2]}}
            @elseif($booking->service_2_kind == '2')
            {{@$treatment1s[$booking->service_2]}}
            @endif
          </td>
        </tr> -->
        <tr>
          <td class="col-title">検査</td>
          <td>{{ $booking->inspection_name }}</td>
        </tr>
        <tr>
          <td class="col-title">保険診療</td>
          <td>{{ $booking->insurance_name }}</td>
        </tr>
        <tr>
          <td class="col-title">救急</td>
          <td><?php echo ($booking->emergency_flag == 1) ? '救急です' : 'ノーマル'; ?></td>
        </tr>
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            @if ( $booking->booking_status == 1 )
            通常
            @elseif ( $booking->booking_status == 2 )
            「TEL待ち」です
            @elseif ( $booking->booking_status == 3 )
            「リコール」です→ <?php echo (empty($booking->booking_recall_ym)) ? '' : date('Y-m', strtotime($booking->booking_recall_ym)); ?>
            @elseif ( $booking->booking_status == 4 )
            未作成技工物TEL待ち
            @elseif ( $booking->booking_status == 5 )
            作成済み技工物キャンセル
            @elseif ( $booking->booking_status == 6 )
            無断キャンセル
            @endif
          </td>
        </tr>
        <tr>
          <td class="col-title">登録者</td>
          <td>{{ @$list_doctors[$booking->first_user] }}</td>
        </tr>
        <tr>
          <td class="col-title">登録日時</td>
          <td>{{ @dateHourMinSecond($booking->first_date, '/')}}</td>
        </tr>
        <tr>
          <td class="col-title">最終更新者</td>
          <td>{{ @$list_doctors[$booking->last_user] }}</td>
        </tr>
        <tr>
          <td class="col-title">最終更新日時</td>
          <td>{{ @dateHourMinSecond($booking->last_date, '/')}}</td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td><?php echo @$booking->booking_memo ?></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input onclick="location.href='{{ route('ortho.bookings.booking.edit', [ $booking->booking_id ]) }}'" value="予約内容を修正する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='{{route('ortho.bookings.booking_change_date', $booking->booking_id)}}'" value="予約日時を変更する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='{{route('ortho.bookings.booking.cancel_cnf', [ $booking->booking_id ])}}'" value="予約をキャンセルする" type="button" class="btn btn-sm btn-page">
          </td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.bookings.booking.result.calendar', [ 'start_date' => $start_date ]) }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>

@endsection