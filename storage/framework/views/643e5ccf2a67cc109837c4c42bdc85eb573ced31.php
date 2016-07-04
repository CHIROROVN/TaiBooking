<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　患者の一覧　＞　放射線照射録の表示</h3>

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
          <td class="col-title">名前</td>
          <td><?php echo e($xray->p_no); ?>　<?php echo e($xray->p_name); ?>（<?php echo e($xray->p_name_kana); ?>）</td>
          <td class="col-title">担当</td>
          <td>
            <?php foreach( $users as $user ): ?>
              <?php if( $user->id == $xray->p_dr ): ?>
              <?php echo e($user->u_name); ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">生年月日</td>
          <td><?php echo e(date('Y', strtotime($patient->p_birthday))); ?>年<?php echo e(date('m', strtotime($patient->p_birthday))); ?>月<?php echo e(date('d', strtotime($patient->p_birthday))); ?>日</td>
          <td class="col-title">性別</td>
          <td><?php echo ($xray->p_sex == 1) ? '男' : '女'; ?></td>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼レントゲン
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='<?php echo e(route('ortho.xrays.regist', [ 'patient_id' => $xray->p_id ])); ?>'" value="レントゲン新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <!-- xray -->
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">種類</td>
          <td align="center">撮影場所</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        <?php if( empty($patient_xrays) || count($patient_xrays) == 0 ): ?>
        <tr>
          <td colspan="9">
            <h3 align="center" style="padding-bottom: 0;"><?php echo e(trans('common.no_data_correspond')); ?></h3>
          </td>
        </tr>
        <?php else: ?>
          <?php foreach( $patient_xrays as $patient_xray ): ?>
          <tr>
            <td><?php echo e(date('Y/m/d', strtotime(@$patient_xray->xray_date))); ?></td>
            <td>
              <?php if( !empty($patient_xray->xray_cat_1) ): ?>
              A_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_2) ): ?>
              A_stage F<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_3) ): ?>
              B_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_4) ): ?>
              B_stage F<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_5) ): ?>
              C_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_6) ): ?>
              D_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_7) ): ?>
              G_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_8) ): ?>
              5G_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_9) ): ?>
              10G_stage<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_10) ): ?>
              Ope前<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_11) ): ?>
              Ope後<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_12) ): ?>
              経過<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_13) ): ?>
              デンタル<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_14) ): ?>
              オクルーザル<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_15) ): ?>
              矯正終了<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_cat_16) ): ?>
              その他<br>
              <?php endif; ?>
            </td>
            <td>
              <?php if( !empty($patient_xray->xray_kind_1) ): ?>
              パノラマ<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_2) ): ?>
              セファロ側<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_3) ): ?>
              セファロ正<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_4) ): ?>
              オクルーザル右<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_5) ): ?>
              オクルーザル左<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_6) ): ?>
              デンタル<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_7) ): ?>
              顔写真<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_8) ): ?>
              手根骨<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_kind_9) ): ?>
              その他<br>
              <?php endif; ?>
            </td>
            <td><?php echo e($patient_xray->clinic_name); ?></td>
            <td><?php echo e($patient_xray->p_name); ?></td>
            <td>
              <?php if( !empty($patient_xray->xray_memo_1) ): ?>
              CD-R<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_2) ): ?>
              Dr.S<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_3) ): ?>
              蓋裂<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_4) ): ?>
              過剰歯<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_5) ): ?>
              2回撮影<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_6) ): ?>
              再治療<br>
              <?php endif; ?>
              <?php if( !empty($patient_xray->xray_memo_7) ): ?>
              転院<br>
              <?php endif; ?>
            </td>
            <td><?php echo e($patient_xray->xray_memo); ?></td>
            <td align="center">
              <input onclick="location.href='<?php echo e(route('ortho.xrays.edit', [ $patient_xray->xray_id, 'patient_id' => $patient->p_id ])); ?>'" value="編集" type="button" class="btn  btn-xs btn-page">
            </td>
            <td align="center">
              <!-- Trigger the modal with a button -->
              <input type="button" value="削除" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($patient_xray->xray_id); ?>"/>
              <!-- Modal -->
              <div class="modal fade" id="myModal-<?php echo e($patient_xray->xray_id); ?>" role="dialog">
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
                      <a href="<?php echo e(route('ortho.xrays.delete', [ $patient_xray->xray_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
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

    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼3D-CT
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='<?php echo e(route('ortho.xrays.x3dct.regist', [ 'patient_id' => $xray->p_id ])); ?>'" value="3D-CT新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <!-- 3dct -->
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">モード</td>
          <td align="center">撮影条件</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        <?php //echo '<pre>';print_r($patient_3dcts);echo '</pre>'; ?>
        <?php if( !count($patient_3dcts) ): ?>
        <tr>
          <td colspan="9">
            <h3 align="center" style="padding-bottom: 0;"><?php echo e(trans('common.no_data_correspond')); ?></h3>
          </td>
        </tr>
        <?php else: ?>
          <?php foreach( $patient_3dcts as $patient_3dct ): ?>
          <tr>
            <td>
              <?php if( !empty($patient_3dct->ct_date) ): ?>
                <?php echo e(date('Y/m/d', strtotime(@$patient_3dct->ct_date))); ?>

              <?php endif; ?>
            </td>
            <td>
              <?php if( !empty($patient_3dct->ct_cat_1) ): ?>
              1回目<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_2) ): ?>
              2回目<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_3) ): ?>
              3回目<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_4) ): ?>
              Ope前<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_5) ): ?>
              Ope後<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_6) ): ?>
              インプラント<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_cat_7) ): ?>
              その他<br>
              <?php endif; ?>
            </td>
            <td>
              <?php if( !empty($patient_3dct->ct_mode_1) ): ?>
              I<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_mode_2) ): ?>
              P<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_mode_3) ): ?>
              F<br>
              <?php endif; ?>
            </td>
            <td>
              <?php if( !empty($patient_3dct->ct_condition_1) ): ?>
              100kv 10mA<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_condition_2) ): ?>
              100kv 15mA<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_condition_3) ): ?>
              120kv 5mA<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_condition_4) ): ?>
              120kv 10mA<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_condition_5) ): ?>
              120kv 15mA<br>
              <?php endif; ?>
            </td>
            <td><?php echo e($patient_3dct->p_name); ?></td>
            <td>
              <?php if( !empty($patient_3dct->ct_memo_1) ): ?>
              CD-R<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_2) ): ?>
              Dr.S<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_3) ): ?>
              口蓋裂<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_4) ): ?>
              過剰歯<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_5) ): ?>
              2回撮影<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_6) ): ?>
              再治療<br>
              <?php endif; ?>
              <?php if( !empty($patient_3dct->ct_memo_7) ): ?>
              転院<br>
              <?php endif; ?>
            </td>
            <td><?php echo e($patient_3dct->ct_memo); ?></td>
            <td align="center">
              <input onclick="location.href='<?php echo e(route('ortho.xrays.x3dct.edit', [ $patient_3dct->ct_id, 'patient_id' => $patient->p_id ])); ?>'" value="編集" type="button" class="btn  btn-xs btn-page">
            </td>
            <td align="center">
              <!-- Trigger the modal with a button -->
              <input type="button" value="削除" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($patient_3dct->ct_id); ?>"/>
              <!-- Modal -->
              <div class="modal fade" id="myModal-<?php echo e($patient_3dct->ct_id); ?>" role="dialog">
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
                      <a href="<?php echo e(route('ortho.xrays.x3dct.delete', [ $patient_3dct->ct_id, 'patient_id' => $patient->p_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
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
      <div class="col-md-12 text-center">
        <input onclick="location.href='<?php echo e(route('ortho.xrays.index')); ?>'" value="患者一覧に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>