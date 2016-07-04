<?php $__env->startSection('content'); ?>

<?php echo Form::open(array('route' => ['ortho.bookings.booking.edit', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　登録済み予約の編集</h3>
      <table class="table table-bordered">

        <tr>
          <td class="col-title">患者名</td>
          <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
          <td>
            <?php echo e(date('Y', strtotime($booking->booking_date))); ?>年<?php echo e(date('m', strtotime($booking->booking_date))); ?>月<?php echo e(date('d', strtotime($booking->booking_date))); ?>日（日）　
            <?php echo e($booking->booking_start_time); ?>:00～<?php echo e($booking->booking_start_time); ?>:<?php echo e($booking->booking_total_time); ?>

            </td>
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
          <td>
            <?php foreach( $doctors as $doctor ): ?>
              <?php if( $doctor->id == $booking->doctor_id ): ?>
              <?php echo e($doctor->u_name); ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">衛生士</td>
          <td>
            <?php foreach( $hys as $hy ): ?>
              <?php if( $hy->id == $booking->hygienist_id ): ?>
              <?php echo e($hy->u_name); ?>

              <?php endif; ?>
            <?php endforeach; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">装置</td>
          <td><?php echo e($booking->equipment_name); ?></td>
        </tr>
        <tr>
          <td class="col-title">処置内容-1</td>
          <td>
            <?php if( !empty($booking->service_1) && $booking->service_1_kind == 1 ): ?>
              <!-- clinic service -->
              <?php foreach( $clinic_services as $clinic_service ): ?>
                <?php if( $booking->service_1 == $clinic_service->clinic_service_id ): ?>
                <?php echo e($clinic_service->service_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php elseif( !empty($booking->service_1) && ($booking->service_1_kind == 2 || $booking->service_1_kind == 3) ): ?>
              <!-- treatment -->
              <?php foreach( $treatment1s as $treatment1 ): ?>
                <?php if( $booking->service_1 == $treatment1->treatment_id ): ?>
                <?php echo e($treatment1->treatment_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            <?php if( !empty($booking->service_2) && $booking->service_2_kind == 1 ): ?>
              <!-- clinic service -->
              <?php foreach( $clinic_services as $clinic_service ): ?>
                <?php if( $booking->service_2 == $clinic_service->clinic_service_id ): ?>
                <?php echo e($clinic_service->service_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php elseif( !empty($booking->service_2) && ($booking->service_2_kind == 2 || $booking->service_2_kind == 3) ): ?>
              <!-- treatment -->
              <?php foreach( $treatment1s as $treatment1 ): ?>
                <?php if( $booking->service_2 == $treatment1->treatment_id ): ?>
                <?php echo e($treatment1->treatment_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            <?php endif; ?>
          </td>
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
          <td><?php echo ($booking->emergency_flag == 1) ? '救急です' : 'ノーマル'; ?></td>
        </tr>

        <!-- booking_status -->
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <div class="radio">
              <label><input name="booking_status" value="1" type="radio" <?php if($booking->booking_status == 1): ?> checked="" <?php endif; ?>>通常</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="2" type="radio" <?php if($booking->booking_status == 2): ?> checked="" <?php endif; ?>>「TEL待ち」です</label>
            </div>
            <div class="radio">
              <label>
                <input name="booking_status" value="3" type="radio" <?php if($booking->booking_status == 3): ?> checked="" <?php endif; ?>>「リコール」です→
                <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs">
                  <?php if( $booking->booking_status == 3 ): ?>
                  <option value="0">▼選択</option>
                  <option value="01" <?php if($booking->booking_recall_ym == 01): ?> selected="" <?php endif; ?>
                  >1ヶ月後</option>
                  <option value="02" <?php if($booking->booking_recall_ym == 02): ?> selected="" <?php endif; ?>
                  >2ヶ月後</option>
                  <option value="03" <?php if($booking->booking_recall_ym == 03): ?> selected="" <?php endif; ?>
                  >3ヶ月後</option>
                  <option value="04" <?php if($booking->booking_recall_ym == 04): ?> selected="" <?php endif; ?>
                  >4ヶ月後</option>
                  <option value="05" <?php if($booking->booking_recall_ym == 05): ?> selected="" <?php endif; ?>
                  >5ヶ月後</option>
                  <option value="06" <?php if($booking->booking_recall_ym == 06): ?> selected="" <?php endif; ?>
                  >6ヶ月後</option>
                  <?php else: ?>
                  <option value="0">▼選択</option>
                  <option value="01">1ヶ月後</option>
                  <option value="02">2ヶ月後</option>
                  <option value="03">3ヶ月後</option>
                  <option value="04">4ヶ月後</option>
                  <option value="05">5ヶ月後</option>
                  <option value="06">6ヶ月後</option>
                  <?php endif; ?>
                </select>
              </label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="4" type="radio" <?php if($booking->booking_status == 4): ?> checked="" <?php endif; ?>>未作成技工物TEL待ち</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="5" type="radio" <?php if($booking->booking_status == 5): ?> checked="" <?php endif; ?>>作成済み技工物キャンセル</label>
            </div>
          </td>
        </tr>

        <tr>
          <td class="col-title"><label for="booking_memo">備考</label></td>
          <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control"><?php echo e($booking->booking_memo); ?></textarea></td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>