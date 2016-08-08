<?php $__env->startSection('content'); ?>

<?php echo Form::open( ['id' => 'frmBookingRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking.regist', $booking_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

<section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>予約管理　＞　予約の新規登録</h3>
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
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="textName">患者名</label></td>
              <td>
                <?php $pt = showPatient($booking->patient_id);?>
                <input type="hidden" name="p_id" id="p_id" value="<?php echo e(@$pt['p_id']); ?>">
                <input type="text" name="patient" id="patient" class="input-text-mid form-control" style="width: 250px; display: inline;" value="<?php echo e(@$pt['patient']); ?>"> &nbsp;
                <input type="button" name="1stBK" id="button" value="新患です" class="btn btn-sm btn-page" onclick="location.href='<?php echo e(route('ortho.bookings.booking.1st.regist',$booking->booking_id)); ?>'">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textNameRead">予約日時</label></td>
              <td><?php echo e(formatDateJp($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)　<?php echo e(splitHourMin($booking->booking_start_time)); ?>

              </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td><?php echo e($booking->clinic_name); ?></td>
            </tr>
            <!-- <tr>
              <td class="col-title"><label for="facility_id">チェアー</label></td>
              <td><select name="facility_id" id="facility_id" class="form-control">
                <option value="">▼選択</option>
                  <?php if(count($facilities) > 0): ?>
                  <?php foreach($facilities as $key => $facility): ?>
                    <option value="<?php echo e($key); ?>" <?php if($booking->facility_id == $key): ?> selected <?php endif; ?>><?php echo e($facility); ?></option>
                  <?php endforeach; ?>
                <?php endif; ?>
              </select>
              </td>
            </tr> -->
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
            <tr>
              <td class="col-title"><label for="service_1">業務内容-1</label></td>
              <td>
                <?php if( $booking->service_1_kind == 1 ): ?>
                <?php echo e(@$services[$booking->service_1]); ?>

                <?php else: ?>
                <select name="service_1" id="service_1" class="form-control">
                  <option value="-1">▼選択</option>
                  <?php if(count($treatment1s) > 0): ?>
                    <?php foreach($treatment1s as $treatment12): ?>
                        <option value="<?php echo e($treatment12->treatment_id); ?>#<?php echo e($treatment12->treatment_time); ?>_sk22" <?php if($booking->service_1 == $treatment12->treatment_id): ?> selected <?php endif; ?>><?php echo e($treatment12->treatment_name); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php endif; ?>
              </td>
            </tr>
            <!-- <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      <?php if(count($services) > 0): ?>
                        <?php foreach($services as $key21 => $service21): ?>
                          <option value="<?php echo e($key21); ?>_sk21" <?php if($booking->service_2 == $key21): ?> selected <?php endif; ?> ><?php echo e($service21); ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                  </optgroup>
                  <optgroup label="治療内容">
                        <?php if(count($treatment1s) > 0): ?>
                          <?php foreach($treatment1s as $treatment12): ?>
                            <option value="<?php echo e($treatment12->treatment_id); ?>#<?php echo e($treatment12->treatment_time); ?>_sk22" <?php if($booking->service_2 == $treatment12->treatment_id): ?> selected <?php endif; ?> ><?php echo e($treatment12->treatment_name); ?></option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                  </optgroup>
                </select>
              </td>
            </tr> -->
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
            <tr>
              <td class="col-title"><label for="ckEmergency">救急</label></td>
              <td>
                <div class="checkbox">
                  <label> <input name="emergency_flag" type="checkbox" id="emergency_flag"<?php if($booking->emergency_flag == 1): ?> checked <?php endif; ?>>救急です</label>
                </div>
              </td>
            </tr>
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
                    <input name="booking_status" id="recalling" value="3" type="radio" <?php if($booking->booking_status == 3): ?> checked <?php endif; ?>>「リコール」です→
                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                    <?php $year =  date('Y', strtotime($booking->booking_date))?>
                      <option value="" selected>▼選択</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 01, 'Ym')); ?>" <?php if($year.'01' == $booking->booking_recall_ym): ?> selected <?php endif; ?>>1ヶ月後</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 02, 'Ym')); ?>" <?php if(dateAddMonth($booking->booking_date, 03, 'Ym') == $booking->booking_recall_ym): ?> selected <?php endif; ?>>2ヶ月後</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 03, 'Ym')); ?>" <?php if(dateAddMonth($booking->booking_date, 03, 'Ym') == $booking->booking_recall_ym): ?> selected <?php endif; ?>>3ヶ月後</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 04, 'Ym')); ?>" <?php if(dateAddMonth($booking->booking_date, 04, 'Ym') == $booking->booking_recall_ym): ?> selected <?php endif; ?>>4ヶ月後</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 05, 'Ym')); ?>0" <?php if(dateAddMonth($booking->booking_date, 05, 'Ym') == $booking->booking_recall_ym): ?> selected <?php endif; ?>>5ヶ月後</option>
                      <option value="<?php echo e(dateAddMonth($booking->booking_date, 06, 'Ym')); ?>" <?php if(dateAddMonth($booking->booking_date, 06, 'Ym') == $booking->booking_recall_ym): ?> selected <?php endif; ?>>6ヶ月後</option>
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
            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area"><?php echo e(@$booking->booking_memo); ?></textarea></td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
<?php echo Form::close(); ?>

<script type="text/javascript">
  $('#booking_recall_ym').click(function() {
    $('#recalling').attr("checked", "checked");
  });
</script>

<script>
  $(document).ready(function(){
    $( "#patient" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#patient').val();
          $.ajax({
              url: "<?php echo e(route('ortho.patients.autocomplete.patient')); ?>",
              beforeSend: function(){
              },
              method: "GET",
              data: { key: key },
              dataType: "json",
              success: function(data) {
                response(data);
              },
          });
      },
      focus: function( event, ui ) {
        $( "#patient" ).val( ui.item.label );
        return true;
      },
      select: function( event, ui ) {
        $( "#patient" ).val( ui.item.label );
        $( "#p_id" ).val( ui.item.value );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>