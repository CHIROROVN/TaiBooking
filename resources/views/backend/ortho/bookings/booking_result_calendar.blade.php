@extends('backend.ortho.ortho')

@section('content')

<?php
  // doctor
  // $totalRecordDoctor    = 45; //count($doctors);
  // $numberRowDoctor      = ceil($totalRecordDoctor / 15);
  // $rowspanDoctor        = $numberRowDoctor;
  // if ( $numberRowDoctor == 0 ) {
  //   $rowspanDoctor = 1;
  // }

  // // hygienists
  // $totalRecordHygienists  = 45; //count($hygienists);
  // $numberRowHygienists    = ceil($totalRecordHygienists / 15);
  // $rowspanHygienists      = $numberRowHygienists;
  // if ( $rowspanHygienists == 0 ) {
  //   $rowspanHygienists = 1;
  // }

  // echo $totalRecordDoctor.'-dfw3erf-'.$numberRowDoctor;

  // $totalRecord = count($doctors);
  // echo $totalRecord;
?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約枠の検索結果（カレンダー表示）</h3>
        <div class="mar-top20">
          <?php
          $prevDate            = strtotime ( '- 1 day' , strtotime ( $date_current ) ) ;
          $prevDate            = date ( 'Y-m-j' , $prevDate );
          $nextDate            = strtotime ( '+ 1 day' , strtotime ( $date_current ) ) ;
          $nextDate            = date ( 'Y-m-j' , $nextDate );
          $curDate            = date ( 'Y-m-j');
          ?>
          {!! Form::open(array('route' => ['ortho.bookings.booking.result.calendar'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
          <input type="hidden" name="prev" value="{{ $prevDate }}">
          <input type="submit" name="" value="&lt;&lt; 前日" class="btn btn-sm btn-page">
          </form>
          {!! Form::open(array('route' => ['ortho.bookings.booking.result.calendar'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
          <input type="hidden" name="cur" value="{{ $curDate }}">
          <input type="submit" name="" value="今日" class="btn btn-sm btn-page">
          </form>
          {!! Form::open(array('route' => ['ortho.bookings.booking.result.calendar'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
          <input type="hidden" name="next" value="{{ $nextDate }}">
          <input type="submit" name="" value="翌日 &gt;&gt;" class="btn btn-sm btn-page">
          </form>

          <h3 class="text-center mar-top20">{{ formatDateJp($date_current) }}（{{ DayJp($date_current) }}）</h3>

          <p>{{ $clinic->clinic_name }}</p>
        </div>

        <?php
        $text = '末設定';
        ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- list doctor -->
            <tr>
              <td align="center" rowspan="3" class="col-title" style="width: 6%">ドクター</td>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';

                // if ( $doctor->shift_free1 == $facility->facility_id ) {
                //   $text = $facility->facility_name;die;
                // }
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';

                // if ( $doctor->shift_free1 == $facility->facility_id ) {
                //   $text = $facility->facility_name;die;
                // }
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';

                // if ( $doctor->shift_free1 == $facility->facility_id ) {
                //   $text = $facility->facility_name;die;
                // }
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>

            <!-- list hygienists -->
            <tr>
              <td align="center" rowspan="3" class="col-title" style="width: 6%">衛生士</td>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="hygienist-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-hygienist" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="hygienist-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-hygienist" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="hygienist-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="142px"><span data-u-id="" data-facility-id="{{ $facility->facility_id }}" class="popup popup-hygienist" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <!-- 3 -->
          </table>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center" style="width: 6%;">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center" style="width: 6%;">{{ $facility->facility_name }}</td>
              @endforeach
            </tr>

            <!-- check "brown", "green", "blue" color -->
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0];
              $minute = $tmp_arr[1];
              $fullTime = $hour . $minute;
            ?>
            <tr>
              <td align="center" style="width: 6%">{{ $time }}～</td>
              @foreach ( $facilitys as $facility )
                <?php
                  // $common_id = $facility->facility_id . '-' . $hour.$minute;
                  $facility_id = $facility->facility_id;
                  $color = 'brown';
                  // $service_id = 0;
                  // $fullValue = null;
                  $text = '';

                  if ( isset($arr_bookings[$facility_id][$fullTime]) ) {

                    if ( empty($arr_bookings[$facility_id][$fullTime]->patient_id) ) {
                      $link = route('ortho.bookings.booking.regist', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    } else {
                      $link = route('ortho.bookings.booking.detail', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    }

                    if ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 1 ) {
                      $color = 'green';
                      $br = '<br />';
                      if ( empty($arr_bookings[$facility_id][$fullTime]->p_name) ) {
                        $br = '';
                      }
                      $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' . $arr_bookings[$facility_id][$fullTime]->p_name . $br . @$services[$arr_bookings[$facility_id][$fullTime]->service_1] . '<span></span></a>';
                    } elseif ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 2 ) {
                      $color = 'blue';
                      $booking = $arr_bookings[$facility_id][$fullTime];
                      if($booking->service_1 != -1){
                        $treatment_name = @$treatment1s[$booking->service_1];
                      }else{
                        $treatment_name = '治療';
                      }
                      $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' . "{$treatment_name}" .'<span></span>' . '</a>';
                    }
                  }
                ?>

                <!-- close -->
                <td align="center" width="50px" class="col-{{ $color }}" id="" width="142px">
                  <div class="td-content">
                    {!! $text !!}
                    @if ( $color === 'brown' )
                    <img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />
                    @endif
                  </div>
                </td>
                <!-- end close -->
              @endforeach
            </tr>
            @endforeach
            
          </table>
        </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function(){
    $('.popup').popover({
      html: true
    });
    
    // set value from popup
    $('.popup').click(function(event) {
      var objPopup = $(this);
      var facility_id = $(this).attr('data-facility-id');
      var u_id_old = $(this).attr('data-u-id');
      var facility_id_old = $(this).attr('data-facility-id');
      if ( u_id_old == undefined ) {
        u_id_old = null;
      }
      if ( facility_id_old == undefined ) {
        facility_id_old = null;
      }

      // auto select value old
      $('.input-user').each(function(index, el) {
        if ( $(this).val() == objPopup.attr('data-u-id') ) {
          $(this).attr("checked",true);
          $(this).attr('disabled', 'disabled');
        }
      });

      $('.input-user').click(function(event) {
        console.log($(this).val());
        console.log($(this).attr('text'));
        var u_id = $(this).val();
        var u_name = $(this).attr('text');

        if ( u_id == '-1' ) {
          objPopup.html('末設定');
          objPopup.attr('data-u-id', null);
          $('.facility_id-' + facility_id).each(function(index, el) {
            $('.facility_id-' + facility_id).find('span').html('<br /><span></span>');
          });
        } else {
          objPopup.html(u_name);
          objPopup.attr('data-u-id', u_id);
          $('.facility_id-' + facility_id).each(function(index, el) {
            $('.facility_id-' + facility_id).find('span').html('<br /><span>' + u_name + '</span>');
          });
        }
        objPopup.popover('hide');

        // update to table "t_shift"
        $.ajax({
           url: "{{ route('ortho.shifts.update.free.ajax') }}",
           data: { u_id: u_id, shift_date: '{{ $date_current }}', clinic_id: '{{ $clinic->clinic_id }}', facility_id: facility_id, u_id_old: u_id_old, facility_id_old: facility_id_old } ,
           dataType: 'json',
           type: "get",
           success: function(result) {
             console.log(result);
           }
        });
        // end update to table "t_shift"
      });
    });
    // end set value from popup
  });
</script>

@endsection