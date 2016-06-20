<?php $__env->startSection('content'); ?>
<section id="login">
  <div class="container">
    <div class="content-login">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <h1>ログイン</h1>
        <!-- <form class="form-horizontal"> -->
        <?php echo Form::open(array('route' => 'backend.login', 'class' => 'form-horizontal')); ?>

          <div class="form-group">
            <label class="col-xs-12 col-md-4 control-label" for="u_login">ログインID</label>
            <div class="col-xs-12 col-md-6">
              <input type="text" class="form-control" id="u_login" name="u_login" value="<?php echo e(old('u_login')); ?>" >
              <div class="help-block with-errors"><ul class="list-unstyled"><li><?php if($errors->first('u_login')): ?> <?php echo $errors->first('u_login'); ?> <?php endif; ?></li></ul></div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-md-4 control-label" for="u_password" >パスワード</label>
            <div class="col-xs-12 col-md-6">
              <input type="password" class="form-control" id="u_password" name="u_password" value="" >
              <div class="help-block with-errors"><ul class="list-unstyled"><li><?php if($errors->first('u_password')): ?> <?php echo $errors->first('u_password'); ?> <?php endif; ?></li></ul></div>
              <?php if(Session::has('error')): ?>
              <div class="help-block with-errors"><ul class="list-unstyled"><li>
                <?php echo e(Session::get('error')); ?>

              </li></ul></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-4"></div>
            <div class="col-xs-12 col-md-6">
              <button type="submit" class="btn btn-blue">ログイン</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>