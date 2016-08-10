<?php $__env->startSection('content'); ?>
	<!-- content list1 list -->
    <section id="page">
      <div class="container content-page">
        <h3>各種リスト表示　＞　「TEL待ちリスト」の表示</h3>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <td class="col-title" align="center">医院名</td>
                <td class="col-title" align="center">最終来院日</td>
                <td class="col-title" align="center">カルテNo</td>
                <td class="col-title" align="center">患者名</td>
                <td class="col-title" align="center">電話番号</td>
                <td class="col-title" align="center">業務内容-1-2</td>
                <td class="col-title" align="center">備考</td>
                <td class="col-title" align="center" style="min-width:120px">予約情報の編集</td>
              </tr>
              <?php if(!count($list1)): ?>
              	<tr><td colspan="8" style="text-align: center;">該当するデータがありません。</td></tr>
              <?php else: ?>
	              <?php foreach($list1 as $l1): ?>
	              	<tr>
		                <td><?php echo e($l1->clinic_name); ?></td>
		                <td><?php echo e(formatDate($l1->booking_date)); ?></td>
		                <td><?php echo e($l1->p_no); ?></td>
		                <td><?php echo e($l1->p_name); ?></td>
		                <td><?php echo e($l1->p_tel); ?></td>
                    <td>
                      <!-- service 1 -->
                      <?php if( $l1->service_1_kind == 1 ): ?>
                        <?php echo e(@$services[$l1->service_1]); ?>

                      <?php elseif( $l1->service_1_kind == 2 ): ?>
                        <?php echo e(@$treatment1s[$l1->service_1]); ?>

                      <?php endif; ?>
                      <!-- service 2 -->
                      <?php if( $l1->service_2_kind == 1 ): ?>
                         <?php if(!empty($services[$l1->service_1]) || !empty($treatment1s[$l1->service_1])): ?>、<?php endif; ?> <?php echo e(@$services[$l1->service_2]); ?>

                      <?php elseif( $l1->service_2_kind == 2 ): ?>
                        <?php if(!empty($services[$l1->service_1]) || !empty($treatment1s[$l1->service_1])): ?>、<?php endif; ?> <?php echo e(@$treatment1s[$l1->service_2]); ?>

                      <?php endif; ?>
                    </td>
		                <td><?php echo e($l1->booking_memo); ?></td>
		                <td align="center"><input onclick="location.href='<?php echo e(route('ortho.bookings.booking.edit', $l1->booking_id)); ?>'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
		              </tr>
	              <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>    
    </section>
  <!-- End content list1 list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>