<?php $__env->startSection('content'); ?>
<!-- Content service edit -->
    <div class="content-page">
          <div class="msg-alert-action">
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
      <h3>ユーザー管理　＞　登録済み業務名の編集</h3>
      <?php echo Form::open( ['id' => 'frmServiceEdit', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.services.edit', $service->service_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="service_name">業務名 <span class="note_required">※</span></label></label></td>
            <td>
              <input class="form-control" type="text" name="service_name" id="service_name" value="<?php if(old('service_name')): ?> <?php echo e(old('service_name')); ?><?php else: ?><?php echo e($service->service_name); ?><?php endif; ?>" />
              <?php if($errors->first('service_name')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_name'); ?></span>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="button" value="保存する" class="btn btn-sm btn-page mar-right">
              <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><?php echo e(trans('common.modal_header_delete')); ?></h4>
                    </div>
                    <div class="modal-body">
                      <p><?php echo e(trans('common.modal_content_delete')); ?></p>
                    </div>
                    <div class="modal-footer">
                      <a href="<?php echo e(route('ortho.services.delete', $service->service_id)); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Modal -->
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="button" name="button" value="登録済み業務名一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.services.index')); ?>'">
        </div>
      </div>
      <?php echo Form::close(); ?>

    </div>
  <!-- End content service edit -->
  <?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>