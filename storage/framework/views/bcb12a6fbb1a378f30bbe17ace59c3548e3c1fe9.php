<script>
  // get days in month year => return number
  var curYearStar = '';
  var curMonthStar = '';
  var curYearEnd = '';
  var curMonthEnd = '';

  function getDayName(yearMonthDay) {
    var d = new Date(yearMonthDay);
    var weekday = new Array(7);
    weekday[0]=  "日";
    weekday[1] = "月";
    weekday[2] = "火";
    weekday[3] = "水";
    weekday[4] = "木";
    weekday[5] = "金";
    weekday[6] = "土";
    return weekday[d.getDay()];
  }
  function daysInMonth(year, month, editDay) {
    var str = '<option value="">---日</option>';
    if ( year.length && month.length ) {
      var numbers = new Date(year, month, 0).getDate();
      var selected = '';
      for (var i = 1; i <= numbers; i++) {
        if ( editDay == i ) {
          selected = 'selected';
        } else {
          selected = '';
        }
        var dayName = getDayName(year + '-' + month + '-' + i);
        if ( i < 10 ) {
          i = '0' + i;
        }
        str = str + '<option value="' + i + '" ' + selected + '>' + i + '日(' + dayName + ')</option>';
      }
    }
    return str;
  }
  function monthsInYear(year, editMonth) {
    var str = '<option value="">---月</option>';
    if ( year.length ) {
      var selected = '';
      for (var i = 1; i <= 12; i++) {
        if ( editMonth == i ) {
          selected = 'selected';
        } else {
          selected = '';
        }
        if ( i < 10 ) {
          i = '0' + i;
        }
        str = str + '<option value="' + i + '" ' + selected + '>' + i + '月</option>';
      }
    }
    return str;
  }

  function getMonths(object, year, editMonth) {
    if ( object == 'ddr_start_month' ) {
      curYearStar = year;
    } else {
      curYearEnd = year;
    }
    $('#' + object).html(monthsInYear(year, editMonth));
    // $('#ddr_start_month').html(monthsInYear(year, editMonth));
  }
  function getDays(object, month, editDay) {
    if ( object == 'ddr_start_day' ) {
      curMonthStar = month;
      $('#' + object).html(daysInMonth(curYearStar, curMonthStar, editDay));
    } else {
      curMonthEnd = month;
      $('#' + object).html(daysInMonth(curYearEnd, curMonthEnd, editDay));
    }
    // $('#ddr_start_day').html(daysInMonth(curYearStar, curMonthStar, editDay));
  }
</script>

<?php $__env->startSection('content'); ?>
<?php echo Form::open(array('route' => 'ortho.ddrs.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

  <section id="page">
    <div class="container">
      <div class="row content content--calendar">
        <h3>院長カレンダー　＞　予定の新規登録</h3>

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td class="col-title">開始日時 <span class="note-required">(<span class="note_required">※</span>)</span></td>
              <td>

                <!-- start_date -->
                <input type="hidden" name="start_date" value="<?php echo e($start_date); ?>">

                <!-- ddr_start_date -->
                <select name="ddr_start_year" id="ddr_start_year" class="form-control form-control--small" onchange="getMonths('ddr_start_month', $(this).val(), '')">
                  <option value="">---年</option>
                  <?php foreach( $years as $year ): ?>
                  <option value="<?php echo e($year); ?>" <?php if($ddr_start_date_y == $year): ?> selected="" <?php endif; ?>><?php echo e($year); ?></option>
                  <?php endforeach; ?>
                </select>
                <select name="ddr_start_month" id="ddr_start_month" class="form-control form-control--small" onchange="getDays('ddr_start_day', $(this).val(), '')">
                  <option value="">---月</option>
                </select>
                <select name="ddr_start_day" id="ddr_start_day" class="form-control form-control--small">
                  <option value="">---日</option>
                </select>
                <!-- <img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/dummy-calendar.png" width="27" height="23" /> -->
                <input type="hidden" id="datepicker">
                
                <!-- ddr_start_time -->
                <select name="ddr_start_hh" class="form-control form-control--small">
                  <option value="">---時</option>
                  <?php foreach( $hours as $hour): ?>
                  <option value="<?php echo e($hour); ?>" <?php if(old('ddr_start_hh') == $hour): ?> selected="" <?php endif; ?>><?php echo e($hour); ?>時</option>
                  <?php endforeach; ?>
                </select>
                <select name="ddr_start_mm" class="form-control form-control--small">
                  <option value="">---分</option>
                  <option value="00" <?php if(old('ddr_start_mm') == '00'): ?> selected="" <?php endif; ?>>00分</option>
                  <option value="15" <?php if(old('ddr_start_mm') == '15'): ?> selected="" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('ddr_start_mm') == '30'): ?> selected="" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('ddr_start_mm') == '45'): ?> selected="" <?php endif; ?>>45分</option>
                </select>
                から
                <span class="error-input"><?php if($errors->first('ddr_start_date')): ?> ※<?php echo $errors->first('ddr_start_date'); ?> <?php endif; ?></span>
              </td>
            </tr>
            <tr>
              <td class="col-title">終了日時</td>
              <td>
                <!-- ddr_end_date -->
                <select name="ddr_end_year" id="ddr_end_year" class="form-control form-control--small" onchange="getMonths('ddr_end_month', $(this).val(), '')">
                  <option value="">---年</option>
                  <?php foreach( $years as $year ): ?>
                  <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                  <?php endforeach; ?>
                </select>
                <select name="ddr_end_month" id="ddr_end_month" class="form-control form-control--small" onchange="getDays('ddr_end_day', $(this).val(), '')">
                  <option value="">---月</option>
                </select>
                <select name="ddr_end_day" id="ddr_end_day" class="form-control form-control--small">
                  <option value="">---日</option>
                </select>
                <!-- <img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/dummy-calendar.png" width="27" height="23" /> -->
                <input type="hidden" id="datepicker1">

                <!-- ddr_end_time -->
                <select name="ddr_end_hh" class="form-control form-control--small">
                  <option value="">--時</option>
                  <?php foreach( $hours as $hour): ?>
                  <option value="<?php echo e($hour); ?>" <?php if(old('ddr_end_hh') == $hour): ?> selected="" <?php endif; ?>><?php echo e($hour); ?>時</option>
                  <?php endforeach; ?>
                </select>
                <select name="ddr_end_mm" class="form-control form-control--small">
                  <option value="">--分</option>
                  <option value="00" <?php if(old('ddr_end_mm') == '00'): ?> selected="" <?php endif; ?>>00分</option>
                  <option value="15" <?php if(old('ddr_end_mm') == '15'): ?> selected="" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('ddr_end_mm') == '30'): ?> selected="" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('ddr_end_mm') == '45'): ?> selected="" <?php endif; ?>>45分</option>
                </select>
                まで
              </td>
            </tr>
            <tr>
              <td class="col-title">内容</td>
              <td>
                <!-- ddr_kind -->
                <select name="ddr_kind" class="form-control form-control--small">
                  <option style="color: #000" value="1" <?php if(old('ddr_kind') == 1): ?> selected="" <?php endif; ?>>■</option>
                  <option style="color: #F00" value="2" <?php if(old('ddr_kind') == 2): ?> selected="" <?php endif; ?>>■</option>
                  <option style="color: #00F" value="3" <?php if(old('ddr_kind') == 3): ?> selected="" <?php endif; ?>>■</option>
                  <option style="color: #390" value="4" <?php if(old('ddr_kind') == 4): ?> selected="" <?php endif; ?>>■</option>
                  <option style="color: #F90" value="5" <?php if(old('ddr_kind') == 5): ?> selected="" <?php endif; ?>>■</option>
                </select>          
                <input name="ddr_contents" type="text" value="<?php echo e(old('ddr_contents')); ?>" class="form-control form-control--medium"/>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 text-center">
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
    </div>
  </section>
