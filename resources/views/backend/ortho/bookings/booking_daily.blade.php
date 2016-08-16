@extends('backend.ortho.ortho')
@section('content')
<?php
  // doctor
  // $totalRecordDoctor    = count($doctors);
  // $numberRowDoctor      = ceil($totalRecordDoctor / 15);
  // $rowspanDoctor        = $numberRowDoctor;
  // if ( $numberRowDoctor == 0 ) {
  //   $rowspanDoctor = 1;
  // }

  // hygienists
  // $totalRecordHygienists  = count($hygienists);
  // $numberRowHygienists    = ceil($totalRecordHygienists / 15);
  // $rowspanHygienists      = $numberRowHygienists;
  // if ( $rowspanHygienists == 0 ) {
  //   $rowspanHygienists = 1;
  // }

?>
	 <section id="page">
      <div class="container">
        <div class="row content-page">

          <h3>予約簿の表示</h3>
            <div class="mar-top20">
            <?php
              $prevDate            = strtotime ( '- 1 day' , strtotime ( $date_current ) ) ;
              $prevDate            = date ( 'Y-m-d' , $prevDate );
              $nextDate            = strtotime ( '+ 1 day' , strtotime ( $date_current ) ) ;
              $nextDate            = date ( 'Y-m-d' , $nextDate );
              $curDate            = date ( 'Y-m-d');
            ?>
          {!! Form::open(array('route' => ['ortho.bookings.booking.daily'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
            <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
            <input type="hidden" name="prev" value="{{ $prevDate }}">
            <input type="submit" name="" value="&lt;&lt; 前日" class="btn btn-sm btn-page">
          </form>
          {!! Form::open(array('route' => ['ortho.bookings.booking.daily'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
            <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
            <input type="hidden" name="cur" value="{{ $curDate }}">
            <input type="submit" name="" value="今日" class="btn btn-sm btn-page">
          </form>
          {!! Form::open(array('route' => ['ortho.bookings.booking.daily'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
            <input type="hidden" name="clinic_id" value="{{ $clinic->clinic_id }}">
            <input type="hidden" name="next" value="{{ $nextDate }}">
            <input type="submit" name="" value="翌日 &gt;&gt;" class="btn btn-sm btn-page">
          </form>
          
          <!-- ddr infomation -->
          <?php
            $color = array(
              '1' => '#000',
              '2' => '#F00',
              '3' => '#00F',
              '4' => '#390',
              '5' => '#F90'
            );
            $text = '院長カレンダー <br>';
            foreach ( $ddrs as $item ) {
              $kind = '<span style="color: ' . $color[$item->ddr_kind] . ';">■</span>';
              $start_time = splitHourMin($item->ddr_start_time);
              $end_time = splitHourMin($item->ddr_end_time);
              if ( $start_time == '00:00' ) {
                  $start_time = null;
              }
              if ( $end_time == '00:00' ) {
                  $end_time = null;
              }
              $text .= $kind . ' ' . $start_time . '~' . $end_time . ' ' . $item->ddr_contents . '<br />';
            }
          ?>
          <div class="ddr-infomation">
            {!! $text !!}
          </div>

          <h3 class="text-center mar-top20">{{ formatDateJp($date_current) }}（{{ DayJp($date_current) }}）</h3>
              <p>{{ @$clinic->clinic_name }}</p>
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
              <td align="center" width="6%">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center" >{{ $facility->facility_name }}</td>
              @endforeach
            </tr>

            <!-- check "brown", "green", "blue" color -->
            <?php $tmpFlag = array() ?>
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0];
              $minute = $tmp_arr[1];
              $fullTime = $hour . $minute;
            ?>
            <tr>
              <td align="center" style="">{{ $time }}～</td>
              @foreach ( $facilitys as $facility )
                <?php
                  // $common_id = $facility->facility_id . '-' . $hour.$minute;
                  $facility_id = $facility->facility_id;
                  $color = 'brown';
                  // $service_id = 0;
                  // $fullValue = null;
                  $text = '';
                  $clsBackgroundPatient = ''; //backgroup-while
                  $iconFlag = '';

                  if ( isset($arr_bookings[$facility_id][$fullTime]) ) {
                    // set flag
                    if ( empty($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id) ) {
                      $iconFlag = '';
                    } elseif ( !in_array($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id, $tmpFlag) ) {
                      $tmpFlag[] = $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                      $iconFlag = '<img src="' . asset('') . 'public/backend/ortho/common/image/icon-shift-set2.png" />';
                    } else {
                      $iconFlag = '';
                    }

                    if ( empty($arr_bookings[$facility_id][$fullTime]->patient_id) ) {
                      $link = route('ortho.bookings.booking.regist', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    } else {
                      $link = route('ortho.bookings.booking.detail', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    }

                    if ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 1 ) {
                      $color = 'green';
                      $booking = @$arr_bookings[$facility_id][$fullTime];

                      $sDoctor = '';
                      if(!empty($list_doctors[$booking->doctor_id]))
                        $sDoctor = @$list_doctors[$booking->doctor_id];

                      $sPatient = '';
                      if( !empty($booking->p_no) ) {
                        $sPatient .= $booking->p_name . '<br />';
                      }
                      if( !empty($booking->p_name) ) {
                        $sPatient .= $booking->p_name . '<br />';
                      }

                      if ( !empty($sPatient) ) {
                        $clsBackgroundPatient = 'backgroup-while';
                      }

                      $sService = '';
                      if(!empty($services[$booking->service_1]))
                        $sService = @$services[$booking->service_1] . '<br />';

                      $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' . '<span>' . @$sPatient . @$sService . @$sDoctor . '</span></a>';

                    } elseif ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 2 ) {
                      $color = 'blue';
                      $booking = @$arr_bookings[$facility_id][$fullTime];
                      $initTreatment = '治療';

                      if($booking->service_1 != -1){
                        $initTreatment = '';

                        $tDoctor = '';
                        if(isset($list_doctors[$booking->doctor_id]) && !empty($list_doctors[$booking->doctor_id]) && $list_doctors[$booking->doctor_id] != '') {
                          $initTreatment = '';
                          $tDoctor = @$list_doctors[$booking->doctor_id];
                        }

                        $tPatient = '';
                        if( !empty($booking->p_no) ) {
                          $tPatient .= $booking->p_no . '<br />';
                        }
                        if( !empty($booking->p_name) ) {
                          $tPatient .= $booking->p_name . '<br />';
                        }

                        if ( !empty($tPatient) ) {
                          $clsBackgroundPatient = 'backgroup-while';
                        }

                        $tTreatment = '';
                        if(!empty($treatment1s[$booking->service_1])) {
                          $initTreatment = '';
                          $tTreatment = @$treatment1s[$booking->service_1] . '<br />';
                        }

                      }else{
                        $tDoctor = '';
                        $tPatient = '';
                        $tTreatment = '';
                      }

                      $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' .  '<span>' . @$initTreatment . @$tPatient  . @$tTreatment . @$tDoctor . '</span>' . '</a>';
                    }
                  }
                ?>

                <!-- close -->
                <td align="center" width="50px" class="col-{{ $color }} {{ $clsBackgroundPatient }}" id="" width="142px">
                  <div class="td-content">
                    {!! $iconFlag !!} {!! $text !!}
                    @if ( $color === 'brown' )
                    <img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />
                    @endif
                  </div>
                </td>
                <!-- end close -->
              @endforeach
            </tr>
            @endforeach
                </tr>

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
      // reset
      $('.popover').hide();
      $(this).parent().find('.popover').show();

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
          // $('.facility_id-' + facility_id).each(function(index, el) {
          //   $('.facility_id-' + facility_id).find('span').html('<br /><span></span>');
          // });
        } else {
          objPopup.html(u_name);
          objPopup.attr('data-u-id', u_id);
          // $('.facility_id-' + facility_id).each(function(index, el) {
          //   $('.facility_id-' + facility_id).find('span').html('<br /><span>' + u_name + '</span>');
          // });
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