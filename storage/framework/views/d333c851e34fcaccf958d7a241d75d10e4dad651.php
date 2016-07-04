<?php $__env->startSection('content'); ?>
	<!-- Content treatment 1 list -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　登録済み治療内容の一覧</h3>
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

      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.treatments.treatment1.regist')); ?>'">
        </div>
      </div>
      <table class="table table-bordered table-striped treatment2-list">
        <tbody>
          <tr>
              <td align="center" class="col-title">治療内容</td>
              <td align="center" class="col-title">時間</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
            <?php if(!count($treatment1s)): ?>
				<tr>
		          <td colspan="4" align="center"><?php echo e(trans('common.no_data_correspond')); ?></td>
				</tr>
            <?php else: ?>
            <?php 
	            $i = 0;
	            $count = count($treatment1s);
	          ?>
            	<?php foreach($treatment1s as $treatment1): ?>
            	<?php $i++; ?>
	            	<tr>
		              <td><?php echo e($treatment1->treatment_name); ?></td>
		              <td><?php echo e($treatment1->treatment_time); ?>分</td>
		              <td align="center">
		              	<a href="<?php echo e(route('ortho.treatments.treatment1.edit', $treatment1->treatment_id)); ?>" class="btn btn-sm btn-edit">編集</a>
		              </td>
		              <td align="center">
	                    <button onclick="location.href='<?php echo e(url('ortho/treatment1/orderby-top?id=' . $treatment1->treatment_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">TOP
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='<?php echo e(url('ortho/treatment1/orderby-up?id=' . $treatment1->treatment_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↑</button>
	                  </td>
	                  <td align="center">
	                    <button onclick="location.href='<?php echo e(url('ortho/treatment1/orderby-down?id=' . $treatment1->treatment_id)); ?>'" class="<?php if($i == $count): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↓</button>
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='<?php echo e(url('ortho/treatment1/orderby-last?id=' . $treatment1->treatment_id)); ?>'" class="<?php if($i == $count): ?> <?php echo e('hidden'); ?> <?php endif; ?>">LAST</button>
	                  </td>
		            </tr>
	            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.treatments.treatment1.regist')); ?>'">
        </div>
      </div>
    </div>
  <!-- End content treatment 1 list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>