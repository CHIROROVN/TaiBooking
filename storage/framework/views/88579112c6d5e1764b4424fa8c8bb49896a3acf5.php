<?php $__env->startSection('content'); ?> 
    <!-- Content forum detail -->
    <section id="page">
      <div class="container">
      <?php echo Form::open(array('route' => ['ortho.forums.forum_detail', $comment->forum_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8')); ?>

        <div class="row content-page">
          <h3>伝言板　＞　話題の参照</h3>
          <div class="text-right">
            <input type="button" onclick="location.href='<?php echo e(route('ortho.forums.forum_reply', $comment->forum_id)); ?>'" value="この話題に返信する" class="btn btn-sm btn-page" type="button">
          </div>
          <table class="table table-bordered treatment2-list">
            <tr>
              <td class="col-title"  rowspan="3">
                <?php if(empty($comment->forum_user_id)): ?>不明 <?php else: ?> <?php echo e($comment->u_name_display); ?> <?php endif; ?><br />
                <?php echo e(formatDateTime($comment->forum_time, '/')); ?><br />

                <?php if(!empty(Auth::user()->u_power12)): ?>
                  <?php if(Auth::user()->u_power12 == 2): ?>
                  <a class="text-orange" href="<?php echo e(route('ortho.forums.forum_edit',$comment->forum_id)); ?>">編集</a> / <a class="text-orange" href="<?php echo e(route('ortho.forums.forum_delete_cnf',$comment->forum_id)); ?>">削除</a>
                  <?php elseif(Auth::user()->u_power12 == 1): ?>
                    <?php if(checkOwn(Auth::user()->id, $comment->forum_id)): ?>
                      <a class="text-orange" href="<?php echo e(route('ortho.forums.forum_edit',$comment->forum_id)); ?>">編集</a> / <a class="text-orange" href="<?php echo e(route('ortho.forums.forum_delete_cnf',$comment->forum_id)); ?>">削除</a>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              </td>
              <td><?php echo e($comment->forum_title); ?></td>
            </tr>
            <tr>
              <td><?php echo nl2br($comment->forum_contents) ?></td>
            </tr>
            <tr>
              <td>
                <?php if(!empty($comment->forum_file_path)): ?>
                  <a href="<?php echo $comment->forum_file_path;?>" target="_blank" class="text-orange">ファイル名</a>
                <?php else: ?>
                  <a href="javascript::void(0);" class="text-orange">ファイル名</a>
                <?php endif; ?>
              </td>
            </tr>
          </table>
          <div class="text-right">
            <input type="button" onclick="location.href='<?php echo e(route('ortho.forums.forum_reply', $comment->forum_id)); ?>'" value="この話題に返信する" class="btn btn-sm btn-page" type="button">
          </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onclick="location.href='<?php echo e(route('ortho.forums.forum_detail2',$comment->forum_id)); ?>'" value="このトピックのコメント一覧" class="btn btn-sm btn-page">
          </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onclick="location.href='<?php echo e(route('ortho.forums.forum_list')); ?>'" value="登録済み話題一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
      <?php echo Form::close(); ?>

    </section>
  <!-- End content forum detail -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>