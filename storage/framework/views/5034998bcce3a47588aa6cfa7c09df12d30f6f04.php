<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>初診業務　＞　初診者の一覧</h3>

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
        <input type="submit" name="button" value="問診票の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.interviews.set')); ?>'">
      </div>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td class="col-title" align="center" style="width:80%;">患者名</td>
          <td class="col-title" align="center">問診票の入力</td>
          <td class="col-title" align="center">取消</td>
        </tr>
        <?php if( empty($bookings) || count($bookings) == 0 ): ?>
        <tr>
          <td colspan="3">
            <h3 align="center" style="padding-bottom: 0;"><?php echo e(trans('common.no_data_correspond')); ?></h3>
          </td>
        </tr>
        <?php else: ?>
          <?php foreach( $bookings as $booking ): ?>
          <tr>
            <td><?php echo e($booking->p_name); ?></td>
            <td align="center"><a href="<?php echo e(route('ortho.interviews.regist', [ 'patient_id' => $booking->patient_id, 'booking_id' => $booking->booking_id, 'clinic_id' => $booking->clinic_id ])); ?>" class="btn btn-xs btn-page" target="_blank">問診票の入力</a></td>
            <td align="center">
              <!-- <a href="interview_cancel.html" class="btn btn-xs btn-page" target="_blank">取消</a> -->
              <!-- delete -->
              <input type="button" value="取消" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($booking->booking_id); ?>"/>
                <!-- Modal -->
                <div class="modal fade" id="myModal-<?php echo e($booking->booking_id); ?>" role="dialog">
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
                        <a href="<?php echo e(route('ortho.interviews.delete', [ $booking->booking_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                        <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- end Modal -->
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-right">
        <input type="submit" name="button" value="問診票の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.interviews.set')); ?>'">
      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>