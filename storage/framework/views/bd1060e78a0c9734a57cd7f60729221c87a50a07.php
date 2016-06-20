<?php $__env->startSection('content'); ?>
<!-- content customer search -->
    <section id="page">
      <div class="container">
      <?php echo Form::open( ['id' => 'frmCustomerSearch', 'class' => 'form-horizontal','method' => 'post', 'route' => 'backend.customers.search', 'enctype'=>'multipart/form-data']); ?>

        <div class="row content">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="cus_code">学校コード</label></td>
                <td>
                  <input name="cus_code" id="cus_code" type="text" class="form-control form-control--small" value="<?php echo e(@$cus_code); ?>">
                </td>
                <td class="col-title"><label for="cus_name">学校名</label></td>
                <td>
                  <input name="cus_name" id="cus_name" type="text" class="form-control form-control--small" value="<?php echo e(@$cus_name); ?>">
                </td>
                <td class="col-title"><label for="cus_old_name">性別</label></td>
                 <td><input name="cus_old_name" id="cus_old_name" type="text" class="form-control form-control--small" value="<?php echo e(@$cus_old_name); ?>"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input type="submit" value="検索開始（AND検索）" type="button" class="btn btn-sm btn-primary form-control--mar-right">
            <input name="btnReset" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary">
          </div>
        </div>
        <?php echo Form::close(); ?>

      </div>
    </section>
    <!-- End content customer search -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>