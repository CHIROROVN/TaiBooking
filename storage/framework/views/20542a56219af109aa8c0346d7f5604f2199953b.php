<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約の表示</h3>

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

      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">患者名</td>
          <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name_f); ?> <?php echo e($booking->p_name_g); ?></td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
          <td>
            <?php echo e(formatDateJp($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)　<?php echo e(splitHourMin($booking->booking_start_time)); ?><!-- ～<?php echo e(toTime($booking->booking_start_time, $booking->booking_total_time)); ?> -->
            </td>
        </tr>
        <tr>
          <td class="col-title">医院</td>
          <td><?php echo e($booking->clinic_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">チェアー</td>
          <td><?php echo e($booking->facility_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">ドクター</td>
          <td>
            <?php foreach( $doctors as $doctor ): ?>
              <?php if( $doctor->id == $booking->doctor_id ): ?>
              <?php echo e($doctor->u_name); ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">衛生士</td>
          <td>
            <?php foreach( $hys as $hy ): ?>
              <?php if( $hy->id == $booking->hygienist_id ): ?>
              <?php echo e($hy->u_name); ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">装置</td>
          <td><?php echo e($booking->equipment_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">処置内容-1</td>
          <td>
            <?php if($booking->service_1_kind == '1'): ?>
            <?php echo e(@$services[$booking->service_1]); ?>

            <?php elseif($booking->service_1_kind == '2'): ?>
            <?php echo e(@$treatment1s[$booking->service_1]); ?>

            <?php endif; ?>
          </td>
        </tr>
        <!-- <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            <?php if($booking->service_2_kind == '1'): ?>
            <?php echo e(@$services[$booking->service_2]); ?>

            <?php elseif($booking->service_2_kind == '2'): ?>
            <?php echo e(@$treatment1s[$booking->service_2]); ?>

            <?php endif; ?>
          </td>
        </tr> -->
        <tr>
          <td class="col-title">検査</td>
          <td><?php echo e($booking->inspection_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">保険診療</td>
          <td><?php echo e($booking->insurance_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">救急</td>
          <td><?php echo ($booking->emergency_flag == 1) ? '救急です' : 'ノーマル'; ?></td>
        </tr>
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <?php if( $booking->booking_status == 1 ): ?>
            通常
            <?php elseif( $booking->booking_status == 2 ): ?>
            「TEL待ち」です
            <?php elseif( $booking->booking_status == 3 ): ?>
            「リコール」です→ <?php echo (empty($booking->booking_recall_ym)) ? '' : date('Y-m', strtotime($booking->booking_recall_ym)); ?>
            <?php elseif( $booking->booking_status == 4 ): ?>
            未作成技工物TEL待ち
            <?php elseif( $booking->booking_status == 5 ): ?>
            作成済み技工物キャンセル
            <?php elseif( $booking->booking_status == 6 ): ?>
            無断キャンセル
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">登録者</td>
          <td><?php echo e(@$list_doctors[$booking->first_user]); ?></td>
        </tr>
        <tr>
          <td class="col-title">登録日時</td>
          <td><?php echo e(@dateHourMinSecond($booking->first_date, '/')); ?></td>
        </tr>
        <tr>
          <td class="col-title">最終更新者</td>
          <td><?php echo e(@$list_doctors[$booking->last_user]); ?></td>
        </tr>
        <tr>
          <td class="col-title">最終更新日時</td>
          <td><?php echo e(@dateHourMinSecond($booking->last_date, '/')); ?></td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td><?php echo @$booking->booking_memo ?></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.edit', [ $booking->booking_id ])); ?>'" value="予約内容を修正する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='<?php echo e(route('ortho.bookings.booking_change_date', $booking->booking_id)); ?>'" value="予約日時を変更する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.cancel_cnf', [ $booking->booking_id ])); ?>'" value="予約をキャンセルする" type="button" class="btn btn-sm btn-page">
          </td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.result.calendar', [ 'start_date' => $start_date ])); ?>'" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>