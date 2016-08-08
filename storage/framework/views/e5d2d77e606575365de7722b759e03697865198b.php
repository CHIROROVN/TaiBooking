<?php $__env->startSection('content'); ?>
    <div class="content-page">
      <h3>ユーザー管理　＞　登録済みユーザーの一覧</h3>

      <div class="msg-alert-action margin-top-15">
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

      <div class="row">
          <div class="col-md-12 text-right">
            <a href="<?php echo e(asset('ortho/users/regist')); ?>" class="btn btn-sm btn-page">ユーザーの新規登録</a>
          </div>
      </div>
      
      <table class="table table-bordered user-list">
        <tbody>
          <tr>
            <td class="col-title col-width-5">名前</td>
            <td class="col-title col-width-5">ログインID</td>
            <td class="col-title col-affiliation">所属</td>
            <td class="col-title">権限</td>
            <td class="col-title col-edit">編集</td>
          </tr>

          <?php if(empty($users) || count($users) < 1): ?>
          <tr>
            <td colspan="6">
              <h3 align="center">該当するデータがありません。</h3>
            </td>
          </tr>
          <?php else: ?>
            <?php foreach($users as $user): ?>
            <tr>
              <td><?php echo e($user->u_name); ?></td>
              <td><?php echo e($user->u_login); ?></td>
              <td>
                <?php foreach($belongs as $belong): ?>
                  <?php if($belong->belong_id == $user->u_belong): ?>
                    <?php echo e($belong->belong_name); ?>

                    <?php break; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </td>
              <td>
                <?php if(!empty($user->u_power1)): ?>
                ・患者管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power2)): ?>
                ・予約管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power3)): ?>
                ・院長予定管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power4)): ?>
                ・放射線録管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power5)): ?>
                ・月1回の予約業務前処理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power6)): ?>
                ・医院情報管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power7)): ?>
                ・放射線照射録管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power8)): ?>
                ・共通マスタ管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power9)): ?>
                ・ユーザー管理<br />
                <?php endif; ?>
                <?php if(!empty($user->u_power10)): ?>
                ・初診業務<br />
                <?php endif; ?>
              </td>
              <td align="center"><a href="<?php echo e(asset('ortho/users/edit/' . $user->id)); ?>" class="btn btn-sm btn-edit">編集</a></td>
            </tr>
            <?php endforeach; ?>
          <?php endif; ?>

        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="col-md-12 text-right">
          <a href="<?php echo e(asset('ortho/users/regist')); ?>" class="btn btn-sm btn-page">ユーザーの新規登録</a>
        </div>
      </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>