<?php $__env->startSection('content'); ?>
	<!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「作成済み技工物キャンセル」の表示</h3>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <td class="col-title" align="center">医院名</td>
              <td class="col-title" align="center">最終来院日</td>
              <td class="col-title" align="center">当初予約日時</td>
              <td class="col-title" align="center">カルテNo</td>
              <td class="col-title" align="center">患者名</td>
              <td class="col-title" align="center">電話番号</td>
              <td class="col-title" align="center" style="min-width:135px;">最終処置内容-1-2</td>
              <td class="col-title" align="center" style="min-width:50px;">備考</td>
              <td class="col-title" align="center" style="min-width:120px;">予約情報の編集</td>
            </tr>
            <?php if( !empty($list5s) && count($list5s) > 0 ): ?>
              <?php foreach( $list5s as $list5 ): ?>
              <tr>
                <td><?php echo e($list5->clinic_name); ?></td>
                <td><?php echo e(formatDate($list5->result_date, '/')); ?></td>
                <td><?php echo e(formatDate($list5->booking_date, '/')); ?> <?php echo e(splitHourMin($list5->booking_start_time)); ?>～<?php echo e(toTime($list5->booking_start_time, $list5->booking_total_time)); ?></td>
                <td><?php echo e($list5->p_no); ?></td>
                <td><?php echo e($list5->p_name); ?></td>
                <td><?php echo e($list5->p_tel); ?></td>
                <td>
                  <!-- service 1 -->
                  <?php if( $list5->service_1_kind == 1 ): ?>
                    <?php echo e(@$services[$list5->service_1]); ?>

                  <?php elseif( $list5->service_1_kind == 2 ): ?>
                    <?php echo e(@$treatment1s[$list5->service_1]); ?>

                  <?php endif; ?>
                  <!-- service 2 -->
                  <?php if( $list5->service_2_kind == 1 ): ?>
                    <?php echo e(@$services[$list5->service_2]); ?>

                  <?php elseif( $list5->service_2_kind == 2 ): ?>
                    <?php echo e(@$treatment1s[$list5->service_2]); ?>

                  <?php endif; ?>
                </td>
                <td><?php echo e($list5->result_memo); ?></td>
                <td align="center"><input onclick="location.href='<?php echo e(route('ortho.bookings.booking.edit', [ $list5->booking_id ])); ?>'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="9" style="text-align: center;">該当するデータがありません。</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>    
  </section>
  <!-- End content list1 list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>