<?php $__env->startSection('content'); ?>
<!-- content customer list -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
        <div class="msg-alert-action">
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
          <p>全<?php echo e($count_all); ?>件中、<?php echo e($total_count); ?>件が該当しました。うち、<?php echo e($record_from); ?>～<?php echo e($record_to + count($customers)); ?>件を表示しています。</p>
          <div class="row fl-right mar-bottom">
            <div class="col-md-12">
              <input onclick="location.href='<?php echo e(route('backend.customers.regist')); ?>'" value="顧客の新規登録" type="button" class="btn btn-sm btn-primary"/>
            </div>
          </div>
          <table class="table table-bordered table-striped clearfix">
            <tr>
              <td class="col-title" align="center">学校コード</td>
              <td class="col-title" align="center">学校名</td>
              <td class="col-title" align="center">旧学校名</td>
              <td class="col-title" align="center">詳細</td>
              <td class="col-title" align="center">編集</td>
              <td class="col-title" align="center">削除</td>
            </tr>

            <?php if(count($customers) > 0): ?>
            <?php foreach($customers as $customer): ?>
              <tr>
                <td align="right"><?php echo e($customer->cus_code); ?></td>
                <td><?php echo e($customer->cus_name); ?></td>
                <td><?php echo e($customer->cus_old_name); ?></td>
                
                <td align="center"><input onclick="location.href='<?php echo e(route('backend.students.contact.index', ['stu_d'=>'1'])); ?>'" value="詳細" type="button" class="btn btn-xs btn-primary"></td>
                <td align="center"><input onclick="location.href='<?php echo e(route('backend.customers.detail', $customer->cus_id)); ?>'" value="詳細" type="button" class="btn btn-xs btn-primary"></td>
                <td align="center">
                  <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-<?php echo e($customer->cus_id); ?>">削除</button>
                  <!-- popup -->
                  <div class="modal fade bs-example-modal-sm" id="myModal-<?php echo e($customer->cus_id); ?>" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title"><?php echo e(trans('common.modal_header_delete')); ?></h4>
                        </div>
                        <div class="modal-body">
                          <p><?php echo e(trans('common.modal_content_delete')); ?></p>
                        </div>
                        <div class="modal-footer">
                          <a href="<?php echo e(route('backend.customers.delete', array($customer->cus_id, 'page' => $customers->currentPage()))); ?>" class="btn btn-xs btn-primary"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                          <button type="button" class="btn btn-xs btn-default" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
                        </div>
                      </div>
                      <!-- End Modal content-->
                  </div>
                </div>
                </td>
              </tr>
            <?php endforeach; ?>

            <?php else: ?>
              <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
            <?php endif; ?>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <?php echo (new App\Pagination\SimplePagination($customers))->render(); ?>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input name="searchWhere" id="searchWhere" value="再検索（条件を引き継ぐ）" type="button" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='<?php echo e(route('backend.customers.search', ['cus_code='.@$cus_code, 'cus_name='.@$cus_name, 'cus_old_name='.@$cus_old_name])); ?>'">
            <input name="searchNoWhere" id="searchNoWhere" value="再検索（条件をクリアする）" type="button" class="btn btn-sm btn-primary" onclick="location.href='<?php echo e(route('backend.customers.search')); ?>'">
          </div>
        </div>
      </div>
    </section>
    <!-- End content customer list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.backend', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>