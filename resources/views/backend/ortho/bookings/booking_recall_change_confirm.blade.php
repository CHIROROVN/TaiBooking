@extends('backend.ortho.ortho')
@section('content')
<section id="page">
  <div class="container content-page">
    <h3>予約の変更</h3>
    <p>登録してよろしいですか？</p>
    {!! Form::open(array('route' => ['ortho.bookings.booking_recall_change_cnf', $id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">無断キャンセル前予約</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>{{$recall->p_no}} {{ $recall->p_name_f }} {{ $recall->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp($recall->booking_date)}} ({{DayJp($recall->booking_date)}})　{{splitHourMin($recall->booking_start_time)}}</td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{@$clinics[$recall->clinic_id]}}</td>
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
              <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($recall->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$recall->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($recall->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td>{{@$recall->booking_memo}}</td>
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
              <td>{{$recall->p_no}} {{ $recall->p_name_f }} {{ $recall->p_name_g }}</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>{{formatDateJp(@$recall_change->booking_date)}} ({{DayJp(@$recall_change->booking_date)}})　{{splitHourMin(@$recall_change->booking_start_time)}}</td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{@$clinics[$recall_change->clinic_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>{{@$facilities[$recall_change->facility_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>{{@$doctors[$recall_change->doctor_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>{{@$hygienists[$recall_change->hygienist_id]}}</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>{{$recall_change->equipment_name}}</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td><?php if(isset($recall_change->service_1_kind) && $recall_change->service_1_kind == 1){
                      echo @$services[$recall_change->service_1];
                    }elseif(isset($recall_change->service_1_kind) && $recall_change->service_1_kind == 2){
                      echo @$treatment1s[$recall_change->service_1];
                    }
                ?></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td>{{$recall_change->inspection_name}}</td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td>{{$recall_change->insurance_name}}</td>
            </tr>            
            <tr>
              <td class="col-title">救急</td>
              <td>@if($recall_change->emergency_flag == 1) 救急です @else 救急ではない @endif</td>
            </tr>
            <tr>
            <?php $arrStatus = array(''=>'通常','1'=>'「TEL待ち」です','2'=>'無断キャンセル','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td>{{@$arrStatus[$recall_chage->recall_status]}}</td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td>{{ @$doctors[$recall_change->first_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td>{{ @dateHourMinSecond($recall_change->first_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td>{{ @$doctors[$recall_change->last_user] }}</td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td>{{ @dateHourMinSecond($recall_change->last_date, '/')}}</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo nl2br($recall_change->booking_memo);?> </td>
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