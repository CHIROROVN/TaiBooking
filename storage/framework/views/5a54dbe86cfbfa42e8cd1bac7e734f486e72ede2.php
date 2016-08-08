<?php $__env->startSection('content'); ?>
    <?php echo Form::open(array('url' => 'ortho/areas/regist', 'method' => 'post')); ?>

      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>共通マスタ管理　＞　地域の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="area_name">地域名 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="text" name="area_name" id="area_name " class="form-control" value="<?php echo e(old('area_name')); ?>" />
                      <span class="error-input"><?php if($errors->first('area_name')): ?> ※<?php echo $errors->first('area_name'); ?> <?php endif; ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title">所属医院</td>
                    <td>
                      <!-- <div class="checkbox">
                        <label><input type="checkbox" name="clinic[]" value="-1" />たい矯正歯科</label>
                      </div> -->
                      <?php if(!empty($clinics) && count($clinics) > 0): ?>
                        <?php $listClinics = $clinics; ?>
                        <?php foreach($listClinics as $key => $value): ?>
                          <?php if( $value->clinic_name == 'たい矯正歯科' ): ?>
                          <div class="checkbox">
                            <label><input type="checkbox" name="clinic[]" value="<?php echo e($value->clinic_id); ?>" /><?php echo e($value->clinic_name); ?></label>
                          </div>
                          <?php unset($listClinics[$key]); ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach($listClinics as $clinic): ?>
                        <div class="checkbox">
                          <label><input type="checkbox" name="clinic[]" value="<?php echo e($clinic->clinic_id); ?>" /><?php echo e($clinic->clinic_name); ?></label>
                        </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="<?php echo e(asset('ortho/areas')); ?>" class="btn btn-sm btn-page mar-right">登録済み地域一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>