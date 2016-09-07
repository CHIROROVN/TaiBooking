<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container content-page">
    <h3>予約の変更</h3>
    <p>変更してよろしいですか？</p>
    <?php echo Form::open(array('route' => ['ortho.bookings.booking.change.confirm', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">変更前</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name_f); ?> <?php echo e($booking->p_name_g); ?></td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td><?php echo e(formatDateJp($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)　<?php echo e(splitHourMin($booking->booking_start_time)); ?><!-- ～<?php echo e(toTime($booking->booking_start_time, $booking->booking_total_time)); ?> --></td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td><?php echo e($booking->clinic_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td><?php echo e($booking->facility_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td><?php echo e(@$doctors[$booking->doctor_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td><?php echo e(@$hygienists[$booking->hygienist_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td><?php echo e(@$equipments[$booking->equipment_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td><?php if($booking->service_1_kind == 1): ?><?php echo e(@$services[$booking->service_1]); ?><?php elseif($booking->service_1_kind == 2): ?><?php echo e(@$treatment1s[$booking->service_1]); ?><?php endif; ?></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td><?php echo e($booking->inspection_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td><?php echo e($booking->insurance_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">救急</td>
              <td><?php if($booking->emergency_flag == 1): ?> 救急です <?php else: ?> 救急ではない <?php endif; ?></td>
            </tr>
            <tr>
              <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td><?php echo e(@$arrStatus[$booking->booking_status]); ?></td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td><?php echo e(@$doctors[$booking->first_user]); ?></td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td><?php echo e(@dateHourMinSecond($booking->first_date, '/')); ?></td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td><?php echo e(@$doctors[$booking->last_user]); ?></td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td><?php echo e(@dateHourMinSecond($booking->last_date, '/')); ?></td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo e(@$booking->booking_memo); ?></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2" style="color: red;">変更後</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name_f); ?> <?php echo e($booking->p_name_g); ?></td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td><?php echo e(formatDateJp(@$booking_change['booking_date'])); ?> (<?php echo e(DayJp(@$booking_change['booking_date'])); ?>)　<?php echo e(splitHourMin(@$booking_change['booking_start_time'])); ?><!-- ～<?php echo e(toTime($booking->booking_start_time, $booking->booking_total_time)); ?> --></td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td><?php echo e(@$clinics[$booking->clinic_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td><?php echo e($booking->facility_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td><?php echo e(@$doctors[$booking->doctor_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td><?php echo e(@$hygienists[$booking->hygienist_id]); ?></td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td><?php echo e($booking->equipment_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td><?php if(isset($booking->service_1_kind) && $booking->service_1_kind == 1){
                      echo @$services[$booking->service_1];
                    }elseif(isset($booking->service_1_kind) && $booking->service_1_kind == 2){
                      echo @$treatment1s[$booking->service_1];
                    }
                ?></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td><?php echo e($booking->inspection_name); ?></td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td><?php echo e($booking->insurance_name); ?></td>
            </tr>            
            <tr>
              <td class="col-title">救急</td>
              <td><?php if($booking->emergency_flag == 1): ?> 救急です <?php else: ?> 救急ではない <?php endif; ?></td>
            </tr>
            <tr>
            <?php $arrStatus = array('1'=>'通常','2'=>'「TEL待ち」です','3'=>'「リコール」です','4'=>'未作成技工物TEL待ち','5'=>'作成済み技工物キャンセル','6'=>'無断キャンセル') ?>
              <td class="col-title">予約ステータス</td>
              <td><?php echo e(@$arrStatus[$booking->booking_status]); ?></td>
            </tr>
            <tr>
              <td class="col-title">登録者</td>
              <td><?php echo e(@$doctors[$booking->first_user]); ?></td>
            </tr>
            <tr>
              <td class="col-title">登録日時</td>
              <td><?php echo e(@dateHourMinSecond($booking->first_date, '/')); ?></td>
            </tr>
            <tr>
              <td class="col-title">最終更新者</td>
              <td><?php echo e(@$doctors[$booking_change['last_user']]); ?></td>
            </tr>
            <tr>
              <td class="col-title">最終更新日時</td>
              <td><?php echo e(@dateHourMinSecond($booking_change['last_date'], '/')); ?></td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td><?php echo nl2br($booking->booking_memo);?> </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input value="変更する（確認済）" name="btnSave" type="submit" class="btn btn-sm btn-page">
        <input value="キャンセル" onclick="location.href='<?php echo e(route('ortho.bookings.booking_change_date', [$booking->booking_id])); ?>'" name="btnCancel" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
    <?php echo Form::close(); ?>

  </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>