<?php echo Form::close(); ?>


<script type="text/javascript">
  $(document).ready(function(){
    var editYearStar = "<?php echo e($ddr_start_date_y); ?>";
    var editMonthStar = "<?php echo e($ddr_start_date_m); ?>";
    var editDayStar = "<?php echo e($ddr_start_date_d); ?>";

    getMonths('ddr_start_month', editYearStar, editMonthStar);
    getDays('ddr_start_day', editMonthStar, editDayStar);

    // start date
    $('#ddr_start_year').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_start_month').html('<option value="">---月</option>');
        $('#ddr_start_day').html('<option value="">---日</option>');
      }
    });
    $('#ddr_start_month').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_start_day').html('<option value="">---日</option>');
      }
    });
    // end date
    $('#ddr_end_year').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_end_month').html('<option value="">---月</option>');
        $('#ddr_end_day').html('<option value="">---日</option>');
      }
    });
    $('#ddr_end_month').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_end_day').html('<option value="">---日</option>');
      }
    });


    // datepicker
    $(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker" ).datepicker({
        showOn: "button",
        buttonImage: "<?php echo e(asset('')); ?>public/backend/ortho/common/image/dummy-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: 'yyyy-mm-dd',
        inline: true,
        onSelect: function(dateText, inst) { 
          var date = $(this).datepicker('getDate'),
          day  = date.getDate(),
          month = date.getMonth() + 1,
          year =  date.getFullYear();
          console.log(year);
          console.log(month);
          console.log(day);

          $( "#ddr_start_year option" ).each(function( index ) {
            if($(this).val() == year) {
                $(this).prop("selected", true);
            }
          });

          getMonths('ddr_start_month', year.toString(), month.toString());
          getDays('ddr_start_day', month.toString(), day.toString());
        }
      });
    });

    // datepicker 1
    $(function() {
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $( "#datepicker1" ).datepicker({
        showOn: "button",
        buttonImage: "<?php echo e(asset('')); ?>public/backend/ortho/common/image/dummy-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: 'yyyy-mm-dd',
        inline: true,
        onSelect: function(dateText, inst) { 
          var date = $(this).datepicker('getDate'),
          day  = date.getDate(),
          month = date.getMonth() + 1,
          year =  date.getFullYear();

          $( "#ddr_end_year option" ).each(function( index ) {
            if($(this).val() == year) {
                $(this).prop("selected", true);
            }
          });

          getMonths('ddr_end_month', year.toString(), month.toString());
          getDays('ddr_end_day', month.toString(), day.toString());
        }
      });
    });
  });
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>