<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => 'ortho.interviews.set', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>初診業務　＞　初診者の登録</h3>

      <div class="table-responsive">
        <table class="table table-bordered">
          <!-- p_name -->
          <tr>
            <td class="col-title"><label for="p_name">初診者の名前</label></td>
            <td>
              <input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo e(old('p_name')); ?>" />
              <span class="error-input"><?php if($errors->first('p_name')): ?> <?php echo $errors->first('p_name'); ?> <?php endif; ?></span>
            </td>
          </tr>

          <!-- p_name_kana -->
          <tr>
            <td class="col-title"><label for="p_name_kana">初診者よみ</label></td>
            <td>
              <input type="text" name="p_name_kana" id="p_name_kana" class="form-control" value="<?php echo e(old('p_name_kana')); ?>" />
              <span class="error-input"><?php if($errors->first('p_name_kana')): ?> <?php echo $errors->first('p_name_kana'); ?> <?php endif; ?></span>
            </td>
          </tr>

          <!-- p_sex -->
          <tr>
            <td class="col-title">性別</td>
            <td>
              <div class="row">
                <div class="col-xs-4 col-sm-2 col-md-1">
                  <input type="radio" name="p_sex" value="1" <?php if(old('p_sex') == 1): ?> checked="" <?php endif; ?> /> 男
                </div>
                <div class="col-xs-4 col-sm-2 col-md-1">
                  <input type="radio" name="p_sex" value="2" <?php if(old('p_sex') == 2): ?> checked="" <?php endif; ?> /> 女
                </div>
              </div>
              <span class="error-input"><?php if($errors->first('p_sex')): ?> <?php echo $errors->first('p_sex'); ?> <?php endif; ?></span>
            </td>
          </tr>

          <!-- p_tel -->
          <tr>
            <td class="col-title"><label for="p_tel">電話番号</label></td>
            <td>
              <input type="text" name="p_tel" id="p_tel" class="form-control" value="<?php echo e(old('p_tel')); ?>" />
              <span class="error-input"><?php if($errors->first('p_tel')): ?> <?php echo $errors->first('p_tel'); ?> <?php endif; ?></span>
            </td>
          </tr>
          <tr>
        </table>
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="" id="button" value="登録する" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='<?php echo e(route('ortho.interviews.index')); ?>'" value="初診者一覧に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>