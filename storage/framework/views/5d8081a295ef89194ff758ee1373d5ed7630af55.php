<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>共通マスタ管理　＞　登録済み検査の一覧</h3>

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
        <a href="<?php echo e(route('ortho.insurances.regist')); ?>" class="btn btn-sm btn-page">保険診療の新規登録</a>
      </div>
    </div>
    
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr>
          <td align="center" class="col-title">保険診療名</td>
          <td align="center" class="col-title col-edit">編集</td>
          <td colspan="4" align="center" class="col-title col-action">表示順序</td>
        </tr>

        <?php 
          $i = 0;
          $max = count($insurances);
        ?>
        <?php if(empty($insurances) || count($insurances) < 1): ?>
          <tr>
            <td colspan="6">
              <h3 align="center">該当するデータがありません。</h3>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach($insurances as $insurance): ?>
          <?php $i++; ?>
          <tr>
            <td>
              <?php echo e($insurance->insurance_name); ?>

            </td>
            <td align="center">
              <a href="<?php echo e(route('ortho.insurances.edit', [$insurance->insurance_id])); ?>" class="btn btn-default btn-edit">編集</a>
            </td>
            <td align="center">
              <button onclick="location.href='<?php echo e(route('ortho.insurances.orderby.top', ['id' => $insurance->insurance_id])); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">TOP
            </td>
            <td align="center" class="">
              <button onclick="location.href='<?php echo e(route('ortho.insurances.orderby.up', ['id' => $insurance->insurance_id])); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↑</button>
            </td>
            <td align="center">
              <button onclick="location.href='<?php echo e(route('ortho.insurances.orderby.down', ['id' => $insurance->insurance_id])); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↓</button>
            </td>
            <td align="center" class="">
              <button onclick="location.href='<?php echo e(route('ortho.insurances.orderby.last', ['id' => $insurance->insurance_id])); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">LAST</button>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>

      </tbody>
    </table>
    <div class="row margin-bottom" style="display: block; float: right;">
      <div class="col-md-12 text-right">
        <a href="<?php echo e(route('ortho.insurances.regist')); ?>" class="btn btn-sm btn-page">地域の新規登録</a>
      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>