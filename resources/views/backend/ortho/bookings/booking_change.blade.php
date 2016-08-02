@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.bookings.booking.change', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
   <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約日時の変更</h3>
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
                  <td class="col-title"><label for="textName">医院</label></td>
                  <td>
                  <input type="hidden" name="booking_date" value="{{$booking->booking_date}}">
                    <select name="clinic_id" id="clinic_id" class="form-control">
                      <option value="" selected="selected">▼選択</option>
                      @if(count($clinics) > 0)
                        @foreach($clinics as $clinic_id => $clinic)
                        <option value="{{$clinic_id}}" @if($clinic_id == $booking->clinic_id) selected="selected" @endif>{{$clinic}}</option>
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
                              <label><input name="doctor_id" value="{{$doctor->id}}" type="radio" @if($doctor->id == $booking->doctor_id) checked="checked" @endif> {{$doctor->u_name}}</label>
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
                              <label><input name="hygienist_id" value="{{$hygienist->id}}" type="radio" @if( $hygienist->id == $booking->hygienist_id) checked="checked" @endif> {{$hygienist->u_name}}</label>
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
                          <label><input name="booking_day[]" value="Sun" type="checkbox" @if(DayEn($booking->booking_date) == 'Sun') checked="" @endif>日</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Mon" type="checkbox" @if(DayEn($booking->booking_date) == 'Mon') checked="" @endif>月</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Tue" type="checkbox" @if(DayEn($booking->booking_date) == 'Tue') checked="" @endif>火</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Wed" type="checkbox" @if(DayEn($booking->booking_date) == 'Wed') checked="" @endif>水</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Thu" type="checkbox" @if(DayEn($booking->booking_date) == 'Thu') checked="" @endif>木</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Fri" type="checkbox" @if(DayEn($booking->booking_date) == 'Fri') checked="" @endif>金</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_day[]" value="Sat" type="checkbox" @if(DayEn($booking->booking_date) == 'Sat') checked="" @endif>土</label>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                    <td class=col-title>何週間後</td>
                    <td>
                      <label class="radio-inline"><input type="radio" class="week_later" checked="" id="none_week" value="" name="week_later">指定なし</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_week" id="one_week"  name="week_later">1週間後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_month" id="one_month" name="week_later">1ヵ月後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" id="two_month" value="two_month" name="week_later">2ヵ月後</label>
                      
                      <label class="radio-inline"><input type="radio" class="week_later" value="week_specified" name="week_later" id="week_later">
                          <select name="week_later_option" id="week_later_option" style="width: 100px;">
                                  <option value="one_week">1週間後</option>
                                  <option value="two_week">2週間後</option>
                                  <option value="three_week">3週間後</option>
                                  <option value="four_week">4週間後</option>
                                  <option value="five_week">5週間後</option>
                                </select>
                      週指定</label>
                        <label class="radio-inline"><input type="radio" class="week_later" name="week_later" id="date_picker" value="date_picker">日付指定
                        <input type="calendar" name="date_picker_option" id="date_picker_option" class="datepicker" style="width: 150px;"></label>
                    </td>
                </tr>
                <tr>
                  <td class="col-title">業務</td>
                  <td>
                  @if($booking->service_1_kind == 1)
                  <input type="hidden" name="service_1" value="{{$booking->service_1}}">
                    {{$services[$booking->service_1]}}
                  @else
                    <select name="clinic_service_name" id="clinic_service_name" class="form-control">
                      <option value="" selected="selected">指定なし</option>
                          @if(count($treatment1s) > 0)
                            @foreach($treatment1s as $key12 => $treatment12)
                              <option value="{{$key12}}" @if($booking->service_1 == $key12) selected="" @endif >{{$treatment12}}</option>
                            @endforeach
                          @endif
                    </select>
                    @endif
                  </td>
                </tr>
              </table>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              
              <input name="BookingCalendar" id="BookingCalendar" onclick="location.href='{{route('ortho.bookings.booking.result.calendar')}}'" value="検索開始（カレンダー表示）" type="button" class="btn btn-sm btn-page mar-right">
              <input name="BookingList" id="BookingList" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">
              <input name="Reset" id="btnReset" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
</form>
<script type="text/javascript">
  $(document).ready(function() {
      $(".datepicker").datepicker({
          showOn: 'both',
          buttonText: 'カレンダー',
          buttonImageOnly: true,
          buttonImage: "{{asset('public/backend/ortho/common/image/dummy-calendar.png')}}",
          dateFormat: 'yy-mm-dd',
          constrainInput: true,
          inline: true,
          //locale: 'ja'
      });

      $('.ui-datepicker-trigger').css('margin-top','1px');
      $(".ui-datepicker-trigger").mouseover(function() {
          $(this).css('cursor', 'pointer');
      });

      $('.ui-datepicker-trigger').click(function(event) {
        $('#date_picker').attr("checked", "checked");
      });
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