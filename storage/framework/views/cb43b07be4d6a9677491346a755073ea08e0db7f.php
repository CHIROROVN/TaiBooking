<?php $__env->startSection('content'); ?>
	<!-- content clinic facility list -->
    <section id="page">
      <div class="container content-page">
        <h3>ユーザー管理　＞　登録済みの一覧</h3>
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
              <input type="submit" name="button" value="設備の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.facilities.regist',$clinic_id)); ?>'">
            </div>
        </div>
        <table class="table table-bordered table-striped treatment2-list">
          <tbody>
            <tr>
              <td align="center" class="col-title">設備名</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
            <?php 
	            $i = 0;
	            $max = count($facilities);
	          ?>
            <?php if(!count($facilities)): ?>
            	<tr><td colspan="3" style="text-align: center;">該当するデータがありません。</td></tr>
            <?php else: ?>
    			<?php foreach($facilities as $facility): ?>
    			<?php $i++; ?>
	            	<tr>
		              <td><?php echo e($facility->facility_name); ?></td>
		              <td align="center"><a href="<?php echo e(route('ortho.facilities.edit', [$clinic_id, $facility->facility_id])); ?>" class="btn btn-sm btn-edit">編集</a></td>
	                  <td align="center">
	                    <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic_id.'/facility/orderby-top?id=' . $facility->facility_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">TOP
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic_id.'/facility/orderby-up?id=' . $facility->facility_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↑</button>
	                  </td>
	                  <td align="center">
	                    <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic_id.'/facility/orderby-down?id=' . $facility->facility_id)); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↓</button>
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic_id.'/facility/orderby-last?id=' . $facility->facility_id)); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">LAST</button>
	                  </td>
		            </tr>
		        <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <div class="row margin-bottom" style="display: block; float: right;">
          <div class="col-md-12 text-right">
            <input type="submit" name="button" value="地域の新規登録" class="btn btn-sm btn-page" onclick="location.href='belong_regist.html'">
          </div>
        </div>
      </div>    
    </section>
  <!-- End content clinic facility list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>