<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => ['ortho.bookings.booking.1st.regist',$booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　新患予約の新規登録</h3>
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
        <div class="table-responsive">
          <table class="table table-bordered">

            <!-- p_name -->
            <tr>
              <td class="col-title"><label for="p_name">患者名 (*)</label></td>
              <td><input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo e(old('p_name')); ?>" />
                <?php if($errors->first('p_name')): ?>
                    <span class="error-input">※ <?php echo $errors->first('p_name'); ?></span>
                <?php endif; ?>
              </td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_kana">患者名よみ (*)</label></td>
              <td><input type="text" name="p_name_kana" id="p_name_kana" class="form-control" value="<?php echo e(old('p_name_kana')); ?>" />
                <?php if($errors->first('p_name_kana')): ?>
                    <span class="error-input">※ <?php echo $errors->first('p_name_kana'); ?></span>
                <?php endif; ?>
              </td>
            </tr>

            <!-- p_sex -->
            <tr>
              <td class="col-title">性別 (*)</td>
              <td>
                <div class="row">
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="1" <?php if(old('p_sex') == 1): ?> checked="" <?php endif; ?> /> 男
                  </div>
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="2" <?php if(old('p_sex') == 2): ?> checked="" <?php endif; ?> /> 女
                  </div>
                </div>
                <?php if($errors->first('p_sex')): ?>
                    <span class="error-input">※ <?php echo $errors->first('p_sex'); ?></span>
                <?php endif; ?>
              </td>
            </tr>

            <!-- p_tel -->
            <tr>
              <td class="col-title"><label for="p_tel">電話番号</label></td>
              <td><input type="text" name="p_tel" id="p_tel" class="form-control" value="<?php echo e(old('p_tel')); ?>" /></td>
            </tr>

            <!-- if check -> insert to table "t_1st" -->
            <tr>
              <td class="col-title"><label for="insert_to_tbl_first">問診票の入力</label></td>
              <td>
                <div class="checkbox">
                  <label><input type="checkbox" name="insert_to_tbl_first" id="insert_to_tbl_first" value="1" <?php if(old('insert_to_tbl_first') == 1): ?> checked="" <?php endif; ?> />初診者一覧にも自動登録（＝問診票の新規登録）</label>
                </div>
              </td>
            </tr>

            <!-- booking_date -->
            <tr>
              <td class="col-title"><label for="cbReservation">予約日時</label></td>
              <td><?php echo e(formatDateJp($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)　<?php echo e(splitHourMin($booking->booking_start_time)); ?>～<?php echo e(toTime($booking->booking_start_time, $booking->booking_total_time)); ?>

              </td>
            </tr>

            <!-- clinic_id -->
            <tr>
              <td class="col-title">医院</td>
              <td><?php echo e($booking->clinic_name); ?></td>
            </tr>

            <!-- facility_id -->
            <tr>
              <td class="col-title"><label for="facility_id">設備</label></td>
              <td><select name="facility_id" id="facility_id" class="form-control">
                <option value="">▼選択</option>
                  <?php if(count($facilities) > 0): ?>
                  <?php foreach($facilities as $key => $facility): ?>
                    <option value="<?php echo e($key); ?>" <?php if($booking->facility_id == $key): ?> selected <?php endif; ?>><?php echo e($facility); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              </td>
            </tr>

            <!-- doctor_id -->
            <tr>
              <td class="col-title"><label for="doctor_id">ドクター</label></td>
              <td><select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">▼選択</option>
                <?php if(count($doctors) > 0): ?>
                  <?php foreach($doctors as $doctor): ?>
                    <option value="<?php echo e($doctor->id); ?>" <?php if($booking->doctor_id == $doctor->id): ?> selected <?php endif; ?>><?php echo e($doctor->u_name); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              </td>
            </tr>

            <!-- hygienist_id -->
            <tr>
              <td class="col-title"><label for="hygienist_id">衛生士</label></td>
              <td><select name="hygienist_id" id="hygienist_id" class="form-control">
                <option value="">▼選択</option>
                <?php if(count($hygienists) > 0): ?>
                  <?php foreach($hygienists as $hygienist): ?>
                    <option value="<?php echo e($hygienist->id); ?>" <?php if($booking->hygienist_id == $hygienist->id): ?> selected <?php endif; ?>><?php echo e($hygienist->u_name); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              </td>
            </tr>

            <!-- equipment_id -->
            <tr>
              <td class="col-title"><label for="equipment_id">装置</label></td>
              <td>
                <select name="equipment_id" id="equipment_id" class="form-control">
                  <option value="">▼選択</option>
                  <?php if(count($equipments) > 0): ?>
                  <?php foreach($equipments as $key => $equipment): ?>
                    <option value="<?php echo e($key); ?>" <?php if($booking->equipment_id == $key): ?> selected <?php endif; ?>><?php echo e($equipment); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
                </select>
              </td>
            </tr>

              <!-- service_1 -->
            <tr>
              <td class="col-title"><label for="service_1">業務内容-1</label></td>
              <td>
                <select name="service_1" id="service_1" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      <?php if(count($services) > 0): ?>
                        <?php foreach($services as $key11 => $service11): ?>
                        <option value="<?php echo e($key11); ?>#sk11" <?php if($booking->service_1 == $key11): ?> selected <?php endif; ?> ><?php echo e($service11); ?></option>
                      <?php endforeach; ?>
                      <?php endif; ?>
                  </optgroup>
                  <optgroup label="治療内容">
                        <?php if(count($treatment1s) > 0): ?>
                          <?php foreach($treatment1s as $key12 => $treatment12): ?>
                            <option value="<?php echo e($key12); ?>#sk12" <?php if($booking->service_1 == $key12): ?> selected <?php endif; ?>><?php echo e($treatment12); ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                  </optgroup>
                </select>
              </td>
            </tr>

            <!-- service_2 -->
            <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      <?php if(count($services) > 0): ?>
                        <?php foreach($services as $key21 => $service21): ?>
                        <option value="<?php echo e($key21); ?>#sk21" <?php if($booking->service_2 == $key21): ?> selected <?php endif; ?> ><?php echo e($service21); ?></option>
                      <?php endforeach; ?>
                      <?php endif; ?>
                  </optgroup>
                  <optgroup label="治療内容">
                        <?php if(count($treatment1s) > 0): ?>
                          <?php foreach($treatment1s as $key22 => $treatment22): ?>
                            <option value="<?php echo e($key22); ?>#sk22" <?php if($booking->service_2 == $key22): ?> selected <?php endif; ?>><?php echo e($treatment22); ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                  </optgroup>
                </select>
              </td>
            </tr>

            <!-- inspection_id -->
            <tr>
              <td class="col-title"><label for="inspection_id">検査</label></td>
             <td>
                <select name="inspection_id" id="inspection_id" class="form-control">
                  <option>▼選択</option>
                    <?php if(count($inspections) > 0): ?>
                    <?php foreach($inspections as $key => $inspection): ?>
                      <option value="<?php echo e($key); ?>" <?php if($booking->inspection_id == $key): ?> selected <?php endif; ?>><?php echo e($inspection); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </td>
            </tr>

            <!-- insurance_id -->
            <tr>
              <td class="col-title"><label for="insurance_id">保険診療</label></td>
              <td>
                <select name="insurance_id" id="insurance_id" class="form-control">
                  <option value="">▼選択</option>
                    <?php if(count($insurances) > 0): ?>
                    <?php foreach($insurances as $key => $insurance): ?>
                      <option value="<?php echo e($key); ?>" <?php if($booking->insurance_id == $key): ?> selected <?php endif; ?>><?php echo e($insurance); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
              </td>
            </tr>

              <!-- emergency_flag -->
            <tr>
              <td class="col-title"><label for="emergency_flag">救急</label></td>
              <td>
                <div class="checkbox">
                  <label> <input name="emergency_flag" type="checkbox" id="emergency_flag"<?php if($booking->emergency_flag == 1): ?> checked <?php endif; ?>>救急です</label>
                </div>
              </td>
            </tr>
            </tr>

              <!-- booking_status -->
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>
                <div class="radio">
                  <label><input name="booking_status" value="1" type="radio" <?php if($booking->booking_status == 1): ?> checked <?php endif; ?>>通常</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="2" type="radio" <?php if($booking->booking_status == 2): ?> checked <?php endif; ?>>「TEL待ち」です</label>
                </div>
                <div class="radio">
                  <label>
                    <input name="booking_status" value="3" type="radio" <?php if($booking->booking_status == 3): ?> checked <?php endif; ?>>「リコール」です→
                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                    <?php $year =  date('Y', strtotime($booking->booking_date))?>
                      <option value="" selected>▼選択</option>
                      <option value="<?php echo e($year); ?>01" <?php if($year.'01' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>1ヶ月後</option>
                      <option value="<?php echo e($year); ?>02" <?php if($year.'02' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>2ヶ月後</option>
                      <option value="<?php echo e($year); ?>03" <?php if($year.'03' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>3ヶ月後</option>
                      <option value="<?php echo e($year); ?>04" <?php if($year.'04' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>4ヶ月後</option>
                      <option value="<?php echo e($year); ?>05" <?php if($year.'05' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>5ヶ月後</option>
                      <option value="<?php echo e($year); ?>06" <?php if($year.'06' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>6ヶ月後</option>
                    </select>
                  </label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="4" type="radio" <?php if($booking->booking_status == 4): ?> checked <?php endif; ?>>未作成技工物TEL待ち</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="5" type="radio" <?php if($booking->booking_status == 5): ?> checked <?php endif; ?>>作成済み技工物キャンセル</label>
                </div>
              </td>
            </tr>

            <!-- booking_memo -->
            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control"><?php echo e(@$booking->booking_memo); ?></textarea></td>
            </tr>
          </table>
        </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="btnSave" value="登録する" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="history.back()" value="前の画面に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>