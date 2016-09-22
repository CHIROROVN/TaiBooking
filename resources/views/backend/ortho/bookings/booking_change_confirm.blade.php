@extends('backend.ortho.ortho')
@section('content')
<section id="page">
  <div class="container content-page">
    <h3>予約の変更</h3>
    <p>変更してよろしいですか？</p>
    {!! Form::open(array('route' => ['ortho.bookings.booking.change.confirm', $booking_id, $id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">変更前</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>{{$booking->p_no}} {{ $booking->p_name_f }} {{ $booking->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}<!-- ～{{toTime($booking->booking_start_time, $booking->booking_total_time)}} --></td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{$booking->clinic_name}}</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>{{$booking->facility_name}}</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>{{@$doctors[$booking->doctor_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>{{@$hygienists[$booking->hygienist_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>{{@$equipments[$booking->equipment_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td>@if($booking->service_1_kind == 1){{@$services[$booking->service_1]}}@elseif($booking->service_1_kind == 2){{@$treatment1s[$booking->service_1]}}@endif</td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td>{{$booking->inspection_name}}</td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td>{{$booking->insurance_name}}</td>
            </tr>
            <tr>
              <td class="col-title">救急</td>
              <td>@if($booking->emergency_flag == 1) 救急です @else 救急ではない @endif</td>
            </tr>
            <tr>
              <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td>{{@$arrStatus[$booking->booking_status]}}</td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td>{{ @$doctors[$booking->first_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($booking->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$booking->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($booking->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td>{{@$booking->booking_memo}}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2" style="color: red;">変更後</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>{{$booking_change->p_no}} {{$booking_change->p_name_f}} {{ $booking_change->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp(@$booking_change->booking_date)}} ({{DayJp(@$booking_change->booking_date)}})　{{splitHourMin(@$booking_change->booking_start_time)}}<!-- ～{{toTime($booking->booking_start_time, $booking->booking_total_time)}} --></td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{@$clinics[$booking_change->clinic_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>{{$booking_change->facility_name}}</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>{{@$doctors[$booking_change->doctor_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>{{@$hygienists[$booking_change->hygienist_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>{{$booking_change->equipment_name}}</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td><?php if(isset($booking_change->service_1_kind) && $booking_change->service_1_kind == 1){
                      echo @$services[$booking_change->service_1];
                    }elseif(isset($booking_change->service_1_kind) && $booking_change->service_1_kind == 2){
                      echo @$treatment1s[$booking_change->service_1];
                    }
                ?></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td>{{$booking_change->inspection_name}}</td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td>{{$booking_change->insurance_name}}</td>
            </tr>            
            <tr>
              <td class="col-title">救急</td>
              <td>@if($booking_change->emergency_flag == 1) 救急です @else 救急ではない @endif</td>
            </tr>
            <tr>
            <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td>{{@$arrStatus[$booking_chage->booking_status]}}</td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td>{{ @$doctors[$booking_change->first_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($booking_change->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$booking_change->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($booking_change->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo nl2br($booking_change->booking_memo);?> </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input value="変更する（確認済）" name="btnSave" type="submit" class="btn btn-sm btn-page">
        <!-- <input value="キャンセル" onclick="location.href=''" name="btnCancel" type="button" class="btn btn-sm btn-page"> -->
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</section>

@endsection