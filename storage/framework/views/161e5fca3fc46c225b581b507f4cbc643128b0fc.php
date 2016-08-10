<?php $__env->startSection('content'); ?>
<?php echo Form::open( ['id' => 'frmBookingSearch', 'class' => 'form-horizontal','method' => 'post', 'route' => 'ortho.bookings.booking_search', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

   <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約の検索</h3>
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="textName">医院</label></td>
                  <td>
                    <select name="clinic_id" id="clinic_id" class="form-control">
                      <option value="">▼選択</option>
                      <?php if(count($clinics) > 0): ?>
                        <?php $listClinic = $clinics; ?>
                        <?php foreach($listClinic as $clinic_id => $clinic): ?>
                          <?php if( $clinic == 'たい矯正歯科' ): ?>
                          <option value="<?php echo e($clinic_id); ?>" selected=""><?php echo e($clinic); ?></option>
                          <?php unset($listClinic[$clinic_id]) ?>
                          <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach($listClinic as $clinic_id => $clinic): ?>
                        <option value="<?php echo e($clinic_id); ?>"><?php echo e($clinic); ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">担当ドクター</td>
                  <td>
                    <div class="row">
                      <?php if(count($doctors) > 0): ?>
                        <?php foreach($doctors as $doctor): ?>
                          <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="checkbox">
                              <label><input name="doctor_id[]" value="<?php echo e($doctor->id); ?>" type="checkbox"> <?php echo e($doctor->u_name); ?></label>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td>
                    <div class="row">
                       <?php if(count($hygienists) > 0): ?>
                        <?php foreach($hygienists as $hygienist): ?>
                          <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="checkbox">
                              <label><input name="hygienist_id[]" value="<?php echo e($hygienist->id); ?>" type="checkbox"> <?php echo e($hygienist->u_name); ?></label>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">曜日</td>
                  <td>
                    <div class="row">
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="1" type="checkbox">日</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="2" type="checkbox">月</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="3" type="checkbox">火</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="4" type="checkbox">水</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="5" type="checkbox">木</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="6" type="checkbox">金</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="7" type="checkbox">土</label>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                    <td class=col-title>何週間後</td>
                    <td>
                      <label class="radio-inline"><input type="radio" class="week_later" checked=""  id="none_week" value="" name="week_later">指定なし</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_week" id="one_week"  name="week_later">1週間後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" value="one_month" id="one_month" name="week_later">1ヵ月後</label>
                      <label class="radio-inline"><input type="radio" class="week_later" id="two_month" value="two_month" name="week_later">2ヵ月後</label>
                      
                      <label class="radio-inline">
                      <input type="radio" class="week_later" value="week_specified" name="week_later" id="week_later">
                          <select name="week_later_option"  id="week_later_option" style="width: 100px;">
                                  <option value="one_week">1週間後</option>
                                  <option value="two_week">2週間後</option>
                                  <option value="three_week">3週間後</option>
                                  <option value="four_week">4週間後</option>
                                  <option value="five_week">5週間後</option>
                          </select>
                          週指定</label>
                      
                        <label class="radio-inline"><input type="radio" class="week_later" name="week_later" id="date_picker" value="date_picker">日付指定
                        <input type="calendar" name="date_picker_option" id="date_picker_option" class="datepicker" style="width: 150px;"></label>
                    </td>
                    </td>
                </tr>
                <tr>
                  <td class="col-title">業務</td>
                  <td>
                    <select name="clinic_service_name" id="clinic_service_name" class="form-control">
                      <option value="" selected="selected">指定なし</option>
                      <optgroup label="業務名">
                        <?php if(count($services) > 0): ?>
                          <?php foreach($services as $service): ?>
                          <option value="<?php echo e($service->service_id); ?>_sk1" ><?php echo e($service->service_name); ?></option>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </optgroup>
                    <optgroup label="治療内容">
                          <?php if(count($treatment1s) > 0): ?>
                            <?php foreach($treatment1s as $treatment12): ?>
                              <option value="<?php echo e($treatment12->treatment_id); ?>#<?php echo e($treatment12->treatment_time); ?>_sk2" ><?php echo e($treatment12->treatment_name); ?></option>
                            <?php endforeach; ?>
                          <?php endif; ?>
                    </optgroup>
                    </select>
                  </td>
                </tr>
              </table>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              
              <input name="BookingCalendar" id="BookingCalendar" onclick="goBookingSearch();" value="検索開始（カレンダー表示）" type="button" class="btn btn-sm btn-page mar-right">

              <input name="BookingList" id="BookingList" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="Reset" id="btnReset" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
<?php echo Form::close(); ?>


<script type="text/javascript">
    function goBookingSearch() {
      var clinic_id = $("#clinic_id option:selected").val();
      var link = "<?php echo e(route('ortho.bookings.booking.result.calendar')); ?>?clinic_id=" + clinic_id;
      window.location.href = link;
    }

    $(document).ready(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $(".datepicker").datepicker({
          showOn: 'both',
          buttonText: 'カレンダー',
          buttonImageOnly: true,
          buttonImage: "<?php echo e(asset('public/backend/ortho/common/image/dummy-calendar.png')); ?>",
          dateFormat: 'yy-mm-dd',
          constrainInput: true,
          inline: true,
          lang: 'ja'
      });

      $('.ui-datepicker-trigger').css('margin-top','1px');
      $(".ui-datepicker-trigger").mouseover(function() {
          $(this).css('cursor', 'pointer');
      });

      $('.ui-datepicker-trigger').click(function(event) {
        $('#date_picker').attr("checked", "checked");
      });
  });
</script>

<script type="text/javascript">
  $('#date_picker_option').click(function() {
    $('#date_picker').attr("checked", "checked");
  });

  $('#none_week').click(function(event) {
    $('#none_week').attr("checked", "checked");
  });
  $('#one_week').click(function(event) {
    $('#one_week').attr("checked", "checked");
  });
  $('#one_month').click(function(event) {
    $('#one_month').attr("checked", "checked");
  });
  $('#two_month').click(function(event) {
    $('#two_month').attr("checked", "checked");
  });

  $('#week_later_option').click(function(event) {
    $('#week_later').attr("checked", "checked");
  });

  $('#date_picker').click(function(event) {
    $('#date_picker').attr("checked", "checked");
  });
  $('#week_later').click(function(event) {
    $('#week_later').attr("checked", "checked");
  });

  $("#btnReset").click(function(event) {
    $(".week_later").each(function( i, opt ) {
     $('.week_later').attr('checked', false);
    });
    $('#none_week').attr("checked", "checked");
  });

  
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>