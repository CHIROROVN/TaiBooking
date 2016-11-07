@extends('backend.ortho.ortho')
@section('content')

{!! Form::open( ['id' => 'frmRecallSearch', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking_recall_serach',$id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
   <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約日時の変更</h3>
              <table class="table table-bordered">
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
                    </td>
                </tr>
                
              </table>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              
              <input name="BookingCalendar" id="BookingCalendar" value="検索開始（カレンダー表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="BookingRecall" id="BookingRecall" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="Reset" id="btnReset" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
{!! Form::close() !!}

@stop


@section('script')
  <script type="text/javascript">
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
          $('.bk_datetime_start').attr('disabled', false);
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

     $('#one_week').click(function(event) {
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
      $('#date_picker_option').val('');
    });

    $('#one_week').click(function(event) {
      $('#one_week').attr("checked", "checked");
      $('#date_picker_option').val('');
    });

    $('#one_month').click(function(event) {
      $('#one_month').attr("checked", "checked");
      $('#date_picker_option').val('');
    });
    $('#two_month').click(function(event) {
      $('#two_month').attr("checked", "checked");
      $('#date_picker_option').val('');
    });

    $('#week_later_option').click(function(event) {
      $('#week_later').attr("checked", "checked");
    });

    $('#date_picker').click(function(event) {
      $('#date_picker').attr("checked", "checked");

      Date.prototype.yyyymmdd = function() {
        var yyyy = this.getFullYear().toString();
        var mm = (this.getMonth()+1).toString();
        var dd  = this.getDate().toString();
        return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]);
      };
      var date = new Date();
      $('#date_picker_option').val(date.yyyymmdd());
    });

    $('#week_later').click(function(event) {
      $('#week_later').attr("checked", "checked");
      $('#date_picker_option').val('');
    });

    $("#btnReset").click(function(event) {
      $(".week_later").each(function( i, opt ) {
       $('.week_later').attr('checked', false);
      });
      $('.bk_datetime_start').attr('disabled', true);
      $('#none_week').attr("checked", "checked");
    });

  </script>
@stop