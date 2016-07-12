<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3 class="margin-bottom">予約管理　＞　予約の一覧</h3>

    <div>
      <div class="form-inline">
          <?php echo Form::open(array('route' => 'ortho.bookeds.history', 'method' => 'get', 'enctype'=>'multipart/form-data')); ?>

          <select title="医院" name="s_clinic_id" class="form-control">
            <option value="">医院</option>
            <?php foreach( $clinics as $clinic): ?>
            <option value="<?php echo e($clinic->clinic_id); ?>" <?php if($s_clinic_id == $clinic->clinic_id): ?> selected="" <?php endif; ?>><?php echo e($clinic->clinic_name); ?></option>
            <?php endforeach; ?>
          </select>
          　
          <select name="s_booking_date" id="s_booking_date" class="form-control" style="margin-left: -19px;">
            <option value="">----日</option>
            <?php foreach( $dates as $date ): ?>
            <option value="<?php echo e($date); ?>" <?php if($s_booking_date == $date): ?> selected="" <?php endif; ?>><?php echo e(formatDate($date, '/')); ?>(<?php echo e(DayJp($date)); ?>日)</option>
            <?php endforeach; ?>
          </select>

          <input name="" value="検索" type="submit" class="btn btn-sm btn-page">
          </form>
      </div>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td  class="col-title" align="center">時間帯</td>
          <td  class="col-title"align="center">患者名</td>
          <td class="col-title" align="center">本日の内容</td>
          <td class="col-title" align="center">編集</td>
          <td class="col-title" align="center">次回予約</td>
        </tr>
        <?php if( !count($bookeds) ): ?>
        <tr><td colspan="5" align="center"><?php echo e(trans('common.no_data_correspond')); ?></td></tr>
        <?php else: ?>
          <?php foreach( $bookeds as $booked ): ?>
          <tr>
            <td><?php echo e(splitHourMin($booked->booking_start_time)); ?>～<?php echo e(toTime($booked->booking_start_time, $booked->booking_total_time)); ?></td>
            <td><?php echo e($booked->p_no); ?>　<?php echo e($booked->p_name); ?>（<?php echo e($booked->p_name_kana); ?>）</td>
            <td>
              <?php if( $booked->service_1_kind == 1 ): ?>
              <?php echo e(@$services[$booked->service_1]); ?>

              <?php elseif( $booked->service_1_kind == 2 ): ?>
              <?php echo e(@$treatment1s[$booked->service_1]); ?>

              <?php endif; ?>
              <?php if( !empty($booked->service_2) ): ?>
              ,
              <?php if( $booked->service_2_kind == 1 ): ?>
              <?php echo e(@$services[$booked->service_2]); ?>

              <?php elseif( $booked->service_2_kind == 2 ): ?>
              <?php echo e(@$treatment1s[$booked->service_2]); ?>

              <?php endif; ?>
              <?php endif; ?>
            </td>
            <td align="center">
              <!-- regist -->
              <?php if( isset($results[$booked->patient_id]) ): ?>
              <input onclick="location.href='<?php echo e(route('ortho.bookeds.history.regist')); ?>'" value="登録" type="button" class="btn btn-xs btn-page" disabled="">
              <?php else: ?>
              <input onclick="location.href='<?php echo e(route('ortho.bookeds.history.regist')); ?>'" value="登録" type="button" class="btn btn-xs btn-page">
              <?php endif; ?>
              <!-- edit -->
              <?php if( isset($results[$booked->patient_id]) ): ?>
              <input onclick="location.href='<?php echo e(route('ortho.bookeds.history.edit', [ $booked->booking_id ])); ?>'" value="編集" type="button" class="btn btn-xs btn-page">
              <?php else: ?>
              <input onclick="location.href='<?php echo e(route('ortho.bookeds.history.edit', [ $booked->booking_id ])); ?>'" value="編集" type="button" class="btn btn-xs btn-page" disabled="">
              <?php endif; ?>
            </td>
            <td align="center">
              <?php if( $booked->booking_date > $currentDay ): ?>
              <?php echo e(formatDate($booked->booking_date)); ?> <?php echo e(splitHourMin($booked->booking_start_time)); ?>～<?php echo e(toTime($booked->booking_start_time, $booked->booking_total_time)); ?>

              <?php else: ?>
              <input onclick="location.href='<?php echo e(route('ortho.bookings.booking_search')); ?>'" value="次回予約" type="button" class="btn btn-xs btn-page">
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <?php echo $bookeds->render(new App\Pagination\SimplePagination($bookeds)); ?>

      </div>
    </div>
  </div>    
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>