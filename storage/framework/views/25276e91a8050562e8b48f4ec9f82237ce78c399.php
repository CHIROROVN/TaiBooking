<?php $__env->startSection('content'); ?>
    
  <!-- content forum list -->
    <section id="page">
      <div class="container content-page">
        <h3>伝言板　＞　話題の一覧</h3>
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
            <input value="新しい話題を作る" class="btn btn-sm btn-page" type="button" onclick="location.href='<?php echo e(route('ortho.forums.forum_regist')); ?>'">
          </div>
        </div>
        <table class="table table-bordered table-striped treatment2-list">
          <tbody>
                <tr>
                  <td class="col-title" align="center" style="width:50px"></td>
                  <td class="col-title" align="center" style="width:30%;">話題</td>
                  <td class="col-title" align="center">返答数</td>
                  <td class="col-title" align="center">読数</td>
                  <td class="col-title" align="center">名前</td>
                  <td class="col-title" align="center">最終更新日</td>
                </tr>
            <?php if(!count($forums)): ?>
                <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
            <?php else: ?>
            <?php foreach($forums as $forum): ?>
            <tr>
              <td align="center">
                <?php if(reader($forum->forum_id)): ?>
                <img src="<?php echo e(asset('public/backend/ortho')); ?>/common/image/mail_close.gif" height="14" width="13">
                <?php else: ?>
                <img src="<?php echo e(asset('public/backend/ortho')); ?>/common/image/mail_open.gif" height="14" width="13">
                <?php endif; ?>
              </td>
              <td><a href="<?php echo e(route('ortho.forums.forum_detail', $forum->forum_id)); ?>"><?php echo e($forum->forum_title); ?></a></td>
              <td align="center"><?php echo e(countReply($forum->forum_id)); ?></td>
              <td align="center"><?php if(!empty($forum->forum_view)): ?><?php echo e($forum->forum_view); ?><?php else: ?> 0 <?php endif; ?></td>
              <td align="center"><?php if(empty($forum->forum_user_id)): ?>不明 <?php else: ?> <?php echo e($forum->u_name_display); ?> <?php endif; ?></td>
              <td align="center"><?php echo e(formatDateTime($forum->forum_time, '/')); ?></td>
            </tr>
            <tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <?php echo $forums->appends([])->render(new App\Pagination\SimplePagination($forums)); ?>

          </div>
        </div>
       
        <div class="row margin-bottom mar-top20">
          <div class="col-md-12 text-center">
            <input onclick="location.href='<?php echo e(route('ortho.forums.forum_search')); ?>'" value="キーワード検索" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>    
    </section>
  <!-- End content forum list -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>