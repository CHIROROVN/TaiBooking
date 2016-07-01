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
          {!! Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <!-- start_date -->
          <input type="hidden" name="start_date" value="{{ $start_date }}">
          <!-- month prev -->
          <input type="hidden" name="month_cur" value="<?php echo (($month_current - 1) >= 1) ? ($month_current - 1) : 1; ?>">
          <input type="submit" name="" id="button" value="&lt;&lt; 前月" class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month current -->
          {!! Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <!-- start_date -->
          <input type="hidden" name="start_date" value="{{ $start_date }}">
          <input type="hidden" name="month_cur" value="{{ date('m', strtotime($date_current)) }}">
          <input type="submit" name="" id="button2" value="今月"  class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month next -->
          {!! Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <!-- start_date -->
          <input type="hidden" name="start_date" value="{{ $start_date }}">
          <input type="hidden" name="month_cur" value="<?php echo (($month_current + 1) <= 12) ? ($month_current + 1) : 12; ?>">
          <input type="submit" name="" id="button3" value="翌月 &gt;&gt;"  class="btn btn-sm btn-page"/>
          </form>

          <h3 class="text-center mar-top20">{{ date('Y', strtotime($date_current)) }}年{{ $month_current }}月{{ date('d', strtotime($date_current)) }}日（土）</h3>

          <p>たい矯正歯科</p>
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
              <td align="center">時間</td>
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
            ?>
            <tr>
              <td align="center">{{ $time }}～</td>
              @foreach ( $facilitys as $facility )
                @if ( isset($arr_bookings[$facility->facility_id][$time]) && ($arr_bookings[$facility->facility_id][$time]->booking_start_time == $hour && $arr_bookings[$facility->facility_id][$time]->booking_total_time >= $minute && !empty($arr_bookings[$facility->facility_id][$time]->clinic_id) && !empty($arr_bookings[$facility->facility_id][$time]->facility_id)) )
                  @if ( !empty($arr_bookings[$facility->facility_id][$time]->service_1) && $arr_bookings[$facility->facility_id][$time]->service_1 == 1 )
                  <td align="center" class="col-green">
                    <a href="{{ route('ortho.bookings.booking.detail', [ $arr_bookings[$facility->facility_id][$time]->booking_id ]) }}">
                    <img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />{{ $arr_bookings[$facility->facility_id][$time]->p_name }}</a>
                  </td>
                  @elseif ( !empty($arr_bookings[$facility->facility_id][$time]->service_1) && $arr_bookings[$facility->facility_id][$time]->service_1 == 2 )
                  <td align="center" class="col-blue">
                    <a href="{{ route('ortho.bookings.booking.detail', [ $arr_bookings[$facility->facility_id][$time]->booking_id ]) }}">{{ $arr_bookings[$facility->facility_id][$time]->p_name }}</a>
                  </td>
                  @endif
                @else
                <td align="center" class="col-brown"><a href="2"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></a></td>
                @endif
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