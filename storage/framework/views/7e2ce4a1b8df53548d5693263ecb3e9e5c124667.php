<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>患者管理　＞　登録済み兄弟の一覧</h3>

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

    <div class="row">
      <div class="col-md-12 text-right">
        <input type="submit" name="button" value="兄弟姉妹の新規登録" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.patients.brothers.regist', [ $patient->p_id ])); ?>'">
      </div>
    </div>

    <table class="table table-bordered table-striped">
      <tbody>
        <tr>
          <td class="col-title" align="center">カルテNo</td>
          <td class="col-title" align="center">患者名</td>
          <td class="col-title" align="center">患者名よみ</td>
          <td class="col-title" align="center">性別</td>
          <td class="col-title" align="center">生年月日</td>
          <td class="col-title" align="center">関係</td>
          <td class="col-title" align="center">編集</td>
          <td class="col-title" align="center" style="min-width: 47px;">削除</td>
        </tr>
        <?php if( empty($brothers) || count($brothers) == 0 ): ?>
        <tr>
          <td colspan="8" align="center"><?php echo e(trans('common.no_data_correspond')); ?></td>
        </tr>
        <?php else: ?>
          <?php foreach( $brothers as $brother ): ?>
          <tr>
            <td align="right"><?php echo e($brother->p_no); ?></td>
            <td><?php echo e($brother->p_name); ?></td>
            <td><?php echo e($brother->p_name_kana); ?></td>
            <td><?php echo ($brother->p_sex == 1) ? '男' : '女'; ?></td>
            <td><?php echo e(date('Y/m/d', strtotime($brother->p_birthday))); ?></td>
            <td><?php echo e(relationship($patient->p_sex,$brother->p_sex , $brother->brother_relation)); ?></td>
            <td align="center"><input type="button" onclick="location.href='<?php echo e(route('ortho.patients.brothers.edit', [ $brother->brother_id, $patient->p_id ])); ?>'" value="編集" class="btn btn-xs btn-page"/></td>
            <td align="center">
              <!-- Trigger the modal with a button -->
              <input type="button" value="削除" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($brother->brother_id); ?>"/>
              <!-- Modal -->
              <div class="modal fade" id="myModal-<?php echo e($brother->brother_id); ?>" role="dialog">
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
                      <a href="<?php echo e(route('ortho.patients.brothers.delete', [ $brother->brother_id, $patient->p_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
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
        <input type="submit" name="button" onClick="location.href='<?php echo e(route('ortho.patients.index')); ?>'" value="患者一覧に戻る" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>