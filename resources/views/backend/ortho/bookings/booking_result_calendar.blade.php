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

  // echo $totalRecordDoctor.'-dfw3erf-'.$numberRowDoctor;
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

        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- doctor -->
            @for ( $j = 1; $j <= $rowspanDoctor; $j++ )
              <tr>
                <td align="center" rowspan="{{ $rowspanDoctor }}" class="col-title" style="width: 70px;">ドクター</td>
                @foreach ( $doctors as $doctor )
                <td align="center">{{ $doctor->u_name }}</td>
                @endforeach
              </tr>
            @endfor

            <!-- hygienists -->
            @for ( $j = 1; $j <= $rowspanHygienists; $j++ )
              <tr>
                <td align="center" rowspan="{{ $rowspanHygienists }}" class="col-title" style="width: 70px;">衛生士</td>
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
              <td align="center" width="10%" style="width: 70px;">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center">{{ $facility->facility_name }}</td>
              @endforeach
            </tr>

            <!-- check "brown", "green", "blue" color -->
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0]; // printf( "%02d", $tmp_arr[0] );
              $minute = $tmp_arr[1]; //printf( "%02d", $tmp_arr[1] );
              $fullTime = $hour . $minute;
            ?>
            <tr>
              <td align="center" style="width: 70px;">{{ $time }}～</td>
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
                      $text = '<a href="' . $link . '">' . $arr_bookings[$facility_id][$fullTime]->p_name . $br . @$services[$arr_bookings[$facility_id][$fullTime]->service_1] . '</a>';
                    } elseif ( $arr_bookings[$facility_id][$fullTime]->service_1_kind == 2 ) {
                      $color = 'blue';
                      $text = '<a href="' . $link . '">' . '治療' . '</a>';
                    }
                    // if ( $arr_bookings[$facility_id][$fullTime]->service_2_kind == 1 ) {
                    //   $color = 'green';
                    //   $br = '<br />';
                    //   if ( empty($arr_bookings[$facility_id][$fullTime]->p_name) ) {
                    //     $br = '';
                    //   }
                    //   $text = '<a href="' . $link . '">' . $arr_bookings[$facility_id][$fullTime]->p_name . $br . @$services[$arr_bookings[$facility_id][$fullTime]->service_2] . '</a>';
                    // } elseif ( $arr_bookings[$facility_id][$fullTime]->service_2_kind == 2 ) {
                    //   $color = 'blue';
                    //   $text = '<a href="' . $link . '">' . '治療' . '</a>';
                    // }
                  }
                ?>

                <!-- close -->
                <td align="center" class="col-{{ $color }}" id="">
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
  // $(document).ready(function(){
  //   $(".table-responsive table.table-bordered tr td").click(function(){
  //     window.location.href = 'booking_regist.html';
  //   });
  // });

</script>

@endsection