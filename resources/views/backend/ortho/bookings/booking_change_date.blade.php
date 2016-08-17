@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.bookings.booking_change_date', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　変更予約日</h3>

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

      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">患者名</td>
          <td>{{ $booking->p_no }} {{ $booking->p_name }}</td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
<!--     <td>
            {{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}～{{toTime($booking->booking_start_time, $booking->booking_total_time)}}
            </td> -->
            <td>
            <?php $bst = time2D4($booking->booking_start_time);
              $hh = $bst['hh']; $mm = $bst['mm'];
             ?>
                <label class="radio-inline">
                予約日 <input type="calendar" name="booking_date" id="date_picker_option" class="datepicker" style="width: 130px;" value="{{@$booking->booking_date}}"></label>
                <label class="radio-inline">予約時間 <select name="hour_start"  id="hour_start" style="width: 60px;">
                        <option value="">-- 時</option>
                        <option value="00" @if($hh == '00') selected="" @endif >00 時</option>
                        <option value="01" @if($hh == '01') selected="" @endif >01 時</option>
                        <option value="02" @if($hh == '02') selected="" @endif >02 時</option>
                        <option value="03" @if($hh == '03') selected="" @endif >03 時</option>
                        <option value="04" @if($hh == '04') selected="" @endif >04 時</option>
                        <option value="05" @if($hh == '05') selected="" @endif >05 時</option>
                        <option value="06" @if($hh == '06') selected="" @endif >06 時</option>
                        <option value="07" @if($hh == '07') selected="" @endif >07 時</option>
                        <option value="08" @if($hh == '08') selected="" @endif >08 時</option>
                        <option value="09" @if($hh == '09') selected="" @endif >09 時</option>
                        <option value="10" @if($hh == '10') selected="" @endif >10 時</option>
                        <option value="11" @if($hh == '11') selected="" @endif >11 時</option>
                        <option value="12" @if($hh == '12') selected="" @endif >12 時</option>
                        <option value="13" @if($hh == '13') selected="" @endif >13 時</option>
                        <option value="14" @if($hh == '14') selected="" @endif >14 時</option>
                        <option value="15" @if($hh == '15') selected="" @endif >15 時</option>
                        <option value="16" @if($hh == '16') selected="" @endif >16 時</option>
                        <option value="17" @if($hh == '17') selected="" @endif >17 時</option>
                        <option value="18" @if($hh == '18') selected="" @endif >18 時</option>
                        <option value="19" @if($hh == '19') selected="" @endif >19 時</option>
                        <option value="20" @if($hh == '20') selected="" @endif >20 時</option>
                        <option value="21" @if($hh == '21') selected="" @endif >21 時</option>
                        <option value="22" @if($hh == '22') selected="" @endif >22 時</option>
                        <option value="23" @if($hh == '23') selected="" @endif >23 時</option>
                    </select>
                      :
                    <select name="min_start"  id="min_start" style="width: 60px;">
                        <option value="">-- 分</option>
                        <option value="00" @if($mm == '00') selected="" @endif >00 分</option>
<!--                         <option value="01" @if($mm == '01') selected="" @endif >01 分</option>
                        <option value="02" @if($mm == '02') selected="" @endif >02 分</option>
                        <option value="03" @if($mm == '03') selected="" @endif >03 分</option>
                        <option value="04" @if($mm == '04') selected="" @endif >04 分</option>
                        <option value="05" @if($mm == '05') selected="" @endif >05 分</option>
                        <option value="06" @if($mm == '06') selected="" @endif >06 分</option>
                        <option value="07" @if($mm == '07') selected="" @endif >07 分</option>
                        <option value="08" @if($mm == '08') selected="" @endif >08 分</option>
                        <option value="09" @if($mm == '09') selected="" @endif >09 分</option>
                        <option value="10" @if($mm == '10') selected="" @endif >10 分</option>
                        <option value="11" @if($mm == '11') selected="" @endif >11 分</option>
                        <option value="12" @if($mm == '12') selected="" @endif >12 分</option>
                        <option value="13" @if($mm == '13') selected="" @endif >13 分</option>
                        <option value="14" @if($mm == '14') selected="" @endif >14 分</option> -->
                        <option value="15" @if($mm == '15') selected="" @endif >15 分</option>
<!--                         <option value="16" @if($mm == '16') selected="" @endif >16 分</option>
                        <option value="17" @if($mm == '17') selected="" @endif >17 分</option>
                        <option value="18" @if($mm == '18') selected="" @endif >18 分</option>
                        <option value="19" @if($mm == '19') selected="" @endif >19 分</option>
                        <option value="20" @if($mm == '20') selected="" @endif >20 分</option>
                        <option value="21" @if($mm == '21') selected="" @endif >21 分</option>
                        <option value="22" @if($mm == '22') selected="" @endif >22 分</option>
                        <option value="23" @if($mm == '23') selected="" @endif >23 分</option>
                        <option value="24" @if($mm == '24') selected="" @endif >24 分</option>
                        <option value="25" @if($mm == '25') selected="" @endif >25 分</option>
                        <option value="26" @if($mm == '26') selected="" @endif >26 分</option>
                        <option value="27" @if($mm == '27') selected="" @endif >27 分</option>
                        <option value="28" @if($mm == '28') selected="" @endif >28 分</option>
                        <option value="29" @if($mm == '29') selected="" @endif >29 分</option> -->
                        <option value="30" @if($mm == '30') selected="" @endif >30 分</option>
<!--                         <option value="31" @if($mm == '31') selected="" @endif >31 分</option>
                        <option value="32" @if($mm == '32') selected="" @endif >32 分</option>
                        <option value="33" @if($mm == '33') selected="" @endif >33 分</option>
                        <option value="34" @if($mm == '34') selected="" @endif >34 分</option>
                        <option value="35" @if($mm == '35') selected="" @endif >35 分</option>
                        <option value="36" @if($mm == '36') selected="" @endif >36 分</option>
                        <option value="37" @if($mm == '37') selected="" @endif >37 分</option>
                        <option value="38" @if($mm == '38') selected="" @endif >38 分</option>
                        <option value="39" @if($mm == '39') selected="" @endif >39 分</option>
                        <option value="40" @if($mm == '40') selected="" @endif >40 分</option>
                        <option value="41" @if($mm == '41') selected="" @endif >41 分</option>
                        <option value="42" @if($mm == '42') selected="" @endif >42 分</option>
                        <option value="43" @if($mm == '43') selected="" @endif >43 分</option>
                        <option value="44" @if($mm == '44') selected="" @endif >44 分</option> -->
                        <option value="45" @if($mm == '45') selected="" @endif >45 分</option>
<!--                         <option value="46" @if($mm == '46') selected="" @endif >46 分</option>
                        <option value="47" @if($mm == '47') selected="" @endif >47 分</option>
                        <option value="48" @if($mm == '48') selected="" @endif >48 分</option>
                        <option value="49" @if($mm == '49') selected="" @endif >49 分</option>
                        <option value="50" @if($mm == '50') selected="" @endif >50 分</option>
                        <option value="51" @if($mm == '51') selected="" @endif >51 分</option>
                        <option value="52" @if($mm == '52') selected="" @endif >52 分</option>
                        <option value="53" @if($mm == '53') selected="" @endif >53 分</option>
                        <option value="54" @if($mm == '54') selected="" @endif >54 分</option>
                        <option value="55" @if($mm == '55') selected="" @endif >55 分</option>
                        <option value="56" @if($mm == '56') selected="" @endif >56 分</option>
                        <option value="57" @if($mm == '57') selected="" @endif >57 分</option>
                        <option value="58" @if($mm == '58') selected="" @endif >58 分</option>
                        <option value="59" @if($mm == '59') selected="" @endif >59 分</option> -->
                    </select>
                </label>
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
            @if ( $booking->booking_status == 1 )
            通常
            @elseif ( $booking->booking_status == 2 )
            「TEL待ち」です
            @elseif ( $booking->booking_status == 3 )
            「リコール」です→ <?php echo (empty($booking->booking_recall_ym)) ? '' : date('Y-m', strtotime($booking->booking_recall_ym)); ?>
            @elseif ( $booking->booking_status == 4 )
            未作成技工物TEL待ち
            @elseif ( $booking->booking_status == 5 )
            作成済み技工物キャンセル
            @elseif ( $booking->booking_status == 6 )
            無断キャンセル
            @endif
          </td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td>{{ $booking->booking_memo }}</td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input value="変化する" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
{!! Form::close() !!}
<script type="text/javascript">
    $(document).ready(function() {
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
</script>

@endsection