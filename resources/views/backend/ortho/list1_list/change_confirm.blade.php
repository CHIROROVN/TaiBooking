@extends('backend.ortho.ortho')
@section('content')
<section id="page">
  <div class="container content-page">
    <h3>予約の変更</h3>
    <p>登録してよろしいですか？</p>
    {!! Form::open(array('route' => ['ortho.list1_list.change_confirm', $id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">TEL待ち患者情報</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>{{@$patient->p_no}} {{ @$patient->p_name_f }} {{ @$patient->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp($bookingtel->booking_date)}} {{DayJp($bookingtel->booking_date, $comm='()')}}　{{splitHourMin($bookingtel->booking_start_time)}}</td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{@$clinics[$bookingtel->clinic_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>{{@$facilities[$bookingtel->facility_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>{{@$doctors[$bookingtel->doctor_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>{{@$hygienists[$bookingtel->hygienist_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>{{@$equipments[$bookingtel->equipment_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td>@if($bookingtel->service_1_kind == 1){{@$services[$bookingtel->service_1]}}@elseif($bookingtel->service_1_kind == 2){{@$treatment1s[$bookingtel->service_1]}}@endif</td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td>{{$bookingtel->inspection_id}}</td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td>{{$bookingtel->insurance_id}}</td>
            </tr>
            <tr>
              <td class="col-title">救急</td>
              <td>@if($bookingtel->emergency_flag == 1) 救急です @else 救急ではない @endif</td>
            </tr>
            <tr>
              <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td>「TEL待ち」です</td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td>{{ @$doctors[$booking->first_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($bookingtel->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$bookingtel->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($bookingtel->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo nl2br(@$bookingtel->free_text); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <input type="hidden" name="booking_id" id="booking_id" value="{{$booking_id}}">
          <tr><td colspan="2" style="color: red;">新しい予約</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>{{$patient->p_no}} {{ $patient->p_name_f }} {{ $patient->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp(@$bookingtel_change->booking_date)}} ({{DayJp(@$bookingtel_change->booking_date)}})　{{splitHourMin(@$bookingtel_change->booking_start_time)}}</td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{@$clinics[$bookingtel_change->clinic_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>{{@$facilities[$bookingtel_change->facility_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>{{@$doctors[$bookingtel_change->doctor_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>{{@$hygienists[$bookingtel_change->hygienist_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>{{$bookingtel_change->equipment_name}}</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td><?php if(isset($bookingtel_change->service_1_kind) && $bookingtel_change->service_1_kind == 1){
                      echo @$services[$bookingtel_change->service_1];
                    }elseif(isset($bookingtel_change->service_1_kind) && $bookingtel_change->service_1_kind == 2){
                      if($bookingtel_change->service_1 == -1) echo '治療';
                      else echo @$treatment1s[$bookingtel_change->service_1];
                    }
                ?></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td>{{$bookingtel_change->inspection_name}}</td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td>{{$bookingtel_change->insurance_name}}</td>
            </tr>            
            <tr>
              <td class="col-title">救急</td>
              <td>@if($bookingtel_change->emergency_flag == 1) 救急です @else 救急ではない @endif</td>
            </tr>
            <tr>
            <?php $arrStatus = array(''=>'通常','1'=>'「TEL待ち」です','2'=>'無断キャンセル','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td>{{@$arrStatus[$bookingtel_chage->recall_status]}}</td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td>{{ @$doctors[$bookingtel_change->first_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($bookingtel_change->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$bookingtel_change->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($bookingtel_change->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo nl2br(@$bookingtel->free_text); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input value="登録する" name="btnSave" type="submit" class="btn btn-sm btn-page">
        <!-- <input value="キャンセル" onclick="location.href=''" name="btnCancel" type="button" class="btn btn-sm btn-page"> -->
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</section>

@endsection