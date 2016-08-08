<?php $__env->startSection('content'); ?>
    <section id="page">
      <div class="container">
        <div class="row content content--list text-center">
          <h1 class="mar-bottom30" style="font-size:60px;">404</h1>
          <p class="mar-bottom30">COMPONENT NOT FOUND</p>
          <h1>OH MY GOSH! YOU FOUND IT!!!</h1>
          <p>Looks like the page you're trying to visit doesn't exit.</p>
          <p class="mar-bottom30">Please check url and try your luck again.</p>
            <!-- <input onclick="history.back()" value="Take Me Home" type="button" class="btn btn-sm btn-primary"> -->
        </div>
      </div>
    </section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>