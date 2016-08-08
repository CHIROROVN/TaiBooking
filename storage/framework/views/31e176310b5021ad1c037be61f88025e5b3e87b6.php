<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => 'ortho.patients.regist', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>患者管理　＞　患者の新規登録</h3>
        <div class="table-responsive">
          <table class="table table-bordered">

            <!-- p_no -->
            <tr>
              <td class="col-title"><label for="p_no">カルテNo</label></td>
              <td>
                <input type="text" name="p_no" id="p_no" maxlength="8" class="form-control" value="<?php echo e(old('p_no')); ?>" />
                <span class="error-input"><?php if($errors->first('p_no')): ?> <?php echo $errors->first('p_no'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_dr: user id only doctor -->
            <tr>
              <td class="col-title"><label for="p_dr">担当</label></td>
              <td>
                <select name="p_dr" title="▼選択" id="p_dr" class="form-control">
                  <option data-hidden="true"></option>
                  <?php foreach( $user_doctors as $user_doctor ): ?>
                  <option value="<?php echo e($user_doctor->id); ?>" <?php if(old('p_dr') == $user_doctor->id): ?> selected="" <?php endif; ?> ><?php echo e($user_doctor->u_name); ?></option>
                  <?php endforeach; ?>
                </select>
                <span class="error-input"><?php if($errors->first('p_dr')): ?> <?php echo $errors->first('p_dr'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="p_hos_memo">HOS</label></td>
              <td>
                <!-- p_hos_memo -->
                <div class="mar-bottom">
                  <input type="text" name="p_hos_memo" id="p_hos_memo" class="form-control" value="<?php echo e(old('p_hos_memo')); ?>" />
                  <span class="error-input"><?php if($errors->first('p_hos_memo')): ?> <?php echo $errors->first('p_hos_memo'); ?> <?php endif; ?></span>
                </div>

                <!-- p_hos: clinic name, id -->
                <div>
                  <select  name="p_hos" class="form-control" title="▼選択">
                    <option data-hidden="true"></option>
                    <?php foreach( $clinics as $clinic ): ?>
                    <option value="<?php echo e($clinic->clinic_id); ?>" <?php if(old('p_hos') == $clinic->clinic_id): ?> selected="" <?php endif; ?> ><?php echo e($clinic->clinic_name); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <span class="error-input"><?php if($errors->first('p_hos')): ?> <?php echo $errors->first('p_hos'); ?> <?php endif; ?></span>
                </div>
              </td>
            </tr>

            <!-- p_name -->
            <tr>
              <td class="col-title"><label for="p_name">氏名 <span class="note_required">※</span></label></td>
              <td>
                <input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo e(old('p_name')); ?>" />
                <span class="error-input"><?php if($errors->first('p_name')): ?> ※<?php echo $errors->first('p_name'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_kana">氏名（よみ） <span class="note_required">※</span></label></td>
              <td>
                <input type="text" name="p_name_kana" id="p_name_kana" class="form-control" value="<?php echo e(old('p_name_kana')); ?>" />
                <span class="error-input"><?php if($errors->first('p_name_kana')): ?> ※<?php echo $errors->first('p_name_kana'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_sex -->
            <tr>
              <td class="col-title">性別 <span class="note_required">※</span></td>
              <td>
                <input type="radio" name="p_sex" value="1" <?php if(old('p_sex') == 1): ?> checked="" <?php endif; ?> /> 男　　　
                <input type="radio" name="p_sex" value="2" <?php if(old('p_sex') == 2): ?> checked="" <?php endif; ?> /> 女
                <span class="error-input"><?php if($errors->first('p_sex')): ?> ※<?php echo $errors->first('p_sex'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_birthday -->
            <tr>
              <td class="col-title"><label for="p_birthday">生年月日 <span class="note_required">※</span></label></td>
              <td>
                <input type="text" name="p_birthday" id="p_birthday" class="form-control" value="<?php echo e(old('p_birthday')); ?>" placeholder="YYYY/mm/dd" />
                <span class="error-input"><?php if($errors->first('p_sex')): ?> ※<?php echo $errors->first('p_sex'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_family_dr -->
            <tr>
              <td class="col-title"><label for="p_family_dr">かかりつけ</label></td>
              <td>
                <input type="text" name="p_family_dr" id="p_family_dr" class="form-control" value="<?php echo e(old('p_family_dr')); ?>" />
                <span class="error-input"><?php if($errors->first('p_family_dr')): ?> ※<?php echo $errors->first('p_family_dr'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_introduce -->
            <tr>
              <td class="col-title"><label for="p_introduce">紹介先</label></td>
              <td>
                <input type="text" name="p_introduce" id="p_introduce" class="form-control" value="<?php echo e(old('p_introduce')); ?>" />
                <span class="error-input"><?php if($errors->first('p_introduce')): ?> ※<?php echo $errors->first('p_introduce'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_start -->
            <tr>
              <td class="col-title"><label for="p_start">治療開始</label></td>
              <td>
                <input type="text" name="p_start" id="p_start" class="form-control" value="<?php echo e(old('p_start')); ?>" />
                <span class="error-input"><?php if($errors->first('p_start')): ?> ※<?php echo $errors->first('p_start'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_start2 -->
            <tr>
              <td class="col-title"><label for="p_start2">2期開始</label></td>
              <td>
                <input type="text" name="p_start2" id="p_start2" class="form-control" value="<?php echo e(old('p_start2')); ?>" />
                <span class="error-input"><?php if($errors->first('p_start2')): ?> ※<?php echo $errors->first('p_start2'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_place: clicnic id,name -->
            <tr>
              <td class="col-title"><label for="p_place">撮影場所</label></td>
              <td>
                <select  name="p_place" id="p_place" title="▼選択" class="form-control">
                  <option data-hidden="true"></option>
                  <?php foreach( $clinics as $clinic ): ?>
                    <option value="<?php echo e($clinic->clinic_id); ?>" <?php if(old('p_place') == $clinic->clinic_id): ?> selected="" <?php endif; ?> ><?php echo e($clinic->clinic_name); ?></option>
                  <?php endforeach; ?>
                </select>
                <span class="error-input"><?php if($errors->first('p_place')): ?> ※<?php echo $errors->first('p_place'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_xray -->
            <tr>
              <td class="col-title"><label for="p_xray">xray</label></td>
              <td>
                <input type="text" name="p_xray" id="p_xray" class="form-control" value="<?php echo e(old('p_xray')); ?>" />
                <span class="error-input"><?php if($errors->first('p_xray')): ?> ※<?php echo $errors->first('p_xray'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_clinic_memo -->
            <tr>
              <td class="col-title"><label for="p_clinic_memo">医院関連メモ</label></td>
              <td>
                <input type="text" name="p_clinic_memo" id="p_clinic_memo" class="form-control" value="<?php echo e(old('p_clinic_memo')); ?>" />
                <span class="error-input"><?php if($errors->first('p_clinic_memo')): ?> ※<?php echo $errors->first('p_clinic_memo'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_personal_memo -->
            <tr>
              <td class="col-title"><label for="p_personal_memo">個人情報メモ</label></td>
              <td>
                <input type="text" name="p_personal_memo" id="p_personal_memo" class="form-control" value="<?php echo e(old('p_personal_memo')); ?>" />
                <span class="error-input"><?php if($errors->first('p_personal_memo')): ?> ※<?php echo $errors->first('p_personal_memo'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_used -->
            <tr>
              <td class="col-title"><label for="p_used">使用装置</label></td>
              <td>
                <input type="text" name="p_used" id="p_used" class="form-control" value="<?php echo e(old('p_used')); ?>" />
                <span class="error-input"><?php if($errors->first('p_used')): ?> ※<?php echo $errors->first('p_used'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_payment -->
            <tr>
              <td class="col-title"><label for="p_payment">入金状況</label></td>
              <td>
                <input type="text" name="p_payment" id="p_payment" class="form-control" value="<?php echo e(old('p_payment')); ?>" />
                <span class="error-input"><?php if($errors->first('p_payment')): ?> ※<?php echo $errors->first('p_payment'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_amount -->
            <tr>
              <td class="col-title"><label for="p_amount">契約金</label></td>
              <td>
                <input type="text" name="p_amount" id="p_amount" class="form-control" value="<?php echo e(old('p_amount')); ?>" />
                <span class="error-input"><?php if($errors->first('p_amount')): ?> ※<?php echo $errors->first('p_amount'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="p_zip">住所</label></td>
              <td>
                <!-- p_zip -->
                <div class="mar-bottom">
                  <input type="text" name="p_zip" id="p_zip" class="form-control" placeholder="郵便番号を入力して下さい。　例)100-0000" value="<?php echo e(old('p_zip')); ?>" />
                  <span class="error-input"><?php if($errors->first('p_zip')): ?> ※<?php echo $errors->first('p_zip'); ?> <?php endif; ?></span>
                </div>
                <!-- p_pref -->
                <div class="mar-bottom">
                  <select name="p_pref" title="▼都道府県" class="form-control">
                    <option data-hidden="true"></option>
                    <?php foreach( $prefs as $key => $value ): ?>
                    <option value="<?php echo e($key); ?>" <?php if(old('p_pref') == $key): ?> selected="" <?php endif; ?> ><?php echo e($value); ?></option>
                    <?php endforeach; ?>
                  </select>
                  <span class="error-input"><?php if($errors->first('p_pref')): ?> ※<?php echo $errors->first('p_pref'); ?> <?php endif; ?></span>
                </div>
                <!-- p_address1 -->
                <div class="mar-bottom">
                  <input type="text" name="p_address1" id="p_address1" class="form-control" placeholder="例）岡山市北区1-2-3" value="<?php echo e(old('p_address1')); ?>" />
                  <span class="error-input"><?php if($errors->first('p_address1')): ?> ※<?php echo $errors->first('p_address1'); ?> <?php endif; ?></span>
                </div>
                <!-- p_address_2 -->
                <div class="mar-bottom">
                  <input type="text" name="p_address_2" id="p_address_2" class="form-control" placeholder="マンション名などをご記入ください" value="<?php echo e(old('p_address_2')); ?>" />
                  <span class="error-input"><?php if($errors->first('p_address_2')): ?> ※<?php echo $errors->first('p_address_2'); ?> <?php endif; ?></span>
                </div>
              </td>
            </tr>

            <!-- p_tel -->
            <tr>
              <td class="col-title"><label for="p_tel">TEL <span class="note_required">※</span></label></td>
              <td>
                <input class="form-control" name="p_tel" value="<?php echo e(old('p_tel')); ?>" type="text" id="p_tel" />
                <span class="error-input"><?php if($errors->first('p_tel')): ?> ※<?php echo $errors->first('p_tel'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_fax -->
            <tr>
              <td class="col-title"><label for="p_fax">FAX</label></td>
              <td>
                <input class="form-control" name="p_fax" value="<?php echo e(old('p_fax')); ?>" type="text" id="p_fax" />
                <span class="error-input"><?php if($errors->first('p_fax')): ?> ※<?php echo $errors->first('p_fax'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_mobile -->
            <tr>
              <td class="col-title"><label for="p_mobile">携帯電話</label></td>
              <td>
                <input class="form-control" name="p_mobile" value="<?php echo e(old('p_mobile')); ?>" type="text" id="p_mobile" />
                <span class="error-input"><?php if($errors->first('p_mobile')): ?> ※<?php echo $errors->first('p_mobile'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_mobile_owner -->
            <tr>
              <td class="col-title"><label for="p_mobile_owner">携帯電話所有者</label></td>
              <td>
                <select name="p_mobile_owner" title="▼所有者" class="form-control" id="p_mobile_owner">
                  <option data-hidden="true"></option>
                  <option value="1" <?php if(old('p_mobile_owner') == 1): ?> selected="" <?php endif; ?> >本人</option>
                  <option value="2" <?php if(old('p_mobile_owner') == 2): ?> selected="" <?php endif; ?> >父</option>
                  <option value="3" <?php if(old('p_mobile_owner') == 3): ?> selected="" <?php endif; ?> >母</option>
                  <option value="4" <?php if(old('p_mobile_owner') == 4): ?> selected="" <?php endif; ?> >祖父</option>
                  <option value="5" <?php if(old('p_mobile_owner') == 5): ?> selected="" <?php endif; ?> >祖母</option>
                </select>
                <span class="error-input"><?php if($errors->first('p_mobile_owner')): ?> ※<?php echo $errors->first('p_mobile_owner'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_email -->
            <tr>
              <td class="col-title"><label for="p_email">e-mail</label></td>
              <td>
                <input class="form-control" placeholder="例）example@domain.co.jp" name="p_email" value="<?php echo e(old('p_email')); ?>" type="text" id="p_email" />
                <span class="error-input"><?php if($errors->first('p_email')): ?> ※<?php echo $errors->first('p_email'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_company -->
            <tr>
              <td class="col-title"><label for="p_company">学校・勤務先</label></td>
              <td>
                <input class="form-control" placeholder="学校・勤務先をご記入ください" name="p_company" value="<?php echo e(old('p_company')); ?>" type="text" id="p_company" />
                <span class="error-input"><?php if($errors->first('p_company')): ?> ※<?php echo $errors->first('p_company'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_parent_name -->
            <tr>
              <td class="col-title"><label for="p_parent_name">保護者氏名</label></td>
              <td>
                <input class="form-control" name="p_parent_name" value="<?php echo e(old('p_parent_name')); ?>" type="text" id="p_parent_name" />
                <span class="error-input"><?php if($errors->first('p_parent_name')): ?> ※<?php echo $errors->first('p_parent_name'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_parent_company -->
            <tr>
              <td class="col-title"><label for="p_parent_company">保護者勤務先</label></td>
              <td>
                <input class="form-control" name="p_parent_company" value="<?php echo e(old('p_parent_company')); ?>" type="text" id="p_parent_company" />
                <span class="error-input"><?php if($errors->first('p_parent_company')): ?> ※<?php echo $errors->first('p_parent_company'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_parent_tel -->
            <tr>
              <td class="col-title"><label for="p_parent_tel">保護者連絡先</label></td>
              <td>
                <input class="form-control" name="p_parent_tel" value="<?php echo e(old('p_parent_tel')); ?>" type="text" id="p_parent_tel" />
                <span class="error-input"><?php if($errors->first('p_parent_tel')): ?> ※<?php echo $errors->first('p_parent_tel'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_parent_kind -->
            <tr>
              <td class="col-title"><label for="p_parent_kind">保護者連絡先種別</label></td>
              <td>
                <select name="p_parent_kind" class="form-control" title="▼所有者" id="p_parent_kind">
                  <option data-hidden="true"></option>
                  <option value="1" <?php if(old('p_parent_kind') == 1): ?> selected="" <?php endif; ?> >自宅</option>
                  <option value="2" <?php if(old('p_parent_kind') == 2): ?> selected="" <?php endif; ?> >父</option>
                  <option value="3" <?php if(old('p_parent_kind') == 3): ?> selected="" <?php endif; ?> >母</option>
                  <option value="4" <?php if(old('p_parent_kind') == 4): ?> selected="" <?php endif; ?> >祖父</option>
                  <option value="5" <?php if(old('p_parent_kind') == 5): ?> selected="" <?php endif; ?> >祖母</option>
                </select>
                <span class="error-input"><?php if($errors->first('p_parent_kind')): ?> ※<?php echo $errors->first('p_parent_kind'); ?> <?php endif; ?></span>
              </td>
            </tr>

            <!-- p_memo -->
            <tr>
              <td class="col-title"><label for="p_memo">備考</label></td>
              <td>
                <textarea class="form-control" rows="2" name="p_memo" id="p_memo"><?php echo e(old('p_memo')); ?></textarea>
              </td>
            </tr>
          </table>
        </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="" id="" value="保存する" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.patients.index')); ?>'" value="登録済み患者一覧に戻る" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
<?php echo Form::close(); ?>


<script>
  $(document).ready(function(){
    $('#p_birthday').mask('0000/00/00');
  });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>