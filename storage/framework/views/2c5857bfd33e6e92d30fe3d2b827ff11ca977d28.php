<?php $__env->startSection('content'); ?>
	<!-- content clinic booking template list -->
    <section id="page">
      <div class="container content-page">
        <h3>医院情報管理　＞　<?php echo e($clinic->clinic_name); ?>　＞　予約雛形の一覧</h3>

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
            <input onclick="location.href='<?php echo e(route('ortho.clinics.booking.templates.regist', [ $clinic->clinic_id ])); ?>'" value="雛形の新規作成" type="button" class="btn btn-sm btn-page">
          </div>
        </div>

        <table class="table table-bordered table-striped treatment2-list">
          <tbody>
            <tr>
              <td align="center" class="col-title">雛形名</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
            <?php 
              $i = 0;
              $max = count($mbts);
            ?>
            <?php if(!count($mbts)): ?>
              <tr><td colspan="3" style="text-align: center;">該当するデータがありません。</td></tr>
            <?php else: ?>
              <?php foreach($mbts as $mbt): ?>
              <?php $i++; ?>
                <tr>
                  <td><?php echo e($mbt->mbt_name); ?></td>
                  <td align="center"><a href="<?php echo e(route('ortho.clinics.booking.templates.edit', [$clinic->clinic_id, $mbt->mbt_id])); ?>" class="btn btn-sm btn-edit">編集</a></td>
                  <td align="center">
                      <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic->clinic_id.'/booking/templates/orderby-top?id='.$mbt->mbt_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">TOP
                    </td>
                    <td align="center" class="">
                      <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic->clinic_id.'/booking/templates/orderby-up?id='.$mbt->mbt_id)); ?>'" class="<?php if($i < 2): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↑</button>
                    </td>
                    <td align="center">
                      <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic->clinic_id.'/booking/templates/orderby-down?id='.$mbt->mbt_id)); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">↓</button>
                    </td>
                    <td align="center" class="">
                      <button onclick="location.href='<?php echo e(url('ortho/clinics/'.$clinic->clinic_id.'/booking/templates/orderby-last?id='.$mbt->mbt_id)); ?>'" class="<?php if($i == $max): ?> <?php echo e('hidden'); ?> <?php endif; ?>">LAST</button>
                    </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
            <!-- <tr>
              <td>青江水曜日</td>
              <td align="center"><a href="clinic_booking-template_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"></td>
              <td align="center" class=""></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>青江土曜日</td>
              <td align="center"><a href="clinic_booking-template_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr> -->
          </tbody>
        </table>

        <div class="row margin-bottom" style="display: block; float: right;">
          <div class="col-md-12 text-center">
            <input onclick="location.href='<?php echo e(route('ortho.clinics.index')); ?>'" value="医院一覧に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
  <!-- End content clinic booking template list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>