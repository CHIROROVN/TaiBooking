<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　検索結果の一覧</h3>

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

    <table class="table table-bordered table-striped">
      <tbody>
        <tr>
          <td class="col-title" align="center">撮影日</td>
          <td class="col-title" align="center">カルテNo</td>
          <td class="col-title" align="center">患者名</td>
          <td class="col-title" align="center">患者名ふりがな</td>
          <td class="col-title" align="center">性別</td>
          <td class="col-title" align="center">生年月日</td>
          <td class="col-title" align="center">放射線照射録の表示</td>
        </tr>
        <?php if( empty($xrays) || count($xrays) == 0): ?>
          <tr>
            <td colspan="7">
              <h3 align="center" style="padding-bottom: 0;"><?php echo e(trans('common.no_data_correspond')); ?></h3>
            </td>
          </tr>
        <?php else: ?>
          <?php foreach( $xrays as $xray ): ?>
          <tr>
            <td><?php echo e(date('Y/m/d', strtotime($xray->xray_date))); ?></td>
            <td><?php echo e($xray->p_no); ?></td>
            <td><?php echo e($xray->p_name); ?></td>
            <td><?php echo e($xray->p_name_kana); ?></td>
            <td><?php echo ($xray->p_sex == 1) ? '男' : '女'; ?></td>
            <td><?php echo e(date('Y/m/d', strtotime($xray->p_birthday))); ?></td>
            <td align="center">
              <input onclick="location.href='<?php echo e(route('ortho.xrays.detail', [$xray->xray_id])); ?>'" value="放射線照射録の表示" type="button" class="btn btn-xs btn-page"/>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='<?php echo e(route('ortho.xrays.search', [
          's_p_name'                => $s_p_name,
          's_p_id'                  => $s_p_id,
          's_p_birthday_year_from'  => $s_p_birthday_year_from,
          's_p_birthday_month_from' => $s_p_birthday_month_from,
          's_p_birthday_day_from'   => $s_p_birthday_day_from,
          's_p_birthday_year_to'    => $s_p_birthday_year_to,
          's_p_birthday_month_to'   => $s_p_birthday_month_to,
          's_p_birthday_day_to'     => $s_p_birthday_day_to,
          's_p_sex_men'             => $s_p_sex_men,
          's_p_sex_women'           => $s_p_sex_women,
          's_xray_date_year_from'   => $s_xray_date_year_from,
          's_xray_date_month_from'  => $s_xray_date_month_from,
          's_xray_date_day_from'    => $s_xray_date_day_from,
          's_xray_date_year_to'     => $s_xray_date_year_to,
          's_xray_date_month_to'    => $s_xray_date_month_to,
          's_xray_date_day_to'      => $s_xray_date_day_to,
        ])); ?>'" value="条件を変えて再検索" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>