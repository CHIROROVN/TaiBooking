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

            <div class="table-responsive">
          <table class="table table-bordered">
            <!-- doctor -->
            @for ( $j = 1; $j <= $rowspanDoctor; $j++ )
              <tr>
                <td align="center" rowspan="{{ $rowspanDoctor }}" class="col-title">ドクター</td>
                @foreach ( $doctors as $doctor )
                <td align="center">{{ $doctor->u_name }}</td>
                @endforeach
              </tr>
            @endfor

            <!-- hygienists -->
            @for ( $j = 1; $j <= $rowspanHygienists; $j++ )
              <tr>
                <td align="center" rowspan="{{ $rowspanHygienists }}" class="col-title">衛生士</td>
                @foreach ( $hygienists as $hygienist )
                <td align="center">{{ $hygienist->u_name }}</td>
                @endforeach
              </tr>
            @endfor
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
              <td align="center">{{ $time }}～</td>
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
                      $br = '<br />';
                      if ( empty($arr_bookings[$facility_id][$time]->p_name) ) {
                        $br = '';
                      }
                      $text = '<a href="' . $link . '">' . $arr_bookings[$facility_id][$time]->p_name . $br . @$clinicServices[$arr_bookings[$facility_id][$time]->service_1]->service_name . '</a>';
                    } elseif ( $arr_bookings[$facility_id][$time]->service_1_kind == 2 ) {
                      $color = 'blue';
                      $text = '<a href="' . $link . '">' . '治療' . '</a>';
                    } 
                    if ( $arr_bookings[$facility_id][$time]->service_2_kind == 1 ) {
                      $color = 'green';
                      $br = '<br />';
                      if ( empty($arr_bookings[$facility_id][$time]->p_name) ) {
                        $br = '';
                      }
                      $text = '<a href="' . $link . '">' . $arr_bookings[$facility_id][$time]->p_name . $br . @$clinicServices[$arr_bookings[$facility_id][$time]->service_2]->service_name . '</a>';
                    } elseif ( $arr_bookings[$facility_id][$time]->service_2_kind == 2 ) {
                      $color = 'blue';
                      $text = '<a href="' . $link . '">' . '治療' . '</a>';
                    }
                  }
                ?>

                <!-- close -->
                <td align="center" class="col-{{ $color }}" id="td-{{ $common_id }}">
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