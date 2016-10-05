@extends('backend.ortho.ortho')

@section('content')
<?php
// count facility
$countFacility = count($facilitys);
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
          $curDate             = date ( 'Y-m-j');
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
        $tmpText = array();
        $str = '';
        ?>
        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- list doctor -->
            <tr>
              <td align="center" rowspan="3" class="col-title td-title" style="width: 110px">ドクター</td>
              @foreach ( $facilitys as $facility )
              <?php
                // set list doctor
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }
                
                // set default doctor
                foreach ( $doctors as $doctor ) {
                  // set name doctor
                  $data_u_id = null;
                  if ( $doctor->shift_free1 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free2 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free3 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free4 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free5 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }
                  if ( $text != '末設定' ) {
                    $tmpText[] = $doctor->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
 
              ?>
              <td class="td-simple" align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                // set list doctor
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }

                // set default doctor
                foreach ( $doctors as $doctor ) {
                  // set name doctor
                  $data_u_id = null;
                  if ( $doctor->shift_free1 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free2 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free3 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free4 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free5 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }

                  if ( in_array($text . '-' . $facility->facility_id, $tmpText) ) {
                    $text = '末設定'; 
                    $data_u_id = null;
                  }

                  if ( $text != '末設定' ) {
                    $tmpText[] = $doctor->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                // set list doctor
                $str = '';
                foreach ( $doctors as $doctor ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $doctor->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $doctor->u_id . '" >' . $doctor->u_name . '</label></li>';
                }

                // set default doctor
                foreach ( $doctors as $doctor ) {
                  // set name doctor
                  $data_u_id = null;
                  if ( $doctor->shift_free1 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free2 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free3 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free4 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } elseif ( $doctor->shift_free5 == $facility->facility_id ) {
                    $text = $doctor->u_name;
                    $data_u_id = $doctor->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }

                  if ( in_array($text . '-' . $facility->facility_id, $tmpText) ) {
                    $text = '末設定';
                    $data_u_id = null;
                  }

                  if ( $text != '末設定' ) {
                    $tmpText[] = $doctor->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>

            <!-- list hygienists -->
            <?php
              $text = '末設定';
              $tmpText = array();
              $str = '';
            ?>
            <tr>
              <td align="center" rowspan="3" class="col-title td-title" style="width: 110px">ドクター</td>
              @foreach ( $facilitys as $facility )
              <?php
                // set list hygienist
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }
                
                // set default hygienist
                foreach ( $hygienists as $hygienist ) {
                  // set name hygienist
                  $data_u_id = null;
                  if ( $hygienist->shift_free1 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free2 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free3 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free4 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free5 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }
                  if ( $text != '末設定' ) {
                    $tmpText[] = $hygienist->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
 
              ?>
              <td align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <!-- ggggggggggggggggggggggggggggggggggggggggggggggggggggggg -->
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                // set list hygienist
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }

                // set default hygienist
                foreach ( $hygienists as $hygienist ) {
                  // set name hygienist
                  $data_u_id = null;
                  if ( $hygienist->shift_free1 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free2 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free3 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free4 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free5 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }

                  if ( in_array($text . '-' . $facility->facility_id, $tmpText) ) {
                    $text = '末設定'; 
                    $data_u_id = null;
                  }

                  if ( $text != '末設定' ) {
                    $tmpText[] = $hygienist->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
            <tr>
              @foreach ( $facilitys as $facility )
              <?php
                // set list hygienist
                $str = '';
                foreach ( $hygienists as $hygienist ) {
                  $str .= '<li><label class="radio"><input type="radio" class="input-user" text="' . $hygienist->u_name . '" name="doctor-facility-' . $facility->facility_id . '" value="' . $hygienist->u_id . '" >' . $hygienist->u_name . '</label></li>';
                }

                // set default hygienist
                foreach ( $hygienists as $hygienist ) {
                  // set name hygienist
                  $data_u_id = null;
                  if ( $hygienist->shift_free1 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free2 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free3 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free4 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } elseif ( $hygienist->shift_free5 == $facility->facility_id ) {
                    $text = $hygienist->u_name;
                    $data_u_id = $hygienist->u_id;
                  } else {
                    $text = '末設定';
                    $data_u_id = null;
                  }

                  if ( in_array($text . '-' . $facility->facility_id, $tmpText) ) {
                    $text = '末設定'; 
                    $data_u_id = null;
                  }

                  if ( $text != '末設定' ) {
                    $tmpText[] = $hygienist->u_name . '-' . $facility->facility_id;
                    break;
                  }
                }
                $str .= '<li><label class="radio"><input type="radio" class="input-user" text="" name="doctor-facility-' . $facility->facility_id . '" value="-1" >' . trans('common.select_reset') . '</label></li>';
              ?>
              <td align="center" width="" style=""><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
          <table class="table table-bordered table-shift-set" id="" style="margin-bottom: 0;">
            <tr>
              <td align="center" style="width: 110px;" class="td-title">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center" style="" class="td-will">{{ $facility->facility_name }}</td>
              @endforeach
            </tr>
        </table>

        <div class="inner_table table-responsive">
          <table class="table table-bordered table-shift-set tbl-inner">
            <!-- check "brown", "green", "blue" color -->
            <?php $tmpFlag = array(); ?>
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0];
              $minute = $tmp_arr[1];
              $fullTime = $hour . $minute;
            ?>
            <tr>
              <td align="center" style="width: 110px;" class="td-title">{{ $time }}～</td>
              @foreach ( $facilitys as $key => $facility )
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
                    // set '↓'
                    $tmpFacilityTimeGroup[] = $arr_bookings[$facility_id][$fullTime]->facility_id . '-' . $arr_bookings[$facility_id][$fullTime]->booking_start_time . '-' . $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;

                    // set flag
                    if ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 1  ) {
                      if ( empty($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id) ) {
                        $iconFlag = '';
                      } elseif ( !in_array($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id, $tmpFlag) ) {
                        $tmpFlag[] = $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                        $iconFlag = '<img src="' . asset('') . 'public/backend/ortho/common/image/icon-shift-set2.png" />';
                      } else {
                        $iconFlag = '';
                        $str = $arr_bookings[$facility_id][$fullTime]->facility_id . '-' . ($arr_bookings[$facility_id][$fullTime]->booking_start_time - 15) . '-' . $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                        if ( in_array($str, $tmpFacilityTimeGroup) ) {
                          $iconFlag = '↓';
                        }
                      }
                    } else {
                      if ( empty($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id) ) {
                        $iconFlag = '';
                      } elseif ( !in_array($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id . $arr_bookings[$facility_id][$fullTime]->facility_id, $tmpFlag) ) {
                        $tmpFlag[] = $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id . $arr_bookings[$facility_id][$fullTime]->facility_id;
                        $iconFlag = '<img src="' . asset('') . 'public/backend/ortho/common/image/icon-shift-set2.png" />';
                      } else {
                        $iconFlag = '↓';
                      }
                    }

                    // set link
                    if ( empty($arr_bookings[$facility_id][$fullTime]->patient_id) ) {
                      $link = route('ortho.bookings.booking.regist', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    } else {
                      $link = route('ortho.bookings.booking.detail', $arr_bookings[$facility_id][$fullTime]->booking_id);
                    }

                    // set text title
                    if ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 1 ) {
                      $color = 'green';
                      $booking = @$arr_bookings[$facility_id][$fullTime];

                      $sDoctor = '';
                      if(!empty($list_doctors[$booking->doctor_id]))
                        $sDoctor = @$list_doctors[$booking->doctor_id];

                      $sPatient = '';
                      if( !empty($booking->p_no) ) {
                        $sPatient .= $booking->p_no . '<br />';
                      }
                      if( !empty($booking->p_name_f) || !empty($booking->p_name_g) ) {
                        $sPatient .= $booking->p_name_f . ' ' . $booking->p_name_g . '<br />';
                      }

                      if ( !empty($sPatient) ) {
                        $clsBackgroundPatient = 'backgroup-while';
                      }

                      $sService = '';
                      if(!empty($services[$booking->service_1]))
                        $sService = @$services[$booking->service_1] . '<br />';

                      if ( $iconFlag == '↓' ) {
                        $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' . '<span>' . $iconFlag . '</span></a>';
                        $iconFlag = null;
                      } else {
                        $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' . '<span>' . @$sPatient . @$sService . @$sDoctor . '</span></a>';
                      }

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
                          $initTreatment = '';
                          $tPatient .= $booking->p_no . '<br />';
                        }
                        if( !empty($booking->p_name_f) || !empty($booking->p_name_g) ) {
                          $tPatient .= $booking->p_name_f . ' ' . $booking->p_name_g . '<br />';
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

                      if ( $iconFlag == '↓' ) {
                        $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' .  '<span>' . $iconFlag . '</span>' . '</a>';
                        $iconFlag = null;
                      } else {
                        $text = '<a href="' . $link . '" class="facility_id-' . $facility_id . '">' .  '<span>' . @$initTreatment . @$tPatient  . @$tTreatment . @$tDoctor . '</span>' . '</a>';
                      }
                    }
                  }
                ?>

              <!-- close -->
              <td align="center" width="" style="" class="col-{{ $color }} {{ $clsBackgroundPatient }} td-will-box" id="">
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

        </table>
        </div>
        <!-- end inner_table -->
      </div>
      <!-- end table-responsive -->
    </div>
  </section>
@stop

@section('script')
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

        // auto select value old
        $('.input-user').each(function(index, el) {
          if ( $(this).val() == objPopup.attr('data-u-id') ) {
            $(this).attr("checked",true);
            $(this).attr('disabled', 'disabled');
          }
        });

        $('.input-user').click(function(event) {
          var u_id = $(this).val();
          var u_name = $(this).attr('text');

          if ( u_id == '-1' ) {
            objPopup.html('末設定');
            objPopup.attr('data-u-id', null);
          } else {
            objPopup.html(u_name);
            objPopup.attr('data-u-id', u_id);
          }
          objPopup.popover('hide');

          // update to table "t_shift"
          $.ajax({
             url: "{{ route('ortho.shifts.update.free.ajax') }}",
             data: { u_id: u_id, shift_date: '{{ $date_current }}', clinic_id: '{{ $clinic->clinic_id }}', facility_id: facility_id, u_id_old: u_id_old } ,
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

      // set width td
      var widthSimple = $('.td-simple').width();
      $('.td-title').width(100);
      $('.td-will').width(widthSimple);
      $('.td-will-box').width($('.td-will').width() - 3);
    });
  </script>
@stop