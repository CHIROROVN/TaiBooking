<?php $__env->startSection('content'); ?>

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
          <?php echo Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')); ?>

          <!-- start_date -->
          <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
          <!-- month prev -->
          <input type="hidden" name="month_cur" value="<?php echo (($month_current - 1) >= 1) ? ($month_current - 1) : 1; ?>">
          <input type="submit" name="" id="button" value="&lt;&lt; 前月" class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month current -->
          <?php echo Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')); ?>

          <!-- start_date -->
          <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
          <input type="hidden" name="month_cur" value="<?php echo e(date('m', strtotime($date_current))); ?>">
          <input type="submit" name="" id="button2" value="今月"  class="btn btn-sm btn-page"/>
          </form>
          
          <!-- month next -->
          <?php echo Form::open(array('route' => 'ortho.bookings.booking.result.calendar', 'method' => 'get', 'enctype'=>'multipart/form-data', 'style' => 'display: inline-block')); ?>

          <!-- start_date -->
          <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">
          <input type="hidden" name="month_cur" value="<?php echo (($month_current + 1) <= 12) ? ($month_current + 1) : 12; ?>">
          <input type="submit" name="" id="button3" value="翌月 &gt;&gt;"  class="btn btn-sm btn-page"/>
          </form>

          <h3 class="text-center mar-top20"><?php echo e(date('Y', strtotime($date_current))); ?>年<?php echo e($month_current); ?>月<?php echo e(date('d', strtotime($date_current))); ?>日（土）</h3>

          <p>たい矯正歯科</p>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered">
            <!-- doctor -->
            <?php for( $j = 1; $j <= $rowspanDoctor; $j++ ): ?>
              <tr>
                <td align="center" rowspan="<?php echo e($rowspanDoctor); ?>" class="col-title">ドクター</td>
                <?php foreach( $doctors as $doctor ): ?>
                <td align="center"><?php echo e($doctor->u_name); ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endfor; ?>

            <!-- hygienists -->
            <?php for( $j = 1; $j <= $rowspanHygienists; $j++ ): ?>
              <tr>
                <td align="center" rowspan="<?php echo e($rowspanHygienists); ?>" class="col-title">衛生士</td>
                <?php foreach( $hygienists as $hygienist ): ?>
                <td align="center"><?php echo e($hygienist->u_name); ?></td>
                <?php endforeach; ?>
              </tr>
            <?php endfor; ?>
          </table>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center">時間</td>
              <?php foreach( $facilitys as $facility ): ?>
              <td align="center"><?php echo e($facility->facility_name); ?></td>
              <?php endforeach; ?>
            </tr>

            <!-- check "brown", "green", "blue" color -->
            <?php foreach( $times as $time ): ?>
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0]; // printf( "%02d", $tmp_arr[0] );
              $minute = $tmp_arr[1]; //printf( "%02d", $tmp_arr[1] );
            ?>
            <tr>
              <td align="center"><?php echo e($time); ?>～</td>
              <?php foreach( $facilitys as $facility ): ?>
                <?php if( isset($arr_bookings[$facility->facility_id][$time]) && ($arr_bookings[$facility->facility_id][$time]->booking_start_time == $hour && $arr_bookings[$facility->facility_id][$time]->booking_total_time >= $minute && !empty($arr_bookings[$facility->facility_id][$time]->clinic_id) && !empty($arr_bookings[$facility->facility_id][$time]->facility_id)) ): ?>
                  <?php if( !empty($arr_bookings[$facility->facility_id][$time]->service_1) && $arr_bookings[$facility->facility_id][$time]->service_1 == 1 ): ?>
                  <td align="center" class="col-green">
                    <a href="<?php echo e(route('ortho.bookings.booking.detail', [ $arr_bookings[$facility->facility_id][$time]->booking_id ])); ?>">
                    <img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/icon-shift-set.png" /><?php echo e($arr_bookings[$facility->facility_id][$time]->p_name); ?></a>
                  </td>
                  <?php elseif( !empty($arr_bookings[$facility->facility_id][$time]->service_1) && $arr_bookings[$facility->facility_id][$time]->service_1 == 2 ): ?>
                  <td align="center" class="col-blue">
                    <a href="<?php echo e(route('ortho.bookings.booking.detail', [ $arr_bookings[$facility->facility_id][$time]->booking_id ])); ?>"><?php echo e($arr_bookings[$facility->facility_id][$time]->p_name); ?></a>
                  </td>
                  <?php endif; ?>
                <?php else: ?>
                <td align="center" class="col-brown"><a href="2"><img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/img-col-shift-set.png" /></a></td>
                <?php endif; ?>
              <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
            
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>