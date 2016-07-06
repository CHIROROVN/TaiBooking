@extends('backend.ortho.ortho')

@section('content')
{!! Form::open( ['id' => 'frmBookingRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking.regist', $booking_id, $patient_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約の新規登録</h3>
      <table class="table table-bordered">
        <tr>
          <td class="col-title"><label for="textName">患者名</label></td>
          <td>
          <input type="hidden" id="booking_id" name="booking_id" class="form-control" value="{{$booking_id}}"/>
          <input type="hidden" id="patient_id" name="patient_id" class="form-control" value="{{$patient_id}}"/>

          <input type="text" id="p_id" class="form-control" value="{{@$patient->p_no}} {{@$patient->p_name}}" readonly/>
            <input type="button" id="button" value="新患です" class="btn btn-sm btn-page" onclick="location.href='{{ route('ortho.bookings.booking.1st.regist') }}'" style="margin-top: 5px;">
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="cbReservation">予約日時</label></td>
          <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}～{{toTime($booking->booking_start_time, $booking->booking_total_time)}}
          </td>
        </tr>
        <tr>
          <td class="col-title">医院</td>
          <td>{{@$clinics[$booking->clinic_id]}}</td>
        </tr>
        <tr>
          <td class="col-title"><label for="facility_id">チェアー</label></td>
          <td>
            <select name="facility_id" id="facility_id" class="form-control">
              <option value="">▼選択</option>
              @if(count($facilities) > 0)
                @foreach($facilities as $key => $facility)
                  <option value="{{$key}}" @if($booking->facility_id == $key) selected @endif>{{$facility}}</option>
                @endforeach
              @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="doctor_id">ドクター</label></td>
          <td>
            <select name="doctor_id" id="doctor_id" class="form-control">
              <option value="">▼選択</option>
                @if(count($users) > 0)
                  @foreach($users as $key => $user)
                    <option value="{{$key}}" @if($booking->doctor_id == $key) selected @endif>{{$user}}</option>
                  @endforeach
                @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="hygienist_id">衛生士</label></td>
          <td>
            <select name="hygienist_id" id="hygienist_id" class="form-control">
              <option value="">▼選択</option>
                @if(count($users) > 0)
                  @foreach($users as $key => $user)
                    <option value="{{$key}}" @if($booking->hygienist_id == $key) selected @endif>{{$user}}</option>
                  @endforeach
                @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="equipment_id">装置</label></td>
          <td>
            <select name="equipment_id" id="equipment_id" class="form-control">
              <option value="">▼選択</option>
                @if(count($equipments) > 0)
                  @foreach($equipments as $key => $equipment)
                    <option value="{{$key}}" @if($booking->equipment_id == $key) selected @endif>{{$equipment}}</option>
                  @endforeach
                @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="service_1">業務内容-1</label></td>
          <td>
            <select name="service_1" id="service_1" class="form-control">
              <option value="">▼選択</option>
              @if($booking->service_1_kind == '1')
                @if(count($services) > 0)
                  @foreach($services as $key => $service)
                    <option value="{{$key}}" @if($booking->service_1 == $key) selected @endif>{{$service}}</option>
                  @endforeach
                @endif
              @elseif($booking->service_1_kind == '2')
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    <option value="{{$key}}" @if($booking->service_1 == $key) selected @endif>{{$treatment1}}</option>
                  @endforeach
                @endif
              @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="service_2">業務内容-2</label></td>
          <td>
            <select name="service_2" id="service_2" class="form-control">
              <option value="">▼選択</option>
              @if($booking->service_2_kind == '1')
                @if(count($services) > 0)
                  @foreach($services as $key => $service)
                    <option value="{{$key}}" @if($booking->service_2 == $key) selected @endif>{{$service}}</option>
                  @endforeach
                @endif
              @elseif($booking->service_2_kind == '2')
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    <option value="{{$key}}" @if($booking->service_2 == $key) selected @endif>{{$treatment1}}</option>
                  @endforeach
                @endif
              @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="inspection_id">検査</label></td>
          <td>
            <select name="inspection_id" id="inspection_id" class="form-control">
              <option value="">▼選択</option>
                @if(count($inspections) > 0)
                  @foreach($inspections as $key => $inspection)
                    <option value="{{$key}}" @if($booking->inspection_id == $key) selected @endif>{{$inspection}}</option>
                  @endforeach
                @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="insurance_id">保険診療</label></td>
          <td>
            <select name="insurance_id" id="insurance_id" class="form-control">
              <option>▼選択</option>
              @if(count($insurances) > 0)
                  @foreach($insurances as $key => $insurance)
                    <option value="{{$key}}" @if($booking->insurance_id == $key) selected @endif>{{$insurance}}</option>
                  @endforeach
                @endif
            </select>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="emergency_flag">救急</label></td>
          <td>
            <div class="checkbox">
              <label> <input name="emergency_flag" type="checkbox" id="emergency_flag"@if($booking->emergency_flag == 1) checked @endif>救急です</label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <div class="radio">
              <label><input name="booking_status" value="1" type="radio" @if($booking->booking_status == 1) checked @endif>通常</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="2" type="radio" @if($booking->booking_status == 2) checked @endif>「TEL待ち」です</label>
            </div>
            <div class="radio">
              <label>
                <input name="booking_status" value="3" type="radio" @if($booking->booking_status == 3) checked @endif>「リコール」です→
                <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                <?php $year =  date('Y', strtotime($booking->booking_date))?>
                  <option value="" selected>▼選択</option>
                  <option value="{{$year}}01" @if($year.'01' == $booking->booking_recall_ym) selected @endif>1ヶ月後</option>
                  <option value="{{$year}}02" @if($year.'02' == $booking->booking_recall_ym) selected @endif>2ヶ月後</option>
                  <option value="{{$year}}03" @if($year.'03' == $booking->booking_recall_ym) selected @endif>3ヶ月後</option>
                  <option value="{{$year}}04" @if($year.'04' == $booking->booking_recall_ym) selected @endif>4ヶ月後</option>
                  <option value="{{$year}}05" @if($year.'05' == $booking->booking_recall_ym) selected @endif>5ヶ月後</option>
                  <option value="{{$year}}06" @if($year.'06' == $booking->booking_recall_ym) selected @endif>6ヶ月後</option>
                </select>
              </label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="4" type="radio" @if($booking->booking_status == 4) checked @endif>未作成技工物TEL待ち</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="5" type="radio" @if($booking->booking_status == 5) checked @endif>作成済み技工物キャンセル</label>
            </div>
          </td>
        </tr>
        <tr>
          <td class="col-title"><label for="booking_memo">備考</label></td>
          <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control">{{@$booking->booking_memo}}</textarea></td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="button2" value="登録する" type="submit" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>

@endsection