<?php $__env->startSection('content'); ?>
	<!-- content change pass -->
    <section id="page">
      <div class="container">      
        <div class="row content content--changepass">        
          <div class="col-md-12">
        	<div class="msg-alert">
  		        <?php if($message = Session::get('success')): ?>
  					<div class="alert alert-success  alert-dismissible fade in" role="alert">
  					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					    <span aria-hidden="true">&times;</span>
  					  </button>
  					  <ul><strong><li> <?php echo e($message); ?></li></strong></ul>
  					</div>
  				<?php elseif($message = Session::get('danger')): ?>
  					<div class="alert alert-danger alert-dismissible fade in" role="alert">
  					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  					    <span aria-hidden="true">&times;</span>
  					  </button>
  					  <ul><strong><li> <?php echo e($message); ?></li></strong></ul>
  					</div>
  				<?php endif; ?>
  			</div>
        <?php echo Form::open( ['id' => 'frmChangePasswd', 'class' => 'form-horizontal','method' => 'post', 'route' => 'backend.users.change_passwd', 'enctype'=>'multipart/form-data'] ); ?> 
          <label class="col-md-3 control-label" for="currpasswd">現在のパスワード <span class="note_required">※</span></label>
            <div class="form-group">
              <div class="col-md-6">
                <input type="password" name="currpasswd" class="form-control" id="currpasswd" value="<?php echo e(old('currpasswd')); ?>">
                <div class="help-block with-errors">
                <?php if($errors->first('currpasswd')): ?>
                    <div class="help-block with-errors">※ <?php echo $errors->first('currpasswd'); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <label class="col-md-3 control-label" for="newpasswd">新しいパスワード <span class="note_required">※</span></label>
            <div class="form-group">                
              <div class="col-md-6">
                <input type="password" name="newpasswd" class="form-control" id="newpasswd">
                <div class="help-block with-errors">
                  <?php if($errors->first('newpasswd')): ?>
                    <div class="help-block with-errors">※ <?php echo $errors->first('newpasswd'); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <label class="col-md-3 control-label" for="confnewpasswd">新しいパスワード（確認）</label>
            <div class="form-group" >                
              <div class="col-md-6">
                <input type="password" name="confnewpasswd" class="form-control" id="confnewpasswd">
                <div class="help-block with-errors">
                  <?php if($errors->first('confnewpasswd')): ?>
                    <div class="help-block with-errors">※ <?php echo $errors->first('confnewpasswd'); ?></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-offset-3 col-md-6">
                <button type="submit" class="btn btn-primary">&nbsp;&nbsp;更新&nbsp;&nbsp;</button>
              </div>
            </div>
          <?php echo Form::close(); ?>

        </div>
      </div>
    </div>
  </section>
  <!-- End content change pass -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>