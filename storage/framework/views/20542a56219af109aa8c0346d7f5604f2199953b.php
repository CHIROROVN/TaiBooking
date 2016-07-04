<?php $__env->startSection('content'); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約の表示</h3>
      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">患者名</td>
          <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
          <td>
            <?php echo e(date('Y', strtotime($booking->booking_date))); ?>年<?php echo e(date('m', strtotime($booking->booking_date))); ?>月<?php echo e(date('d', strtotime($booking->booking_date))); ?>日（日）　
            <?php echo e($booking->booking_start_time); ?>:00～<?php echo e($booking->booking_start_time); ?>:<?php echo e($booking->booking_total_time); ?>

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
            <?php if( !empty($booking->service_1) && $booking->service_1_kind == 1 ): ?>
              <!-- clinic service -->
              <?php foreach( $clinic_services as $clinic_service ): ?>
                <?php if( $booking->service_1 == $clinic_service->clinic_service_id ): ?>
                <?php echo e($clinic_service->service_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php elseif( !empty($booking->service_1) && ($booking->service_1_kind == 2 || $booking->service_1_kind == 3) ): ?>
              <!-- treatment -->
              <?php foreach( $treatment1s as $treatment1 ): ?>
                <?php if( $booking->service_1 == $treatment1->treatment_id ): ?>
                <?php echo e($treatment1->treatment_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            <?php if( !empty($booking->service_2) && $booking->service_2_kind == 1 ): ?>
              <!-- clinic service -->
              <?php foreach( $clinic_services as $clinic_service ): ?>
                <?php if( $booking->service_2 == $clinic_service->clinic_service_id ): ?>
                <?php echo e($clinic_service->service_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php elseif( !empty($booking->service_2) && ($booking->service_2_kind == 2 || $booking->service_2_kind == 3) ): ?>
              <!-- treatment -->
              <?php foreach( $treatment1s as $treatment1 ): ?>
                <?php if( $booking->service_2 == $treatment1->treatment_id ): ?>
                <?php echo e($treatment1->treatment_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
        </tr>
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
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td><?php echo e($booking->booking_memo); ?></td>
        </tr>
        <tr>
          <td colspan="2" align="center">
            <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.edit', [ $booking->booking_id ])); ?>'" value="予約内容を修正する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='booking_change.html'" value="予約日時を変更する" type="button" class="btn btn-sm btn-page mar-right">
            <input onclick="location.href='booking_cancel_cnf.html'" value="予約をキャンセルする" type="button" class="btn btn-sm btn-page">
          </td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>