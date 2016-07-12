<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>患者管理　＞　登録済み患者情報の詳細</h3>
      <div class="text-right">
        <input onclick="location.href='<?php echo e(route('ortho.patients.edit', [$patient->p_id])); ?>'" value="編集する" class="btn btn-sm btn-page btn-mar-right" type="button">
        <input value="削除する" class="btn btn-sm btn-page" type="button" data-toggle="modal" data-target="#myModal">
        <!-- Trigger the modal with a button -->
        <!-- <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button> -->
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
                <a href="<?php echo e(route('ortho.patients.delete', [$patient->p_id])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
              </div>
            </div>
          </div>
        </div>
        <!-- end modal -->
      </div>
      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">カルテNo</td>
          <td><?php echo e($patient->p_no); ?></td>
        </tr>
        <tr>
          <td class="col-title">担当</td>
          <td><?php echo e($patient->u_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">HOS</td>
          <td>
            <div class="mar-bottom"><?php echo e($patient->p_hos_memo); ?></div>
            <div><?php echo e($patient->clinic_name); ?></div>
          </td>
        </tr>
        <tr>
          <td class="col-title">氏名</td>
          <td><?php echo e($patient->p_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">氏名（よみ）</td>
          <td><?php echo e($patient->p_name_kana); ?></td>
        </tr>
        <tr>
          <td class="col-title">性別</td>
          <td><?php echo ($patient->p_sex == 1) ? '男' : '女'; ?></td>
        </tr>
        <tr>
          <td class="col-title">生年月日</td>
          <td><?php echo e(date('Y/m/d', strtotime($patient->p_birthday))); ?></td>
        </tr>
        <tr>
          <td class="col-title">かかりつけ</td>
          <td><?php echo e($patient->p_family_dr); ?></td>
        </tr>
        <tr>
          <td class="col-title">紹介先</td>
          <td><?php echo e($patient->p_introduce); ?></td>
        </tr>
        <tr>
          <td class="col-title">治療開始</td>
          <td><?php echo e($patient->p_start); ?></td>
        </tr>
        <tr>
          <td class="col-title">2期開始</td>
          <td><?php echo e($patient->p_start2); ?></td>
        </tr>
        <tr>
          <td class="col-title">撮影場所</td>
          <td><?php echo e($patient->clinic_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">xray</td>
          <td><?php echo e($patient->p_xray); ?></td>
        </tr>
        <tr>
          <td class="col-title">医院関連メモ</td>
          <td><?php echo e($patient->p_clinic_memo); ?></td>
        </tr>
        <tr>
          <td class="col-title">個人情報メモ</td>
          <td><?php echo e($patient->p_personal_memo); ?></td>
        </tr>
        <tr>
          <td class="col-title">使用装置</td>
          <td><?php echo e($patient->p_used); ?></td>
        </tr>
        <tr>
          <td class="col-title">入金状況</td>
          <td><?php echo e($patient->p_payment); ?></td>
        </tr>
        <tr>
          <td class="col-title">契約金</td>
          <td><?php echo e($patient->p_amount); ?></td>
        </tr>
        <tr>
          <td class="col-title">住所</td>
          <td>
            <div class="mar-bottom">
              <?php echo e($patient->p_zip); ?>

            </div>
            <div class="mar-bottom">
              <?php echo (isset($prefs[$patient->p_pref])) ? $prefs[$patient->p_pref] : ''; ?>
            </div>
            <div class="mar-bottom">
              <?php echo e($patient->p_address1); ?>

            </div>
            <div class="mar-bottom">
              <?php echo e($patient->p_address_2); ?>

            </div>
          </td>
        </tr>
        <tr>
          <td class="col-title">TEL</td>
          <td><?php echo e($patient->p_tel); ?></td>
        </tr>
        <tr>
          <td class="col-title">FAX</td>
          <td><?php echo e($patient->p_fax); ?></td>
        </tr>
        <tr>
          <td class="col-title">携帯電話</td>
          <td><?php echo e($patient->p_mobile); ?></td>
        </tr>
        <tr>
          <td class="col-title">携帯電話所有者</td>
          <td>
          <?php if( $patient->p_mobile_owner == 1 ): ?>
          本人
          <?php elseif( $patient->p_mobile_owner == 2 ): ?>
          父
          <?php elseif( $patient->p_mobile_owner == 3 ): ?>
          母
          <?php elseif( $patient->p_mobile_owner == 4 ): ?>
          祖父
          <?php elseif( $patient->p_mobile_owner == 5 ): ?>
          祖母
          <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">e-mail</td>
          <td><?php echo e($patient->p_email); ?></td>
        </tr>
        <tr>
          <td class="col-title">学校・勤務先</td>
          <td><?php echo e($patient->p_company); ?></td>
        </tr>
        <tr>
          <td class="col-title">保護者氏名</td>
          <td><?php echo e($patient->p_parent_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">保護者勤務先</td>
          <td><?php echo e($patient->p_parent_company); ?></td>
        </tr>
        <tr>
          <td class="col-title">保護者連絡先</td>
          <td><?php echo e($patient->p_parent_tel); ?></td>
        </tr>
        <tr>
          <td class="col-title">保護者連絡先種別</td>
          <td>
          <?php if( $patient->p_parent_kind == 1 ): ?>
          本人
          <?php elseif( $patient->p_parent_kind == 2 ): ?>
          父
          <?php elseif( $patient->p_parent_kind == 3 ): ?>
          母
          <?php elseif( $patient->p_parent_kind == 4 ): ?>
          祖父
          <?php elseif( $patient->p_parent_kind == 5 ): ?>
          祖母
          <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td><?php echo e($patient->p_memo); ?></td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <?php if( isset($interviews[$patient->p_id]) ): ?>
        <input type="button" onClick="location.href='<?php echo e(route('ortho.interviews.detail', [$patient->p_id])); ?>'" value="問診票の参照" class="btn btn-sm btn-page mar-right">
        <?php else: ?>
        <input type="button" onClick="location.href='<?php echo e(route('ortho.interviews.detail', [$patient->p_id])); ?>'" value="問診票の参照" class="btn btn-sm btn-page mar-right" disabled="">
        <?php endif; ?>
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.patient_booking_list', $patient->p_id)); ?>'" value="予約表示" class="btn btn-sm btn-page mar-right">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.visit.list', [$patient->p_id])); ?>'" value="来院履歴" class="btn btn-sm btn-page mar-right">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.communications.index', [ $patient->p_id ])); ?>'" value="コミュニケーションノート" class="btn btn-sm btn-page mar-right">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.brothers.index', [ $patient->p_id ])); ?>'" value="兄弟設定" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.index')); ?>'" value="一覧に戻る" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>