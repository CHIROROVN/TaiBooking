<?php $__env->startSection('content'); ?>
 <!-- Content service regist -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　業務名の新規登録</h3>
    <?php echo Form::open( ['id' => 'frmServiceRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => 'ortho.services.regist', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

		<div class="msg-alert-action">
              <?php if($message = Session::get('success')): ?>
              <div class="alert alert-success  alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> <?php echo e($message); ?></li></strong></ul>
              </div>
            <?php elseif($message = Session::get('danger')): ?>
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> <?php echo e($message); ?></li></strong></ul>
              </div>
            <?php endif; ?>
		</div>

	<table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="service_name">業務名 <span class="note_required">※</span></label></td>
            <td>
              <input class="form-control" type="text" name="service_name" id="service_name" value="<?php echo e(old('service_name')); ?>" />
              <?php if($errors->first('service_name')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_name'); ?></span>
              <?php endif; ?>

            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="button" name="button" value="登録済み業務名一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.services.index')); ?>'">
        </div>
      </div>
      <?php echo Form::close(); ?>

    </div>
  <!--End content service regist -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>