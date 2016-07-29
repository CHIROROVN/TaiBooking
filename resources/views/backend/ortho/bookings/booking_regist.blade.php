@extends('backend.ortho.ortho')

@section('content')

{!! Form::open( ['id' => 'frmBookingRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking.regist', $booking_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
<section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>予約管理　＞　予約の新規登録</h3>
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
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="textName">患者名</label></td>
              <td>
                <?php $pt = showPatient($booking->patient_id);?>
                <input type="hidden" name="p_id" id="p_id" value="{{@$pt['p_id']}}">
                <input type="text" name="patient" id="patient" class="input-text-mid form-control" style="width: 250px; display: inline;" value="{{@$pt['patient']}}"> &nbsp;
                <input type="button" name="1stBK" id="button" value="新患です" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.bookings.booking.1st.regist',$booking->booking_id)}}'">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textNameRead">予約日時</label></td>
              <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}
              </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{$booking->clinic_name}}</td>
            </tr>
            <!-- <tr>
              <td class="col-title"><label for="facility_id">チェアー</label></td>
              <td><select name="facility_id" id="facility_id" class="form-control">
                <option value="">▼選択</option>
                  @if(count($facilities) > 0)
                  @foreach($facilities as $key => $facility)
                    <option value="{{$key}}" @if($booking->facility_id == $key) selected @endif>{{$facility}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr> -->
            <tr>
              <td class="col-title"><label for="doctor_id">ドクター</label></td>
              <td><select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">▼選択</option>
                @if(count($doctors) > 0)
                  @foreach($doctors as $doctor)
                    <option value="{{$doctor->id}}" @if($booking->doctor_id == $doctor->id) selected @endif>{{$doctor->u_name}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="hygienist_id">衛生士</label></td>
              <td><select name="hygienist_id" id="hygienist_id" class="form-control">
                <option value="">▼選択</option>
                @if(count($hygienists) > 0)
                  @foreach($hygienists as $hygienist)
                    <option value="{{$hygienist->id}}" @if($booking->hygienist_id == $hygienist->id) selected @endif>{{$hygienist->u_name}}</option>
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
                  <optgroup label="業務名">
                      @if(count($services) > 0)
                        @foreach($services as $key11 => $service11)
                        <option value="{{$key11}}_sk11" @if($booking->service_1 == $key11) selected @endif >{{$service11}}</option>
                      @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="治療内容">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $treatment12)
                              <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk22" @if($booking->service_1 == $treatment12->treatment_id) selected @endif>{{$treatment12->treatment_name}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      @if(count($services) > 0)
                        @foreach($services as $key21 => $service21)
                          <option value="{{$key21}}_sk21" @if($booking->service_2 == $key21) selected @endif >{{$service21}}</option>
                        @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="治療内容">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $treatment12)
                            <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk22" @if($booking->service_2 == $treatment12->treatment_id) selected @endif >{{$treatment12->treatment_name}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="inspection_id">検査</label></td>
              <td>
                <select name="inspection_id" id="inspection_id" class="form-control">
                  <option>▼選択</option>
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
                  <option value="">▼選択</option>
                    @if(count($insurances) > 0)
                    @foreach($insurances as $key => $insurance)
                      <option value="{{$key}}" @if($booking->insurance_id == $key) selected @endif>{{$insurance}}</option>
                    @endforeach
                  @endif
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="ckEmergency">救急</label></td>
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
                    <input name="booking_status" id="recalling" value="3" type="radio" @if($booking->booking_status == 3) checked @endif>「リコール」です→
                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                    <?php $year =  date('Y', strtotime($booking->booking_date))?>
                      <option value="" selected>▼選択</option>
                      <option value="{{dateAddMonth($booking->booking_date, 01, 'Ym')}}" @if($year.'01' == $booking->booking_recall_ym) selected @endif>1ヶ月後</option>
                      <option value="{{dateAddMonth($booking->booking_date, 02, 'Ym')}}" @if(dateAddMonth($booking->booking_date, 03, 'Ym') == $booking->booking_recall_ym) selected @endif>2ヶ月後</option>
                      <option value="{{dateAddMonth($booking->booking_date, 03, 'Ym')}}" @if(dateAddMonth($booking->booking_date, 03, 'Ym') == $booking->booking_recall_ym) selected @endif>3ヶ月後</option>
                      <option value="{{dateAddMonth($booking->booking_date, 04, 'Ym')}}" @if(dateAddMonth($booking->booking_date, 04, 'Ym') == $booking->booking_recall_ym) selected @endif>4ヶ月後</option>
                      <option value="{{dateAddMonth($booking->booking_date, 05, 'Ym')}}0" @if(dateAddMonth($booking->booking_date, 05, 'Ym') == $booking->booking_recall_ym) selected @endif>5ヶ月後</option>
                      <option value="{{dateAddMonth($booking->booking_date, 06, 'Ym')}}" @if(dateAddMonth($booking->booking_date, 06, 'Ym') == $booking->booking_recall_ym) selected @endif>6ヶ月後</option>
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
              <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area">{{@$booking->booking_memo}}</textarea></td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
{!! Form::close() !!}
<script type="text/javascript">
  $('#booking_recall_ym').click(function() {
    $('#recalling').attr("checked", "checked");
  });
</script>

<script>
  $(document).ready(function(){
    $( "#patient" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#patient').val();
          $.ajax({
              url: "{{ route('ortho.patients.autocomplete.patient') }}",
              beforeSend: function(){
              },
              method: "GET",
              data: { key: key },
              dataType: "json",
              success: function(data) {
                response(data);
              },
          });
      },
      focus: function( event, ui ) {
        $( "#patient" ).val( ui.item.label );
        return true;
      },
      select: function( event, ui ) {
        $( "#patient" ).val( ui.item.label );
        $( "#p_id" ).val( ui.item.value );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };
  });
</script>
@endsection