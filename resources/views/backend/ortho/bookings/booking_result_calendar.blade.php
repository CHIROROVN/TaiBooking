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
          <!-- start -->
          <input type="hidden" name="start" value="{{ $start }}">
          <!-- month prev -->
          <input type="hidden" name="month_cur" value="<?php echo (($month_current - 1) >= 1) ? ($month_current - 1) : 1; ?>">
          <input type="submit" name="" id="button" value="&lt;&lt; 前月" class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month current -->
          {!! Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <!-- start -->
          <input type="hidden" name="start" value="{{ $start }}">
          <input type="hidden" name="month_cur" value="{{ date('m', strtotime($date_current)) }}">
          <input type="submit" name="" id="button2" value="今月"  class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month next -->
          {!! Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')) !!}
          <!-- start -->
          <input type="hidden" name="start" value="{{ $start }}">
          <input type="hidden" name="month_cur" value="<?php echo (($month_current + 1) <= 12) ? ($month_current + 1) : 12; ?>">
          <input type="submit" name="" id="button3" value="翌月 &gt;&gt;"  class="btn btn-sm btn-page"/>
          </form>

          <h3 class="text-center mar-top20">{{ date('Y', strtotime($date_current)) }}年{{ date('m', strtotime($date_current)) }}月{{ date('d', strtotime($date_current)) }}日（土）</h3>

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
<!--               <td align="center">チェアー1</td>
              <td align="center">チェアー2</td>
              <td align="center">チェアー3</td>
              <td align="center">チェアー4</td>
              <td align="center">チェアー5</td>
              <td align="center">チェアー6</td>
              <td align="center">チェアー7</td>
              <td align="center">チェアー8</td>
              <td align="center">チェアー9</td>
              <td align="center">チェアー10</td>
              <td align="center">チェアー11</td>
              <td align="center">診断</td>
              <td align="center">相談</td>
              <td align="center">レントゲン</td>
              <td align="center">CT</td>
              <td align="center">筋電図</td> -->
            </tr>
            <?php $count_facilitys = count($facilitys); ?>
            @foreach ( $times as $time )
            <tr>
              <td align="center">{{ $time }}～</td>
              @for ( $i = 1; $i <= $count_facilitys; $i++ )
                @foreach ( $bookings as $booking )
                  @if ( empty($booking->patient_id) )
                  <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
                  @else
                  <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />{{ $booking->p_name }}</td>
                  @endif
                @endforeach
              @endfor
            </tr>
            @endforeach
            <!-- <tr>
              <td align="center">09:00～</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:15～</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:30～</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:45～</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">10:00～</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">10:10～</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-green"><img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />末設1</td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
            </tr> -->
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