<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => ['ortho.bookings.booking_change_date', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　変更予約日</h3>

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

      <table class="table table-bordered treatment2-list">
        <tr>
          <td class="col-title">患者名</td>
          <td><?php echo e($booking->p_no); ?> <?php echo e($booking->p_name_f); ?> <?php echo e($booking->p_name_g); ?></td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
<!--     <td>
            <?php echo e(formatDateJp($booking->booking_date)); ?> (<?php echo e(DayJp($booking->booking_date)); ?>)　<?php echo e(splitHourMin($booking->booking_start_time)); ?>～<?php echo e(toTime($booking->booking_start_time, $booking->booking_total_time)); ?>

            </td> -->
            <td>
            <?php $bst = time2D4($booking->booking_start_time);
              $hh = $bst['hh']; $mm = $bst['mm'];
             ?>
                <label class="radio-inline">
                予約日 <input type="calendar" name="booking_date" id="date_picker_option" class="datepicker" style="width: 130px;" value="<?php echo e(@$booking->booking_date); ?>"></label>
                <label class="radio-inline">予約時間 <select name="hour_start"  id="hour_start" style="width: 60px;">
                        <option value="">-- 時</option>
                        <option value="00" <?php if($hh == '00'): ?> selected="" <?php endif; ?> >00 時</option>
                        <option value="01" <?php if($hh == '01'): ?> selected="" <?php endif; ?> >01 時</option>
                        <option value="02" <?php if($hh == '02'): ?> selected="" <?php endif; ?> >02 時</option>
                        <option value="03" <?php if($hh == '03'): ?> selected="" <?php endif; ?> >03 時</option>
                        <option value="04" <?php if($hh == '04'): ?> selected="" <?php endif; ?> >04 時</option>
                        <option value="05" <?php if($hh == '05'): ?> selected="" <?php endif; ?> >05 時</option>
                        <option value="06" <?php if($hh == '06'): ?> selected="" <?php endif; ?> >06 時</option>
                        <option value="07" <?php if($hh == '07'): ?> selected="" <?php endif; ?> >07 時</option>
                        <option value="08" <?php if($hh == '08'): ?> selected="" <?php endif; ?> >08 時</option>
                        <option value="09" <?php if($hh == '09'): ?> selected="" <?php endif; ?> >09 時</option>
                        <option value="10" <?php if($hh == '10'): ?> selected="" <?php endif; ?> >10 時</option>
                        <option value="11" <?php if($hh == '11'): ?> selected="" <?php endif; ?> >11 時</option>
                        <option value="12" <?php if($hh == '12'): ?> selected="" <?php endif; ?> >12 時</option>
                        <option value="13" <?php if($hh == '13'): ?> selected="" <?php endif; ?> >13 時</option>
                        <option value="14" <?php if($hh == '14'): ?> selected="" <?php endif; ?> >14 時</option>
                        <option value="15" <?php if($hh == '15'): ?> selected="" <?php endif; ?> >15 時</option>
                        <option value="16" <?php if($hh == '16'): ?> selected="" <?php endif; ?> >16 時</option>
                        <option value="17" <?php if($hh == '17'): ?> selected="" <?php endif; ?> >17 時</option>
                        <option value="18" <?php if($hh == '18'): ?> selected="" <?php endif; ?> >18 時</option>
                        <option value="19" <?php if($hh == '19'): ?> selected="" <?php endif; ?> >19 時</option>
                        <option value="20" <?php if($hh == '20'): ?> selected="" <?php endif; ?> >20 時</option>
                        <option value="21" <?php if($hh == '21'): ?> selected="" <?php endif; ?> >21 時</option>
                        <option value="22" <?php if($hh == '22'): ?> selected="" <?php endif; ?> >22 時</option>
                        <option value="23" <?php if($hh == '23'): ?> selected="" <?php endif; ?> >23 時</option>
                    </select>
                      :
                    <select name="min_start"  id="min_start" style="width: 60px;">
                        <option value="">-- 分</option>
                        <option value="00" <?php if($mm == '00'): ?> selected="" <?php endif; ?> >00 分</option>
<!--                         <option value="01" <?php if($mm == '01'): ?> selected="" <?php endif; ?> >01 分</option>
                        <option value="02" <?php if($mm == '02'): ?> selected="" <?php endif; ?> >02 分</option>
                        <option value="03" <?php if($mm == '03'): ?> selected="" <?php endif; ?> >03 分</option>
                        <option value="04" <?php if($mm == '04'): ?> selected="" <?php endif; ?> >04 分</option>
                        <option value="05" <?php if($mm == '05'): ?> selected="" <?php endif; ?> >05 分</option>
                        <option value="06" <?php if($mm == '06'): ?> selected="" <?php endif; ?> >06 分</option>
                        <option value="07" <?php if($mm == '07'): ?> selected="" <?php endif; ?> >07 分</option>
                        <option value="08" <?php if($mm == '08'): ?> selected="" <?php endif; ?> >08 分</option>
                        <option value="09" <?php if($mm == '09'): ?> selected="" <?php endif; ?> >09 分</option>
                        <option value="10" <?php if($mm == '10'): ?> selected="" <?php endif; ?> >10 分</option>
                        <option value="11" <?php if($mm == '11'): ?> selected="" <?php endif; ?> >11 分</option>
                        <option value="12" <?php if($mm == '12'): ?> selected="" <?php endif; ?> >12 分</option>
                        <option value="13" <?php if($mm == '13'): ?> selected="" <?php endif; ?> >13 分</option>
                        <option value="14" <?php if($mm == '14'): ?> selected="" <?php endif; ?> >14 分</option> -->
                        <option value="15" <?php if($mm == '15'): ?> selected="" <?php endif; ?> >15 分</option>
<!--                         <option value="16" <?php if($mm == '16'): ?> selected="" <?php endif; ?> >16 分</option>
                        <option value="17" <?php if($mm == '17'): ?> selected="" <?php endif; ?> >17 分</option>
                        <option value="18" <?php if($mm == '18'): ?> selected="" <?php endif; ?> >18 分</option>
                        <option value="19" <?php if($mm == '19'): ?> selected="" <?php endif; ?> >19 分</option>
                        <option value="20" <?php if($mm == '20'): ?> selected="" <?php endif; ?> >20 分</option>
                        <option value="21" <?php if($mm == '21'): ?> selected="" <?php endif; ?> >21 分</option>
                        <option value="22" <?php if($mm == '22'): ?> selected="" <?php endif; ?> >22 分</option>
                        <option value="23" <?php if($mm == '23'): ?> selected="" <?php endif; ?> >23 分</option>
                        <option value="24" <?php if($mm == '24'): ?> selected="" <?php endif; ?> >24 分</option>
                        <option value="25" <?php if($mm == '25'): ?> selected="" <?php endif; ?> >25 分</option>
                        <option value="26" <?php if($mm == '26'): ?> selected="" <?php endif; ?> >26 分</option>
                        <option value="27" <?php if($mm == '27'): ?> selected="" <?php endif; ?> >27 分</option>
                        <option value="28" <?php if($mm == '28'): ?> selected="" <?php endif; ?> >28 分</option>
                        <option value="29" <?php if($mm == '29'): ?> selected="" <?php endif; ?> >29 分</option> -->
                        <option value="30" <?php if($mm == '30'): ?> selected="" <?php endif; ?> >30 分</option>
<!--                         <option value="31" <?php if($mm == '31'): ?> selected="" <?php endif; ?> >31 分</option>
                        <option value="32" <?php if($mm == '32'): ?> selected="" <?php endif; ?> >32 分</option>
                        <option value="33" <?php if($mm == '33'): ?> selected="" <?php endif; ?> >33 分</option>
                        <option value="34" <?php if($mm == '34'): ?> selected="" <?php endif; ?> >34 分</option>
                        <option value="35" <?php if($mm == '35'): ?> selected="" <?php endif; ?> >35 分</option>
                        <option value="36" <?php if($mm == '36'): ?> selected="" <?php endif; ?> >36 分</option>
                        <option value="37" <?php if($mm == '37'): ?> selected="" <?php endif; ?> >37 分</option>
                        <option value="38" <?php if($mm == '38'): ?> selected="" <?php endif; ?> >38 分</option>
                        <option value="39" <?php if($mm == '39'): ?> selected="" <?php endif; ?> >39 分</option>
                        <option value="40" <?php if($mm == '40'): ?> selected="" <?php endif; ?> >40 分</option>
                        <option value="41" <?php if($mm == '41'): ?> selected="" <?php endif; ?> >41 分</option>
                        <option value="42" <?php if($mm == '42'): ?> selected="" <?php endif; ?> >42 分</option>
                        <option value="43" <?php if($mm == '43'): ?> selected="" <?php endif; ?> >43 分</option>
                        <option value="44" <?php if($mm == '44'): ?> selected="" <?php endif; ?> >44 分</option> -->
                        <option value="45" <?php if($mm == '45'): ?> selected="" <?php endif; ?> >45 分</option>
<!--                         <option value="46" <?php if($mm == '46'): ?> selected="" <?php endif; ?> >46 分</option>
                        <option value="47" <?php if($mm == '47'): ?> selected="" <?php endif; ?> >47 分</option>
                        <option value="48" <?php if($mm == '48'): ?> selected="" <?php endif; ?> >48 分</option>
                        <option value="49" <?php if($mm == '49'): ?> selected="" <?php endif; ?> >49 分</option>
                        <option value="50" <?php if($mm == '50'): ?> selected="" <?php endif; ?> >50 分</option>
                        <option value="51" <?php if($mm == '51'): ?> selected="" <?php endif; ?> >51 分</option>
                        <option value="52" <?php if($mm == '52'): ?> selected="" <?php endif; ?> >52 分</option>
                        <option value="53" <?php if($mm == '53'): ?> selected="" <?php endif; ?> >53 分</option>
                        <option value="54" <?php if($mm == '54'): ?> selected="" <?php endif; ?> >54 分</option>
                        <option value="55" <?php if($mm == '55'): ?> selected="" <?php endif; ?> >55 分</option>
                        <option value="56" <?php if($mm == '56'): ?> selected="" <?php endif; ?> >56 分</option>
                        <option value="57" <?php if($mm == '57'): ?> selected="" <?php endif; ?> >57 分</option>
                        <option value="58" <?php if($mm == '58'): ?> selected="" <?php endif; ?> >58 分</option>
                        <option value="59" <?php if($mm == '59'): ?> selected="" <?php endif; ?> >59 分</option> -->
                    </select>
                </label>
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
            <?php if($booking->service_1_kind == '1'): ?>
            <?php echo e(@$services[$booking->service_1]); ?>

            <?php elseif($booking->service_1_kind == '2'): ?>
            <?php echo e(@$treatment1s[$booking->service_1]); ?>

            <?php endif; ?>
          </td>
        </tr>
        <!-- <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            <?php if($booking->service_2_kind == '1'): ?>
            <?php echo e(@$services[$booking->service_2]); ?>

            <?php elseif($booking->service_2_kind == '2'): ?>
            <?php echo e(@$treatment1s[$booking->service_2]); ?>

            <?php endif; ?>
          </td>
        </tr> -->
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
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <?php if( $booking->booking_status == 1 ): ?>
            通常
            <?php elseif( $booking->booking_status == 2 ): ?>
            「TEL待ち」です
            <?php elseif( $booking->booking_status == 3 ): ?>
            「リコール」です→ <?php echo (empty($booking->booking_recall_ym)) ? '' : date('Y-m', strtotime($booking->booking_recall_ym)); ?>
            <?php elseif( $booking->booking_status == 4 ): ?>
            未作成技工物TEL待ち
            <?php elseif( $booking->booking_status == 5 ): ?>
            作成済み技工物キャンセル
            <?php elseif( $booking->booking_status == 6 ): ?>
            無断キャンセル
            <?php endif; ?>
          </td>
        </tr>
        <tr>
          <td class="col-title">登録者</td>
          <td><?php echo e(@$list_doctors[$booking->first_user]); ?></td>
        </tr>
        <tr>
          <td class="col-title">登録日時</td>
          <td><?php echo e(@dateHourMinSecond($booking->first_date, '/')); ?></td>
        </tr>
        <tr>
          <td class="col-title">最終更新者</td>
          <td><?php echo e(@$list_doctors[$booking->last_user]); ?></td>
        </tr>
        <tr>
          <td class="col-title">最終更新日時</td>
          <td><?php echo e(@dateHourMinSecond($booking->last_date, '/')); ?></td>
        </tr>
        <tr>
          <td class="col-title">備考</td>
          <td><?php echo e($booking->booking_memo); ?></td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input value="変化する" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom mar-top20">
      <div class="col-md-12 text-center">
        <input onclick="location.href='<?php echo e(route('ortho.bookings.booking.change')); ?>'" value="検索変更予約" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
        
  </div>
</section>
<?php echo Form::close(); ?>

<script type="text/javascript">
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>