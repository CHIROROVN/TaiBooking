@extends('backend.ortho.ortho')
@section('content')
<?php
  // doctor
  $totalRecordDoctor    = count($doctors);
  $numberRowDoctor      = ceil($totalRecordDoctor / 15);
  $rowspanDoctor        = $numberRowDoctor;
  if ( $numberRowDoctor == 0 ) {
    $rowspanDoctor = 1;
  }

  // hygienists
  $totalRecordHygienists  = count($hygienists);
  $numberRowHygienists    = ceil($totalRecordHygienists / 15);
  $rowspanHygienists      = $numberRowHygienists;
  if ( $rowspanHygienists == 0 ) {
    $rowspanHygienists = 1;
  }

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
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0]; // printf( "%02d", $tmp_arr[0] );
              $minute = $tmp_arr[1]; //printf( "%02d", $tmp_arr[1] );
            ?>
            <tr>
              <td align="center" width="6%">{{ $time }}～</td>
              @if ( empty($facilitys) )
              <td align="center">&nbsp;</td>
              @endif
              @foreach ( $facilitys as $facility )
                <?php
                  $common_id = $facility->facility_id . '-' . $hour.$minute;
                  $facility_id = $facility->facility_id;
                  $color = 'brown';
                  $service_id = 0;
                  $fullValue = null;
                  $text = '';

                  if ( isset($arr_bookings[$facility_id][$time]) ) {
                    $hour_template = substr($arr_bookings[$facility->facility_id][$time]->booking_start_time , 0, 2);
                    $minute_template = substr($arr_bookings[$facility->facility_id][$time]->booking_start_time , 2, 2);

                    if ( empty($arr_bookings[$facility_id][$time]->patient_id) ) {
                      $link = route('ortho.bookings.booking.regist', $arr_bookings[$facility_id][$time]->booking_id);
                    } else {
                      $link = route('ortho.bookings.booking.detail', $arr_bookings[$facility_id][$time]->booking_id);
                    }
                    if ( $arr_bookings[$facility_id][$time]->service_1_kind == 1 ) {
                      $color = 'green';
                      $sdoctor = '';
                      if(!empty($list_doctors[$arr_bookings[$facility_id][$time]->doctor_id])){
                        $sdoctor = @$list_doctors[$arr_bookings[$facility_id][$time]->doctor_id];
                      }
                      $spatient = '';
                      if (!empty($arr_bookings[$facility_id][$time]->p_name) ) {
                        $spatient =  '<br />' . $arr_bookings[$facility_id][$time]->p_name . '<br />';
                      }
                      $sservice = '';
                      if(!empty($services[$arr_bookings[$facility_id][$time]->service_1])){
                        $sservice = @$services[$arr_bookings[$facility_id][$time]->service_1];
                      }

                      $text = '<a href="' . $link . '">' . @$sdoctor . @$spatient . @$sservice . '</a>';

                    } elseif ( $arr_bookings[$facility_id][$time]->service_1_kind == 2 ) {
                      $color = 'blue';
                      $setTreatment = '治療';
                      $tdoctor    = '';
                      if(!empty($list_doctors[$arr_bookings[$facility_id][$time]->doctor_id])){
                        $setTreatment = '';
                        $tdoctor    = @$list_doctors[$arr_bookings[$facility_id][$time]->doctor_id] .'<br />';
                      }
                      $tpatient = '';
                      if(!empty($arr_bookings[$facility_id][$time]->p_name)){
                        $setTreatment = '';
                        $tpatient  = $arr_bookings[$facility_id][$time]->p_name .'<br />';
                      }

                      $ttreatment = '';
                      if(!empty($treatment1s[$arr_bookings[$facility_id][$time]->service_1])){
                        $setTreatment = '';
                        $ttreatment = @$treatment1s[$arr_bookings[$facility_id][$time]->service_1];
                      }

                      $text = '<a href="' . $link . '">' . @$setTreatment . @$tdoctor . @$tpatient . @$ttreatment . '</a>';
                    }
                  }
                ?>

                <!-- close -->
                <td align="center" class="col-{{ $color }}" id="td-{{ $common_id }}" width="142px">
                  <div class="td-content {{ @$clsNameGroup }}" data-id="{{ $common_id }}" data-service-id="{{ $service_id }}" data-facility-id="{{ $facility_id }}" data-full-time="{{ $hour.$minute }}" data-hour="{{ $hour }}" data-minute="{{ $minute }}" data-toggle="modal" data-target="#myModal-{{ $common_id }}" data-group="{{ @$clsNameGroup }}">
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
                </tr>

              </table>
            </div>
        </div>
      </div>
    </section>
@endsection