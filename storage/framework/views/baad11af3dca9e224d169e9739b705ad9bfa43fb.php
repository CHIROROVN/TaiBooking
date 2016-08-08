<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>予約管理　＞　予約枠の検索結果（リスト表示）</h3>
    <div class="msg-alert-action margin-top-15">
      <?php if($message = Session::get('success')): ?>
        <div class="alert alert-success  alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> <?php echo e($message); ?></li></strong></ul>
        </div>
      <?php elseif($message = Session::get('danger')): ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> <?php echo e($message); ?></li></strong></ul>
        </div>
      <?php endif; ?>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
            <td class="col-title" align="center">日付</td>
            <td class="col-title" align="center">時間帯</td>
            <td class="col-title" align="center">設備</td>
            <td class="col-title" align="center">業務</td>
            <td class="col-title" align="center">予約簿の表示</td>
            <td class="col-title" align="center">予約の登録</td>
        </tr>
        <?php if(!count($bookings)): ?>
          <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
        <?php else: ?>
          <?php foreach($bookings as $booking): ?>
            <tr>
              <td><?php echo e(formatDate($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)</td>
              <td><?php echo e(splitHourMin($booking->booking_start_time)); ?></td>
              <td><?php echo e(@$facilities[$booking->facility_id]); ?></td>
              <td>
              <!-- service 1 -->
                  <?php if($booking->service_1_kind == 1): ?>
                    <?php echo e(@$services[$booking->service_1]); ?>

                  <?php elseif($booking->service_1_kind == 2): ?>
                    <?php if($booking->service_1 != -1): ?>
                      <?php echo e($treatment1s[$booking->service_1]); ?>

                    <?php endif; ?>
                  <?php endif; ?>
                  <!-- Service 2 -->
                  <?php if($booking->service_2_kind == 1): ?>
                    <?php if(!empty($services[$booking->service_2])): ?>
                      <?php if(!empty($services[$booking->service_1]) && !empty($services[$booking->service_2])): ?>、 <?php endif; ?> <?php echo e(@$services[$booking->service_2]); ?>

                    <?php endif; ?>
                  <?php elseif($booking->service_2_kind == 2): ?>
                    <?php if($booking->service_2 != -1): ?>
                       <?php if(!empty($treatment1s[$booking->service_1]) && !empty($treatment1s[$booking->service_2])): ?>、<?php endif; ?> <?php echo e($treatment1s[$booking->service_2]); ?>

                    <?php endif; ?>
                  <?php endif; ?>
              </td>
              <td align="center">
                <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.daily', [ 'clinic_id' => $booking->clinic_id, 'cur' => $booking->booking_date] )); ?>'" value="予約簿の表示" type="button" class="btn btn-xs btn-page">
                </td>
                <td align="center"><input onclick="location.href='<?php echo e(route('ortho.bookings.booking.regist', $booking->booking_id)); ?>'" value="予約の登録" type="button" class="btn btn-xs btn-page"/></td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
        <?php echo $bookings->appends(
        ['clinic_id'=>@$clinic_id,
        'doctor_id'=>@$doctor_id,
        'hygienist_id'=>@$hygienist_id,
        'booking_date'=>@$booking_date,
        'week_later'=>@$week_later,
        'clinic_service_name'=>@$clinic_service_name]
        )->render(new App\Pagination\SimplePagination($bookings)); ?>

        </div>
      </div>

  </div>
</section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>