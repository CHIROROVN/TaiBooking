<?php $__env->startSection('content'); ?>

	<!-- Content shift search -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h1>シフト表</h1>

<?php echo Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'get', 'enctype'=>'multipart/form-data')); ?>

          <div class="fillter">
            <div class="col-md-12" style="text-align:center;">

              <button type="submit" class="btn btn-sm btn-page no-border" name="prev" value="" id="prev">&lt;&lt; 前月</button>&nbsp;&nbsp;&nbsp;&nbsp;
              <span id="text-year"><?php echo e($yearNow); ?></span>年<span id="text-month"><?php echo e($monthNow); ?></span>月&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="submit" class="btn btn-sm btn-page no-border" name="next" value="" id="next">翌月 &gt;&gt;</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
          </div>
</form>

<?php echo Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>


          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input value="保存する" type="submit" name="save" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input value="元に戻す" type="reset" name="back_save" class="btn btn-sm btn-page back-save">
              </div>
            </div>
            <table class="table table-bordered">
              <tr class="col-title">
                <td>&nbsp;</td>
                <?php foreach( $belongUsers as $belongUser ): ?>
                  <?php if( isset($belongUser->belong_users) ): ?>
                  <?php $colspan = (isset($belongUser->belong_users)) ? count($belongUser->belong_users) : 1; ?>
                  <td colspan="<?php echo e($colspan); ?>"><?php echo e($belongUser->belong_name); ?></td>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tr>

              <tr class="col-title">
                <td>&nbsp;</td>
                <?php foreach( $belongUsers as $belongUser ): ?>
                  <?php if( isset($belongUser->belong_users) ): ?>
                    <?php foreach( $belongUser->belong_users as $u ): ?>
                    <td><?php echo e($u->u_name); ?></td>
                    <?php endforeach; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              </tr>

              <!-- format value ==> -->
              <!-- ==> u_id|shift_date|linic_id -->
              <?php $selected = ''; ?>
              <?php foreach( $days as $dayKey => $dayValue ): ?>
              <?php $fullDate = $yearNow . '-' . $monthNow . '-' . $dayKey; ?>
              <tr>
                <td><?php echo e($dayValue); ?></td>
                <?php foreach( $users as $user ): ?>
                <td>
                  <select name="select[]" class="form-control form-control--small">
                  <option value="<?php echo e($user->id); ?>|<?php echo e($fullDate); ?>|0">▼選択</option>
                  <?php
                  if ( isset($shifts[$user->id . '|' . $fullDate . '|' . '-1']) ) {
                    $selected = 'selected';
                  } 
                  ?>
                  <option value="<?php echo e($user->id); ?>|<?php echo e($fullDate); ?>|-1" <?php echo e($selected); ?>>休み</option>
                  <?php foreach( $clinics as $clinic ): ?>
                  <?php
                  if ( isset($shifts[$user->id . '|' . $fullDate . '|' . $clinic->clinic_id]) ) {
                    $selected = 'selected';
                  } else {
                    $selected = '';
                  }
                  ?>
                  <option value="<?php echo e($user->id); ?>|<?php echo e($fullDate); ?>|<?php echo e($clinic->clinic_id); ?>" <?php echo e($selected); ?>><?php echo e($clinic->clinic_name); ?></option>
                  <?php endforeach; ?>
                  </select>
                </td>
                <?php endforeach; ?>
              <tr>
              <?php endforeach; ?>

            </table>
          </div>
          
          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input name="save" value="保存する" type="submit" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="back_save" value="元に戻す" type="reset" class="btn btn-sm btn-page back-save">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end container -->
    </section>
</form>

  <script>
    $(document).ready(function(){
      var yearNow = parseInt('<?php echo e($yearNow); ?>');
      var monthNow = parseInt('<?php echo e($monthNow); ?>');

      // prev
      $("#prev").click(function(){
        getDate(yearNow, monthNow - 1, $(this));
      });
      
      // next
      $("#next").click(function(){
        getDate(yearNow, monthNow + 1, $(this));
      });

      function getDate(year, month, obj) {
        monthNow = parseInt(month);
        yearNow = parseInt(year);
        
        // prev year
        if ( month < 1 ) {
          yearNow = year - 1;
          monthNow = 12;
        }

        // next year
        if ( month > 12 ) {
          yearNow = year + 1;
          monthNow = 1;
        }

        var monthNowShow = String(monthNow);
        if ( monthNow < 10 ) {
          var monthNowShow = String('0') + String(monthNow);
        }
        // $('#text-year').html(yearNow);
        // $('#text-month').html(monthNowShow);
        // $('#input-year').val(yearNow);
        // $('#input-month').val(monthNowShow);
        obj.val(yearNow + '-' + monthNowShow);
      }
    });
  </script>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script>
    var filestyler = new buttontoinputFile();
  </script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
  <!-- End content shift search -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>