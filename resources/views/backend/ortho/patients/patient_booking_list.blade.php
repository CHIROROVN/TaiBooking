@extends('backend.ortho.ortho')

@section('content')
	 <section id="page">
      <div class="container content-page">
        <h3>患者管理　＞　予約の表示</h3>
        <p>予約は2件あります。</p>
        <div class="row">
          <div class="col-md-6">
            <table class="table table-bordered treatment2-list">
            @if(!empty($bookings[0]))
              <tbody>
                <tr>
                  <td class="col-title" style="width:30%">患者名</td>
                  <td>{{$bookings[0]->p_no}} {{$bookings[0]->p_name_f}} {{$bookings[0]->p_name_g}}</td>
                </tr>
                <tr>
                  <td class="col-title">予約日時</td>
                  <td>{{formatDateJp($bookings[0]->booking_date)}} ({{DayJp($bookings[0]->booking_date)}})　{{splitHourMin($bookings[0]->booking_start_time)}}～{{toTime($bookings[0]->booking_start_time, $bookings[0]->booking_total_time)}}</td>
                </tr>
                <tr>
                  <td class="col-title">医院</td>
                  <td>{{$bookings[0]->clinic_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">チェアー</td>
                  <td>{{$bookings[0]->facility_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">ドクター</td>
                  <td>{{@$doctors[$bookings[0]->doctor_id]}}</td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td>{{@$hygienists[$bookings[0]->hygienist_id]}}</td>
                </tr>
                <tr>
                  <td class="col-title">装置</td>
                  <td>{{$bookings[0]->equipment_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-1</td>
                  <td><?php if(isset($bookings[0]->service_1_kind) && $bookings[0]->service_1_kind == 1){
                      echo @$services[$bookings[0]->service_1];
                    }elseif(isset($bookings[0]->service_1_kind) && $bookings[0]->service_1_kind == 2){
                      echo @$treatment1s[$bookings[0]->service_1];
                    }
                ?></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-2</td>
                  <td><?php if(isset($bookings[1]->service_2_kind) && $bookings[1]->service_2_kind == 1){
                      echo @$services[$bookings[1]->service_2];
                    }elseif(isset($bookings[1]->service_2_kind) && $bookings[1]->service_2_kind == 2){
                      echo @$treatment1s[$bookings[1]->service_2];
                    }
                ?></td>
                </tr>
                <tr>
                  <td class="col-title">検査</td>
                  <td>{{$bookings[0]->inspection_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">保険診療</td>
                  <td>{{$bookings[0]->insurance_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">救急</td>
                  <td>@if($bookings[0]->emergency_flag == 1) 救急です @endif</td>
                </tr>
                <tr>
                  <td class="col-title">予約ステータス</td>
                  <td>
                      @if ( $bookings[0]->booking_status == 1 )
                      通常
                      @elseif ( $bookings[0]->booking_status == 2 )
                      「TEL待ち」です
                      @elseif ( $bookings[0]->booking_status == 3 )
                      「リコール」です→ <?php echo (empty($bookings[0]->booking_recall_ym)) ? '' : date('Y-m', strtotime($bookings[0]->booking_recall_ym)); ?>
                      @elseif ( $bookings[0]->booking_status == 4 )
                      未作成技工物TEL待ち
                      @elseif ( $bookings[0]->booking_status == 5 )
                      作成済み技工物キャンセル
                      @endif
                  </td>
                </tr>
                <tr>
                  <td class="col-title">備考</td>
                  <td>{{$bookings[0]->booking_memo}}</td>
                </tr>
                <tr>
                  <td colspan="2" class="text-center">
                    <input onclick="location.href='{{route('ortho.bookings.booking.edit',[$bookings[0]->booking_id])}}'" value="予約内容を修正する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href='{{route('ortho.bookings.booking.change')}}'" value="予約日時を変更する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href='{{route('ortho.bookings.booking.cancel_cnf',[$bookings[0]->booking_id])}}'" value="予約をキャンセルする" type="button" class="btn btn-xs btn-page mar-right">
                  </td>
                </tr>
              </tbody>
              @else
              <tbody>
                <tr>
                  <td class="col-title" style="width:30%">患者名</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">予約日時</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">医院</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">チェアー</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">ドクター</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">装置</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-1</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-2</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">検査</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">保険診療</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">救急</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">予約ステータス</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">備考</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="2" class="text-center">
                    <input onclick="location.href=''" value="予約内容を修正する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href=''" value="予約日時を変更する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href=''" value="予約をキャンセルする" type="button" class="btn btn-xs btn-page mar-right">
                  </td>
                </tr>
              </tbody>
              @endif
            </table>
          </div>

          <div class="col-md-6">
            <table class="table table-bordered treatment2-list">
            @if(!empty($bookings[1]))
              <tbody>
                <tr>
                  <td class="col-title" style="width:30%">患者名</td>
                  <td>{{$bookings[1]->p_no}} {{$bookings[1]->p_name_f}} {{$bookings[1]->p_name_g}}</td>
                </tr>
                <tr>
                  <td class="col-title">予約日時</td>
                  <td>{{formatDateJp($bookings[1]->booking_date)}} ({{DayJp($bookings[1]->booking_date)}})　{{splitHourMin($bookings[1]->booking_start_time)}}～{{toTime($bookings[1]->booking_start_time, $bookings[1]->booking_total_time)}}</td>
                </tr>
                <tr>
                  <td class="col-title">医院</td>
                  <td>{{$bookings[0]->clinic_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">チェアー</td>
                  <td>{{$bookings[1]->facility_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">ドクター</td>
                  <td>{{@$doctors[$bookings[1]->doctor_id]}}</td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td>{{@$hygienists[$bookings[1]->hygienist_id]}}</td>
                </tr>
                <tr>
                  <td class="col-title">装置</td>
                  <td>{{$bookings[1]->equipment_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-1</td>
                  <td><?php if(isset($bookings[1]->service_1_kind) && $bookings[1]->service_1_kind == 1){
                      echo @$services[$bookings[1]->service_1];
                    }elseif(isset($bookings[1]->service_1_kind) && $bookings[1]->service_1_kind == 2){
                      echo @$treatment1s[$bookings[1]->service_1];
                    }
                ?></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-2</td>
                  <td><?php if(isset($bookings[1]->service_2_kind) && $bookings[1]->service_2_kind == 1){
                      echo @$services[$bookings[1]->service_2];
                    }elseif(isset($bookings[1]->service_2_kind) && $bookings[1]->service_2_kind == 2){
                      echo @$treatment1s[$bookings[1]->service_2];
                    }
                ?></td>
                </tr>
                <tr>
                  <td class="col-title">検査</td>
                  <td>{{$bookings[1]->inspection_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">保険診療</td>
                  <td>{{$bookings[1]->insurance_name}}</td>
                </tr>
                <tr>
                  <td class="col-title">救急</td>
                  <td>@if($bookings[1]->emergency_flag == 1) 救急です @endif</td>
                </tr>
                <tr>
                  <td class="col-title">予約ステータス</td>
                  <td>
                      @if ( $bookings[1]->booking_status == 1 )
                      通常
                      @elseif ( $bookings[1]->booking_status == 2 )
                      「TEL待ち」です
                      @elseif ( $bookings[1]->booking_status == 3 )
                      「リコール」です→ <?php echo (empty($bookings[1]->booking_recall_ym)) ? '' : date('Y-m', strtotime($bookings[1]->booking_recall_ym)); ?>
                      @elseif ( $bookings[1]->booking_status == 4 )
                      未作成技工物TEL待ち
                      @elseif ( $bookings[1]->booking_status == 5 )
                      作成済み技工物キャンセル
                      @endif
                  </td>
                </tr>
                <tr>
                  <td class="col-title">備考</td>
                  <td>{{$bookings[1]->booking_memo}}</td>
                </tr>
                <tr>
                  <td colspan="2" class="text-center">
                    <input onclick="location.href='{{route('ortho.bookings.booking.edit',[$bookings[1]->booking_id])}}'" value="予約内容を修正する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href='{{route('ortho.bookings.booking.change')}}'" value="予約日時を変更する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href='{{route('ortho.bookings.booking.cancel_cnf',[$bookings[1]->booking_id])}}'" value="予約をキャンセルする" type="button" class="btn btn-xs btn-page mar-right">
                  </td>
                </tr>
              </tbody>
              @else
              <tbody>
                <tr>
                  <td class="col-title" style="width:30%">患者名</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">予約日時</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">医院</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">チェアー</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">ドクター</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">装置</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-1</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">業務内容-2</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">検査</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">保険診療</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">救急</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">予約ステータス</td>
                  <td></td>
                </tr>
                <tr>
                  <td class="col-title">備考</td>
                  <td></td>
                </tr>
                <tr>
                  <td colspan="2" class="text-center">
                    <input onclick="location.href=''" value="予約内容を修正する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href=''" value="予約日時を変更する" type="button" class="btn btn-xs btn-page mar-right">
                    <input onclick="location.href=''" value="予約をキャンセルする" type="button" class="btn btn-xs btn-page mar-right">
                  </td>
                </tr>
              </tbody>
              @endif
            </table>
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