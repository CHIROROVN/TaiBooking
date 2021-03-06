@extends('backend.ortho.ortho')

@section('content')
	    <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　登録済み予約のキャンセル</h3>
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
		          	@if ( empty($booking->booking_status) || $booking->booking_status == 0 )
		            通常
		            @elseif ( $booking->booking_status == 2 )
		            無断キャンセル
		            @elseif ( $booking->booking_status == 4 )
		            未作成技工物TEL待ち
		            @elseif ( $booking->booking_status == 5 )
		            作成済み技工物キャンセル
		            @endif
		          </td>
		        </tr>
                <tr>
		          <td class="col-title">登録者</td>
		          <td>{{ @$list_doctors[$booking->first_user] }}</td>
		        </tr>
		        <tr>
		          <td class="col-title">登録日時</td>
		          <td>{{ dateHourMinSecond($booking->first_date, '/')}}</td>
		        </tr>
		        <tr>
		          <td class="col-title">最終更新者</td>
		          <td>{{ @$list_doctors[$booking->last_user] }}</td>
		        </tr>
		        <tr>
		          <td class="col-title">最終更新日時</td>
		          <td>{{ dateHourMinSecond($booking->last_date, '/')}}</td>
		        </tr>
		        <tr>
		          <td class="col-title">備考</td>
		          <td><?php echo @$booking->booking_memo ?></td>
		        </tr>
          	</table>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input name="btnCancel" id="btnCancel" onclick="location.href='{{route('ortho.bookings.booking.cancel', [$booking->booking_id])}}'" value="予約キャンセルとして保存する" type="button" class="btn btn-sm btn-page">
          </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
            </div>
          </div>
        </div>
      </section>
@endsection