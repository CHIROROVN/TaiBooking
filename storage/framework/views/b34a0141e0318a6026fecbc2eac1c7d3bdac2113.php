<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => ['ortho.insurances.edit', $insurance->insurance_id], 'enctype'=>'multipart/form-data')); ?>

<div class="content-page">
  <h3>ユーザー管理　＞　登録済み保険診療の編集</h3>
  <table class="table table-bordered">
    <tbody>
      <tr>
        <td class="col-title"><label for="insurance_name">保険診療名 <span class="note_required">※</span></label></td>
        <td>
          <?php if( old('insurance_name') ): ?>
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="<?php echo e(old('insurance_name')); ?>" />
          <?php elseif( $insurance->insurance_name ): ?>
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="<?php echo e($insurance->insurance_name); ?>" />
          <?php else: ?>
          <input class="form-control" type="text" name="insurance_name" id="insurance_name" value="" />
          <?php endif; ?>
          
          <span class="error-input"><?php if($errors->first('insurance_name')): ?> ※<?php echo $errors->first('insurance_name'); ?> <?php endif; ?></span>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="row margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
      <!-- Trigger the modal with a button -->
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
              <a href="<?php echo e(route('ortho.insurances.delete', [$insurance->insurance_id])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
              <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
            </div>
          </div>
        </div>
      </div>
      <!-- end modal -->
    </div>
  </div>
  <div class="row">
    <div class="text-center">
      <input type="submit" name="button" value="登録済み保険診療一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.insurances.index')); ?>'">
    </div>
  </div>
</div>
<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>