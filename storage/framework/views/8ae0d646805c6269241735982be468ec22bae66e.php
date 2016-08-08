<?php $__env->startSection('content'); ?>
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>患者管理　＞　来院履歴の一覧</h3>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-title">患者名</td>
              <td><span class="mar-right"><?php echo e($patient->p_name); ?></span> <input onclick="location.href='<?php echo e(route('ortho.patients.detail', [ $patient->p_id ])); ?>'" value="詳細表示" type="button"class="btn btn-xs btn-page"></td>
            </tr>
            <tr>
              <td class="col-title">担当</td>
              <td><?php echo e($patient->u_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">医院関連メモ</td>
              <td><?php echo e($patient->p_clinic_memo); ?></td>
            </tr>
            <tr>
              <td class="col-title">個人情報メモ</td>
              <td><?php echo e($patient->p_personal_memo); ?></td>
            </tr>
          </tbody>
        </table>

        <hr noshade>

        <table class="table table-bordered">
          <tr class="col-title">
            <td>来院日時</td>
            <td>医院</td>
            <td>Dr</td>
            <td>衛生士</td>
            <td>実施業務-1</td>
            <td>実施業務-2</td>
          </tr>
          <?php foreach( $results as $result ): ?>
          <tr>
            <td><?php echo e(formatDateJp($result->result_date)); ?>　<?php echo e(splitHourMin($result->result_start_time)); ?>～<?php echo e(toTime($result->result_start_time, $result->result_total_time)); ?></td>
            <td><?php echo e($result->clinic_name); ?></td>
            <td><?php echo (isset($doctors[$result->doctor_id])) ? $doctors[$result->doctor_id]->u_name : ''; ?></td>
            <td><?php echo (isset($hygienists[$result->hygienist_id])) ? $hygienists[$result->hygienist_id]->u_name : ''; ?></td>
            <td>
              <?php if( $result->service_1_kind == 1 ): ?>
              <?php echo e(@$services[$result->service_1]); ?>

              <?php elseif( $result->service_1_kind == 2 ): ?>
              <?php echo e(@$treatment1s[$result->service_1]); ?>

              <?php endif; ?>
            </td>
            <td>
              <?php if( $result->service_2_kind == 1 ): ?>
              <?php echo e(@$services[$result->service_2]); ?>

              <?php elseif( $result->service_2_kind == 2 ): ?>
              <?php echo e(@$treatment1s[$result->service_2]); ?>

              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        </table>

      </div>
      </div>
      <div class="margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>