@extends('backend.ortho.ortho')
@section('content')
<?php $tmpText = array(); ?>

<?php
// count facility
$countFacility = count($facilitys);
$widthPercent = 88 / ($countFacility);
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
          $text = '院長カレンダー<br>';
          if ( empty($ddrs) ) {
            $text = null;
          } else {
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
          }
        ?>
        <!-- memo infomation -->
        <?php
          $text2 = '伝言メモ<br>';
          if ( empty($memos) ) {
            $text2 = null;
          } else {
            foreach ( $memos as $key => $item ) {
              $text2 .= $item->memo_contents . '<br />';
            }
          }
        ?>
        <div style="position: relative;">
          <div class="ddr-infomation" style="width: 400px; position: absolute; left: 0; top: 0;">
            <div class="ddr-infomation-child ddr-infomation-child-first">
              {!! $text !!}
            </div>
            <div class="ddr-infomation-child">
              {!! $text2 !!}
            </div>
          </div>
          <div class="tbl-user-shift">
            @foreach ( $dataShiftUser as $key => $value )
              {{ $key }}:
              @for ( $i = 0; $i < count($value); $i++ )
                @if ( $i < count($value) - 1 )
                  {{ $value[$i]->u_name_display . ', ' }}
                @else
                  {{ $value[$i]->u_name_display . '.' }}
                @endif
              @endfor
              <br>
            @endforeach
          </div>
        </div>

        <div id="dialog-message" class="ddr-infomation">
          <div class="title">
            {{ formatDateJp($date_current) }}（{{ DayJp($date_current) }}）
          </div>
          <div class="dialog-content">
            <div class="content-left">
              <div class="ddr-infomation-child ddr-infomation-child-dialog">
                {!! $text !!}
              </div>
              <div class="ddr-infomation-child ddr-infomation-child-dialog memo-infomation-child-dialog">
                {!! $text2 !!}
              </div>
            </div>
            <!-- end content-left -->
            <div class="content-right">
              <div class="ddr-infomation-child shift-user-child-dialog">
                @foreach ( $dataShiftUser as $key => $value )
                  {{ $key }}:
                  @for ( $i = 0; $i < count($value); $i++ )
                    @if ( $i < count($value) - 1 )
                      {{ $value[$i]->u_name_display . ', ' }}
                    @else
                      {{ $value[$i]->u_name_display . '.' }}
                    @endif
                  @endfor
                  <br>
                @endforeach
              </div>
            </div>
            <!-- end content-right -->
          </div>
          <!-- end dialog-content -->
        </div>

        <h3 class="text-center mar-top20" style="margin-top: 85px;">{{ formatDateJp($date_current) }}（{{ DayJp($date_current) }}）</h3>
            <p>{{ @$clinic->clinic_name }}</p>
      </div>

      <?php
      $text = '末設定';
      $tmpText = array();
      $str = '';
      ?>
      
      <div class="table-responsive" >
        <table class="table table-bordered">
          <!-- list doctor -->
            <tr>
              <td align="center" rowspan="3"  class="td-col-header" style="width: 7%">ドクター</td>
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
              <td class="" align="center" style="width: {{$widthPercent}}%" ><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
              <td align="center" width="" style="width: {{$widthPercent}}%"><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
              <td align="center" width="" style="width: {{$widthPercent}}%"><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
              <td align="center" rowspan="3" class=" td-col-header" style="width: 7%">衛生士</td>
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
              <td align="center" width="" style="width: {{$widthPercent}}%"><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
              <td align="center" width="" style="width: {{$widthPercent}}%"><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
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
              <td align="center" width="" style="width: {{$widthPercent}}%"><span data-u-id="{{ @$data_u_id }}" data-facility-id="{{ $facility->facility_id }}" class="popup popup-dotor" data-toggle="popover" title="{{ trans('common.popup_header') }}" data-content='
                <ul>
                  {{ $str }}
                </ul>
              '>{{ $text }}</span></td>
              @endforeach
            </tr>
          <!-- 3 -->
        </table>
      </div>
      <!-- end table-responsive -->

      <div class="table-responsive">
        <table class="table table-bordered table-shift-set " id="" style="margin-bottom: 0;">
          <tr>
            <td align="center" width="" style="width: 7%" class="td-title">時間</td>
            @foreach ( $facilitys as $facility )
            <td align="center" style="width: {{$widthPercent}}%" class="td-will" >{{ $facility->facility_name }}</td>
            @endforeach
          </tr>
        </table>

        <div class="inner_table table-responsive scrollbox3" id="scrollbox3">
          <table class="table table-bordered table-shift-set tbl-inner">
            <!-- check "brown", "green", "blue" color -->
          <?php $tmpFlag = array(); ?>
          @foreach ( $times as $time )
          <?php
            $tmp_arr = explode(':', $time);
            $hour = $tmp_arr[0];
            $minute = $tmp_arr[1];
            $fullTime = $hour . $minute;
            $tmpText = array();
            $deleteType = 'single';
          ?>
          <tr>
            <td align="center" style="width: 7%;" class="td-title">{{ $time }} ～</td>
            @foreach ( $facilitys as $facility )
              <?php
                $common_id = $facility->facility_id . '-' . $hour.$minute;
                $facility_id = $facility->facility_id;
                $color = 'brown';
                // $service_id = 0;
                // $fullValue = null;
                $text = '';
                $clsBackgroundPatient = ''; //backgroup-while != null
                $clsBackgroundEmergencyFlag = ''; //backgroup-red == 1
                $clsBackgroundBookingStatus = ''; //backgroup-yellow == 2
                $iconFlag = '';
                $bookingGroupKind1 = '';

                if ( isset($arr_bookings[$facility_id][$fullTime]) ) {
                  // set '↓'
                  $tmpFacilityTimeGroup[] = $arr_bookings[$facility_id][$fullTime]->facility_id . '-' . $arr_bookings[$facility_id][$fullTime]->booking_start_time . '-' . $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;

                  //set deleteType
                  if ( !empty($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id) ) {
                    $deleteType = 'group';
                  }

                  // set flag
                  if ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 1  ) {
                    // service
                    if ( empty($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id) ) {
                      $iconFlag = '';
                    } elseif ( !in_array($arr_bookings[$facility_id][$fullTime]->booking_childgroup_id, $tmpFlag) ) {
                      $tmpFlag[] = $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                      $iconFlag = '<img src="' . asset('') . 'public/backend/ortho/common/image/icon-shift-set2.png" />';
                    } else {
                      $iconFlag = '';
                      // set time, ex: 1600 - 15 = 1545
                      $subTime = $arr_bookings[$facility_id][$fullTime]->booking_start_time - 15;
                      if ( substr($subTime, 2, 1) == '8' ) {
                        $subTime = substr($subTime, 0, 2) . '4' . substr($subTime, 3, 1);
                      }
                      // end set time
                      $str = $arr_bookings[$facility_id][$fullTime]->facility_id . '-' . $subTime . '-' . $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                      if ( in_array($str, $tmpFacilityTimeGroup) ) {
                        $iconFlag = '↓';
                      }
                    }
                    $bookingGroupKind1 = $arr_bookings[$facility_id][$fullTime]->booking_childgroup_id;
                    // treatment1s
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
                      $sPatient .= $booking->p_no . '<br />';
                    }
                    if( !empty($booking->p_name_f) || !empty($booking->p_name_g) ) {
                      $sPatient .= $booking->p_name_f . ' ' . $booking->p_name_g . '<br />';
                    }

                    if ( !empty($sPatient) ) {
                      $clsBackgroundPatient = 'backgroup-while';
                    }

                    if ( !empty($booking->emergency_flag) ) {
                      $clsBackgroundPatient = 'backgroup-red';
                    }

                    if ( !empty($booking->booking_status) ) {
                      $clsBackgroundPatient = 'backgroup-yellow';
                    }

                    $sService = '';
                    if(!empty($services[$booking->service_1]))
                      $sService = @$services[$booking->service_1] . '<br />';

                    if ( $iconFlag == '↓' ) {
                      $text = '<a class="get-position-top" href="' . $link . '" class="facility_id-' . $facility_id . '">' . '<span>' . $iconFlag . '</span></a>';
                      $iconFlag = '';
                    } else {
                      $text = '<a class="get-position-top" href="' . $link . '" class="facility_id-' . $facility_id . '">' . '<span>' . @$sPatient . @$sService . @$sDoctor . '</span></a>';
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
                        $tPatient .= $booking->p_no . '<br />';
                      }
                      if( !empty($booking->p_name_f) || !empty($booking->p_name_g) ) {
                        $tPatient .= $booking->p_name_f . ' ' . $booking->p_name_g . '<br />';
                      }

                      if ( !empty($tPatient) ) {
                        $clsBackgroundPatient = 'backgroup-while';
                      }

                      if ( !empty($booking->emergency_flag) ) {
                        $clsBackgroundPatient = 'backgroup-red';
                      }

                      if ( !empty($booking->booking_status) ) {
                        $clsBackgroundPatient = 'backgroup-yellow';
                      }

                      $tTreatment = '';
                      if(!empty($treatment1s[$booking->service_1])) {
                        $initTreatment = '';
                        $tTreatment = @$treatment1s[$booking->service_1] . '<br />';
                      }

                    } else{
                      $tDoctor = '';
                      $tPatient = '';
                      $tTreatment = '';
                    }

                    if ( $iconFlag == '↓' ) {
                      $text = '<a class="get-position-top" href="' . $link . '" class="facility_id-' . $facility_id . '">' .  '<span>' . $iconFlag . '</span>' . '</a>';
                      $iconFlag = null;
                    } else {
                      $text = '<a class="get-position-top" href="' . $link . '" class="facility_id-' . $facility_id . '">' .  '<span>' . @$initTreatment . @$tPatient  . @$tTreatment . @$tDoctor . '</span>' . '</a>';
                    }
                  }
                  // $text = 'yes';
                } else {
                  // $text = 'no';
                }
              ?>

              <!-- close -->
              <td align="center" width="" style="width: {{$widthPercent}}%" class="col-{{ $color }} {{ $clsBackgroundPatient }} td-will-box" id="td-{{ $common_id }}" booking-group-kind-1="{{ $bookingGroupKind1 }}">
                <div class="td-content" @if ( $color === 'brown' ) data-toggle="modal" data-target="#myModal-{{ $common_id }}" @endif>
                  {!! $iconFlag !!} {!! $text !!}
                  @if ( $color === 'brown' )
                  <img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />
                  @elseif ( ($color === 'blue' && $clsBackgroundPatient == '') || ($color === 'green' && $clsBackgroundPatient == '') )
                    <span class="glyphicon glyphicon-remove btn-close-nobooking" aria-hidden="true" data-id="td-{{ $common_id }}" booking-id="{{ $booking->booking_id }}" delete-type="{{ $deleteType  }}"></span>
                  @endif
                </div>
                <!-- Modal -->
                <div class="modal fade" id="myModal-{{ $common_id }}" role="dialog">
                  <div class="modal-dialog modal-md">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{trans('common.modal_header_popup_edit_clinic_booking_template')}}</h4>
                      </div>
                      <div class="modal-body">
                        <!-- child table -->
                        <table class="table table-bordered" style="margin-top: 20px; float: none;">
                          <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                            <td align="left" style="width: 26%;">業務の選択</td>
                            <td align="left">
                              <select name="" id="clinic_service_id-{{ $common_id }}">
                                <option value="0">閉じる</option>
                                <option value="-1">治療</option>
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td align="left">チェアの選択</td>
                            <td align="left">
                              <select name="" id="facility_id-{{ $common_id }}">
                                @foreach ( $facilitys_popup as $item )
                                <option value="{{ $item->facility_id }}" @if ( $facility->facility_id == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2">
                              <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $common_id }}" data-full-time="{{ $hour.$minute }}" id="btn-save-{{ $common_id }}">{{ trans('common.modal_btn_ok') }}</button>
                            </td>
                          </tr>
                        </table>
                        <!-- end child table -->
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /Modal -->
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
<script src="{{ asset('') }}public/backend/ortho/common/js/enscroll-0.6.2.min.js"></script>
  <script>
    $('.scrollbox3').enscroll({
      showOnHover: true,
      verticalTrackClass: 'track3',
      verticalHandleClass: 'handle3'
    });
  </script>
  <script>

    $(document).ready(function(){
      // when finish regist booking
      // go to position offset top
      var top = $("html").offset();
      var topTable = $("#scrollbox3").offset().top;
      $(window).scroll(function(){
          top = $(this).scrollTop();
      });
      $('#scrollbox3').scroll(function(){
          topTable = $(this).scrollTop();
      });
      $('.get-position-top').click(function (e) {
          var link = $(this).attr('href');
          e.preventDefault();
          //send position to php
          $.ajax({
              url: "{{ route('ortho.bookings.set.position.top.ajax') }}",
              data: { top: top, topTable: topTable } ,
              dataType: 'json',
              type: "get",
              success: function(result) {
                  window.location.href = link;
              }
          });
      });
      //run
      var topResult = getUrlParameter('top');
      var topTableResult = getUrlParameter('topTable');
      if ( topResult > 0 && topTableResult > 0 ) {
          $("html, body").animate({ scrollTop: topResult }, 600);
          $("#scrollbox3").animate({ scrollTop: topTableResult }, 600);
      }
      // end----


      $('.popup').popover({
          html: true
      });

      // show dialog message
      $(window).scroll(function(){
          if ($(this).scrollTop() > 100) {
            $('#dialog-message').fadeIn();
          } else {
            $('#dialog-message').fadeOut();
          }
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
               // console.log(result);
             }
          });
          // end update to table "t_shift"
        });
      });
      // end set value from popup


      // set popup treatment
      var facilityIdOld = 0;
      var serviceIdOld = 0;
      var tdObjOld = '';


      $('.td-content').click(function(event) {
        facilityIdOld = $(this).attr('data-facility-id');
        serviceIdOld = $(this).attr('data-service-id');

        var dataId = $(this).attr('data-id');
        tdObjOld = $('#td-' + dataId);

        // ser selected for select option
        $('#clinic_service_id-' + dataId + ' option').each(function() {
          if ( $(this).val() == serviceIdOld ) {
            $(this).prop("selected", true);
          }
        });
      });

      // button close from no booking
      $(".btn-close-nobooking").click(function(event){
        var dataId = $(this).attr('data-id');
        tdObjOld = $('#' + dataId);
        var booking_id = $(this).attr('booking-id');
        var delete_type = $(this).attr('delete-type');
        var booking_group_kind_1 = tdObjOld.attr('booking-group-kind-1');
        //setClear(tdObjOld, 0);
        $.ajax({
          url: "{{ route('ortho.bookings.delete.single.group') }}",
          type: 'get',
          dataType: 'json',
          data: {
            booking_id: booking_id,
            delete_type: delete_type
          },
          success: function(result){
            //console.log(result);
            /*if ( delete_type === 'group' ) {
              $('.td-will-box').each(function() {
                if ( $(this).attr('booking-group-kind-1') == booking_group_kind_1 ) {
                  setClear($(this), 0);
                }
              });
            }*/
            location.reload();
          }
        }); // end ajax
      }); // end click

      // button save
      $(".btn-save").click(function(event){
        event.preventDefault();

        var data_id = $(this).attr('data-id');
        var dataFullTime = $(this).attr('data-full-time');

        // new value
        var serviceIdNew = $('#clinic_service_id-' + data_id).val();
        var serviceTextNew = $('#clinic_service_id-' + data_id).find('option:selected').text();
        var facilityIdNew = $('#facility_id-' + data_id).val();
        var fullValue = facilityIdNew + '|' + serviceIdNew + '|' + dataFullTime;

        // set color td
        var tdObjNew = $('#td-' + facilityIdNew + '-' + dataFullTime);
        // console.log(tdObjNew.attr('class'));

        // green
        if ( serviceIdNew < 0 ) {
          // blue
          setClear(tdObjOld, 0);
          setBlue(tdObjNew, serviceIdNew, fullValue, serviceTextNew);

          // insert to table "t_booking"
          $.ajax({
            url: "{{ route('ortho.bookings.insert.insert') }}",
            type: 'get',
            dataType: 'json',
            data: {
              facility_id: facilityIdNew,
              time: dataFullTime,
              booking_date: '{{ $date_current }}',
              clinic_id: '{{ @$clinic->clinic_id }}'
            },
            success: function(result){
              // tdObjNew.children().attr('data-booking-id', result[1].booking_id);
              // tdObjNew.children().attr('data-toggle', null);
              // tdObjNew.children().attr('data-target', null);
              // var bookingID = result[1].booking_id;
              // var link = "{{ asset('') }}ortho/bookings/booking-regist/" + bookingID;
              // tdObjNew.children().html('<a href="' + link + '" class="facility_id-10"><span>治療</span></a>')
              location.reload();
            }
          });
        } else if ( serviceIdNew == 0 ) {
          // brown
        } else {
          // green
        }

        $('#myModal-' + data_id).modal('hide');
      });

      function setGreen(objNew, serviceIdNew, value, text, group) {
        tdNewCls = objNew.attr('class');
        objNew.removeClass(tdNewCls);
        objNew.addClass('col-green');
        // objNew.children().attr('class', 'td-content');
        objNew.find('.td-content').html(' ');
        objNew.find('.td-content').append('');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // set group
        objNew.find('.td-content').addClass(group);
        objNew.find('.td-content').attr('data-group', group);
        // set value for hidden iput
        objNew.find('.td-content').html(text);
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
      }

      function setBlue(objNew, serviceIdNew, value, text, group) {
        tdNewCls = objNew.attr('class');
        objNew.removeClass(tdNewCls);
        objNew.addClass('col-blue');
        // objNew.children().attr('class', 'td-content');
        objNew.find('.td-content').html('');
        objNew.find('.td-content').append('');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // get group
        objNew.find('.td-content').addClass(group);
        objNew.find('.td-content').attr('data-group', group);
        // set value for hidden iput
        objNew.find('.td-content').html(text);
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
      }

      function setBrow(objNew, serviceIdNew, value, group) {
        tdNewCls = objNew.attr('class');
        if ( tdNewCls != 'col-brown' ) {
          objNew.removeClass(tdNewCls);
          objNew.addClass('col-brown');
          objNew.find('.td-content').html('');
          objNew.find('.td-content').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // set group
        objNew.find('.td-content').attr('data-group', group);
        // set value for hidden iput
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
        }
      }

      function setClear(objNew, serviceIdNew) {
        tdNewCls = objNew.attr('class');
        if ( tdNewCls != 'col-brown' ) {
          objNew.removeClass(tdNewCls);
          objNew.addClass('col-brown');
          objNew.find('.td-content').html('');
          objNew.find('.td-content').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
          // set service id
          objNew.find('.td-content').attr('data-service-id', serviceIdNew);
          // set group
          objNew.find('.td-content').attr('data-group', '');
          objNew.find('.td-content').attr('data-booking-id', '');
          objNew.find('.td-content > .input').val('');
          objNew.find('.td-content > .input').attr('name', '');
        }
      }

      function getUrlParameter(sParam) {
          var sPageURL = decodeURIComponent(window.location.search.substring(1)),
              sURLVariables = sPageURL.split('&'),
              sParameterName,
              i;

          for (i = 0; i < sURLVariables.length; i++) {
              sParameterName = sURLVariables[i].split('=');

              if (sParameterName[0] === sParam) {
                  return sParameterName[1] === undefined ? true : sParameterName[1];
              }
          }
      };
    });
  </script>
@stop