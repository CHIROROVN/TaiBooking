<?php $__env->startSection('content'); ?>
  <?php echo Form::open(array('url' => 'ortho/users/regist', 'method' => 'post')); ?>

    <div class="content-page">
      <h3>ユーザー管理　＞　ユーザーの新規登録</h3>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title">医院 <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="clinic_id" id="clinic_id" value="<?php echo e(old('clinic_id')); ?>" />
              <span class="error-input"><?php if($errors->first('clinic_id')): ?> ※<?php echo $errors->first('clinic_id'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">氏名 <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name" id="u_name" value="<?php echo e(old('u_name')); ?>" />
              <span class="error-input"><?php if($errors->first('u_name')): ?> ※<?php echo $errors->first('u_name'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">氏名よみ <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name_yomi" id="u_name_yomi" value="<?php echo e(old('u_name_yomi')); ?>" />
              <span class="error-input"><?php if($errors->first('u_name_yomi')): ?> ※<?php echo $errors->first('u_name_yomi'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">（表示用）氏名 <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name_display" id="u_name_display" value="<?php echo e(old('u_name_display')); ?>" />
              <span class="error-input"><?php if($errors->first('u_name_display')): ?> ※<?php echo $errors->first('u_name_display'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">ログインID <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_login" id="u_login" value="<?php echo e(old('u_login')); ?>" />
              <span class="error-input"><?php if($errors->first('u_login')): ?> ※<?php echo $errors->first('u_login'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">パスワード <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="password" name="password" id="password" />
              <span class="error-input"><?php if($errors->first('password')): ?> ※<?php echo $errors->first('password'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
            <td class="col-title">所属</td>
            <td>
              <?php $i = 0; ?>
              <?php if(!empty($belongs) && count($belongs) > 0): ?>
                <?php foreach($belongs as $belong): ?>
                  <?php $i++; ?>
                  <div class="radio">
                    <?php if(!empty(old('u_belong'))): ?>
                      <label><input type="radio" <?php if(old('u_belong') == $belong->belong_id): ?> <?php echo e('checked'); ?> <?php endif; ?> name="u_belong" value="<?php echo e($belong->belong_id); ?>"><?php echo e($belong->belong_name); ?></label>
                    <?php else: ?>
                      <label><input type="radio" <?php if($i == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> name="u_belong" value="<?php echo e($belong->belong_id); ?>"><?php echo e($belong->belong_name); ?></label>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td class="col-title">権限</td>
            <td>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power1" <?php if(old('u_power1') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">患者管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power2" <?php if(old('u_power2') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">予約管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power3" <?php if(old('u_power3') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">院長予定管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power4" <?php if(old('u_power4') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">放射線録管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power5" <?php if(old('u_power5') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">月1回の予約業務前処理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power6" <?php if(old('u_power6') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">医院情報管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power7" <?php if(old('u_power7') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">放射線照射録管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power8" <?php if(old('u_power8') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">共通マスタ管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power9" <?php if(old('u_power9') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">ユーザー管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power10" <?php if(old('u_power10') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">初診業務</label>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">検索対象</td>
            <td>
              <div class="checkbox">
                <label><input type="checkbox" name="u_human_flg" <?php if(old('u_human_flg') == 1): ?> <?php echo e('checked'); ?> <?php endif; ?> value="1">含めない（人ではないユーザーである）</label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page">
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="text-center">
          <a href="<?php echo e(asset('ortho/users')); ?>" class="btn btn-sm btn-page">登録済みユーザー一覧に戻る</a>
        </div>
      </div>
    </div>
  <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>