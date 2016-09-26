@extends('backend.ortho.ortho')
@section('content')

{!! Form::open( ['id' => 'frmBookingChange', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking.change',$booking_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
   <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約日時の変更</h3>
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="textName">医院</label></td>
                  <td>
                    <select name="clinic_id" id="clinic_id" class="form-control">
                      <option value="">▼選択</option>
                      @if(count($clinics) > 0)
                        <?php $listClinic = $clinics; ?>
                        @foreach($listClinic as $clinic_id => $clinic)
                          @if ( $clinic == 'たい矯正歯科' )
                          <option value="{{$clinic_id}}" selected="">{{$clinic}}</option>
                          <?php unset($listClinic[$clinic_id]) ?>
                          @endif
                        @endforeach
                        @foreach($listClinic as $clinic_id => $clinic)
                        <option value="{{$clinic_id}}">{{$clinic}}</option>
                        @endforeach
                      @endif
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">担当ドクター</td>
                  <td>
                    <div class="row">
                      @if(count($doctors) > 0)
                        @foreach($doctors as $doctor)
                          <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="checkbox">
                              <label><input name="doctor_id[]" value="{{$doctor->id}}" type="checkbox"> {{$doctor->u_name}}</label>
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td>
                    <div class="row">
                       @if(count($hygienists) > 0)
                        @foreach($hygienists as $hygienist)
                          <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="checkbox">
                              <label><input name="hygienist_id[]" value="{{$hygienist->id}}" type="checkbox"> {{$hygienist->u_name}}</label>
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">曜日</td>
                  <td>
                    <div class="row">
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="1" type="checkbox">日</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="2" type="checkbox">月</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="3" type="checkbox">火</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="4" type="checkbox">水</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="5" type="checkbox">木</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="6" type="checkbox">金</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="7" type="checkbox">土</label>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                    <td class=col-title>何週間後</td>
                    <td>
                      <label class="radio-inline"><input type="radio" class="week_later" checked=""  id="none_week" value="" name="week_later">指定なし</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_week" id="one_week"  name="week_later">1週間後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_month" id="one_month" name="week_later">1ヵ月後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" id="two_month" value="two_month" name="week_later">2ヵ月後</label>
                      
                      <label class="radio-inline">
                      <input type="radio" class="week_later" value="week_specified" name="week_later" id="week_later">
                          <select name="week_later_option"  id="week_later_option" style="width: 100px;" class="w_later_option">
                                  <option value="one_week">1週間後</option>
                                  <option value="two_week">2週間後</option>
                                  <option value="three_week">3週間後</option>
                                  <option value="four_week">4週間後</option>
                                  <option value="five_week">5週間後</option>
                          </select>
                          週指定</label>
                      
                        <label class="radio-inline"><input type="radio" class="week_later" name="week_later" id="date_picker" value="date_picker">日付指定
                        <input type="calendar" name="date_picker_option" id="date_picker_option" class="datepicker bk_datetime_start" style="width: 150px;"></label>
                        予約開始時間
                        <select name="bk_start_hour"  id="bk_start_hour" style="width: 50px;" class="bk_datetime_start">
                                  <option value="">--</option>
                                  <option value="00">00</option>
                                  <option value="01">01</option>
                                  <option value="02">02</option>
                                  <option value="03">03</option>
                                  <option value="04">04</option>
                                  <option value="05">05</option>
                                  <option value="06">06</option>
                                  <option value="07">07</option>
                                  <option value="08">08</option>
                                  <option value="09">09</option>
                                  <option value="10">10</option>
                                  <option value="11">11</option>
                                  <option value="12">12</option>
                                  <option value="13">13</option>
                                  <option value="14">14</option>
                                  <option value="15">15</option>
                                  <option value="16">16</option>
                                  <option value="17">17</option>
                                  <option value="18">18</option>
                                  <option value="19">19</option>
                                  <option value="20">20</option>
                                  <option value="21">21</option>
                                  <option value="22">22</option>
                                  <option value="23">23</option>
                          </select>
                          時
                          <select name="bk_start_min"  id="bk_start_min" style="width: 50px;" class="bk_datetime_start">
                                  <option value="">--</option>
                                  <option value="15">15</option>
                                  <option value="30">30</option>
                                  <option value="45">45</option>
                          </select>
                          分
                    </td>
                </tr>
                <tr>
                  <td class="col-title">業務</td>
                  <td>
                    <select name="clinic_service_name" id="clinic_service_name" class="form-control">
                      <option value="" selected="selected">指定なし</option>
                      <optgroup label="業務名">
                        @if(count($services) > 0)
                          @foreach($services as $service)
                          <option value="{{$service->service_id}}_sk1" >{{$service->service_name}}</option>
                        @endforeach
                        @endif
                    </optgroup>
                    <optgroup label="治療内容">
                          @if(count($treatment1s) > 0)
                            @foreach($treatment1s as $treatment12)
                              <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk2" >{{$treatment12->treatment_name}}</option>
                            @endforeach
                          @endif
                    </optgroup>
                    </select>
                  </td>
                </tr>
              </table>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              
              <input name="BookingCalendar" id="BookingCalendar" value="検索開始（カレンダー表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="BookingList" id="BookingList" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="Reset" id="btnReset" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
{!! Form::close() !!}

<script type="text/javascript">
    // function goBookingSearch() {
    //   var clinic_id = $("#clinic_id option:selected").val();
    //   var link = "{{route('ortho.bookings.booking.result.calendar')}}?clinic_id=" + clinic_id;
    //   window.location.href = link;
    // }

    $(document).ready(function() {
      if($('#date_picker').is(':checked')){
        $('input.bk_datetime_start').attr('disabled', false);
        $('.bk_datetime_start').attr('disabled', false);
      }else{
        $('input.bk_datetime_start').attr('disabled', true);
        $('.bk_datetime_start').attr('disabled', true);
      }

      if($('#week_later').is(':checked')){
        $('.w_later_option').attr('disabled', false);
      }else{
        $('.w_later_option').attr('disabled', true);
      }

      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $(".datepicker").datepicker({
          showOn: 'both',
          buttonText: 'カレンダー',
          buttonImageOnly: true,
          buttonImage: "{{asset('public/backend/ortho/common/image/dummy-calendar.png')}}",
          dateFormat: 'yy-mm-dd',
          constrainInput: true,
          inline: true,
          lang: 'ja'
      });

      $('.ui-datepicker-trigger').css('margin-top','1px');
      $(".ui-datepicker-trigger").mouseover(function() {
          $(this).css('cursor', 'pointer');
      });

      $('.ui-datepicker-trigger').click(function(event) {
        $('#date_picker').attr("checked", "checked");
      });
  });

  $('#date_picker').click(function(event) {
    $('input.bk_datetime_start').attr('disabled', false);
    $('.bk_datetime_start').attr('disabled', false);
    $('.week_later_option').attr('disabled', true);
  });

   $('#week_later').click(function(event) {
    $('.w_later_option').attr('disabled', false);
    $('input.bk_datetime_start').attr('disabled', true);
    $('.bk_datetime_start').attr('disabled', true);
  });

   $('#two_month').click(function(event) {
    $('.w_later_option').attr('disabled', true);
    $('input.bk_datetime_start').attr('disabled', true);
    $('.bk_datetime_start').attr('disabled', true);
  });

   $('#one_month').click(function(event) {
    $('.w_later_option').attr('disabled', true);
    $('input.bk_datetime_start').attr('disabled', true);
    $('.bk_datetime_start').attr('disabled', true);
  });

   $('#none_week').click(function(event) {
    $('.w_later_option').attr('disabled', true);
    $('input.bk_datetime_start').attr('disabled', true);
    $('.bk_datetime_start').attr('disabled', true);
  });

</script>

<script type="text/javascript">
  $('#date_picker_option').click(function() {
    $('#date_picker').attr("checked", "checked");
  });

  $('#none_week').click(function(event) {
    $('#none_week').attr("checked", "checked");
  });
  $('#one_week').click(function(event) {
    $('#one_week').attr("checked", "checked");
  });
  $('#one_month').click(function(event) {
    $('#one_month').attr("checked", "checked");
  });
  $('#two_month').click(function(event) {
    $('#two_month').attr("checked", "checked");
  });

  $('#week_later_option').click(function(event) {
    $('#week_later').attr("checked", "checked");
  });

  $('#date_picker').click(function(event) {
    $('#date_picker').attr("checked", "checked");
  });
  $('#week_later').click(function(event) {
    $('#week_later').attr("checked", "checked");
  });

  $("#btnReset").click(function(event) {
    $(".week_later").each(function( i, opt ) {
     $('.week_later').attr('checked', false);
    });
    $('#none_week').attr("checked", "checked");
  });
</script>
@endsection