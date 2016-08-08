<?php $__env->startSection('content'); ?>

    <section id="page">
      <div class="container content-page">
        <h3>医院情報管理　＞　登録済み医院の一覧</h3>

        <div class="row">
          <div class="col-md-12 table-responsive">
            <table class="table table-bordered">
              <tr>
                <td class="col-title"><label for="keyword">絞り込み</label></td>
                <td>
                  <?php echo Form::open(array('url' => 'ortho/clinics', 'method' => 'post')); ?>

                  <input type="text" name="keyword" value="<?php echo e($keyword); ?>" id="keyword" class="form-control mar-right" style="display:inline"/>
                  <input type="submit" name="search" value="表示" class="btn btn-sm btn-page">
                  <?php echo Form::close(); ?>

                </td>
              </tr>
            </table>
          </div>
        </div>

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
            <a href="<?php echo e(route('ortho.clinics.regist')); ?>" class="btn btn-sm btn-page">医院の新規登録</a>
          </div>
        </div>
        
        <table class="table table-bordered table-striped ">
          <tbody>
            <tr>
              <td align="center" class="col-title"align="center">医院名</td>
              <td align="center" class="col-title">連絡先</td>
              <td align="center" class="col-title">処置</td>
              <td align="center" class="col-title">X-ray</td>
              <td align="center" class="col-title">SP</td>
              <td align="center" class="col-title">TBI</td>
              <td align="center" class="col-title">出張</td>
              <td align="center" class="col-title" style="min-width: 75px;">設備管理</td>
              <td align="center" class="col-title" style="min-width: 90px;">業務枠管理</td>
              <td align="center" class="col-title" style="min-width: 120px;">予約雛形管理</td>
              <td align="center" class="col-title" style="min-width: 60px;">編集</td>
            </tr>
            <?php if(empty($clinics) || count($clinics) < 1): ?>
            <tr>
              <td colspan="11" align="center"><?php echo e(trans('common.no_data_correspond')); ?></td>
            </tr>
            <?php else: ?>
              <?php foreach($clinics as $clinic): ?>
              <tr>
                <td><?php echo e($clinic->clinic_name); ?></td>
                <td>〒<?php echo e($clinic->clinic_zip3); ?>-<?php echo e($clinic->clinic_zip4); ?>　<?php echo e($clinic->clinic_address1); ?>　　<?php echo e($clinic->clinic_address2); ?><br />
                    院長：<?php echo e($clinic->clinic_ownername); ?>　<br />
                    TEL：<span class="tel"><?php echo e($clinic->clinic_tel); ?></span>.<span class="tel"><?php echo e($clinic->clinic_tel_ip); ?></span>　　FAX：<span class="tel"><?php echo e($clinic->clinic_fax); ?></span> <br />
                    E-mail：<?php echo e($clinic->clinic_email); ?></td>
                <td align="center">
                  <?php if($clinic->clinic_status1 == 1): ?>
                    ○
                  <?php else: ?>
                    ×
                  <?php endif; ?>
                </td>
                <td align="center">
                  <?php if($clinic->clinic_status2 == 1): ?>
                    ○
                  <?php else: ?>
                    ×
                  <?php endif; ?>
                </td>
                <td align="center">
                  <?php if($clinic->clinic_status3 == 1): ?>
                    ○
                  <?php else: ?>
                    ×
                  <?php endif; ?>
                </td>
                <td align="center">
                  <?php if($clinic->clinic_status4 == 1): ?>
                    ○
                  <?php else: ?>
                    ×
                  <?php endif; ?>
                </td>
                <td align="center">
                  <?php if($clinic->clinic_status5 == 1): ?>
                    ○
                  <?php else: ?>
                    ×
                  <?php endif; ?>
                </td>
                <td><input type="button" onClick="location.href='<?php echo e(route('ortho.facilities.index', $clinic->clinic_id)); ?>'" value="「設備」管理" class="btn btn-xs btn-page"/></td>
                <td><input type="button" onClick="location.href='<?php echo e(route('ortho.clinics.services.index',$clinic->clinic_id)); ?>'" value="「業務枠」管理" class="btn btn-xs btn-page"/></td>
                <td><input type="button" onClick="location.href='<?php echo e(route('ortho.clinics.booking.templates.index', $clinic->clinic_id)); ?>'" value="「予約雛形」管理" class="btn btn-xs btn-page"/></td>
                <td>
                  <a href="<?php echo e(route('ortho.clinics.edit', [ $clinic->clinic_id ])); ?>" class="btn btn-xs btn-page">編集</a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <div class="row margin-bottom" style="display: block; float: right; width: 100%;">
          <div class="col-md-12 text-center" style="width: 100%;">
            <?php echo $clinics->render(new App\Pagination\SimplePagination($clinics)); ?>

          </div>
        </div>
    </div>    
    </section>

    <script>
      $(document).ready(function($){
        $('.tel').mask('000-000-0000');
      });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>