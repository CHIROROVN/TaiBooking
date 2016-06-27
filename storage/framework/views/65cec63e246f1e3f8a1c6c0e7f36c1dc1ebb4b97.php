<?php $__env->startSection('content'); ?>
<!-- Content xray_3dct_regist -->
  <section id="page">
  <?php echo Form::open( ['id' => 'frmX3dctRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => 'ortho.xrays.x3dct.regist', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

    <div class="container">
      <div class="row content-page">
        <h3>放射線照射録管理　＞　3D-CTの入力</h3>
        <table class="table table-bordered">
          <tr>
            <td class="col-title">名前</td>
            <td>123456　杉元　俊彦（すぎもと　としひこ）</td>
            <td class="col-title">担当</td>
            <td>田井Dr</td>
          </tr>
          <tr>
            <td class="col-title">生年月日</td>
            <td>1980年11月27日</td>
            <td class="col-title">性別</td>
            <td>男</td>
          </tr>
        </table>
        <table class="table table-bordered">
          <tr>
            <td class="col-title">撮影日</td>
            <td>
              <select style="text-align: center;" name="year" id="year" class="form-control form-control--small">
                <option value="">----年</option>
                <option value="<?php echo e($prevYear); ?>"><?php echo e($prevYear); ?>年</option>
                <option value="<?php echo e($currYear); ?>"><?php echo e($currYear); ?>年</option>
                <option value="<?php echo e($nextYear); ?>"><?php echo e($nextYear); ?>年</option>
              </select>
              <select style="text-align: center;" name="month" id="month" class="form-control form-control--small">
                <option value="">--月</option>
              </select>
              <select style="text-align: center;" name="day" id="day" class="form-control form-control--small">
                <option value="">--日</option>               
              </select>
              <img src="<?php echo e(asset('public/backend/ortho/common/image/dummy-calendar.png')); ?>" height="23" width="27">
            </td>
          </tr>
          <tr>
            <td class="col-title">撮影者</td>
            <td>
              <select name="select" class="form-control form-control--small">
                <option></option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title">区分</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">1回目</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">2回目</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox"  type="checkbox">3回目</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">Ope前</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">Ope後</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">インプラント</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">その他</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">モード</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">I</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">P</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">F</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">撮影条件</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">100kv 10mA</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">120kv 5mA</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">100kv 15mA</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">120kv 10mA</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">120kv 15mA</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">備考1</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">CD-R</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">2回撮影</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">Dr.S</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">再治療</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">口蓋裂</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">転院</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <label><input name="checkbox" type="checkbox">過剰歯</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">備考2</td>
            <td>
              <textarea name="textfield2" cols="60" rows="3" class="form-control"></textarea>
            </td>
          </tr>
        </table>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="btnSave" id="btnSave" value="登録する" type="submit" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
    <?php echo Form::close(); ?>

  </section>
  <!-- End content xray_3dct_regist -->
<script type="text/javascript">
  $('#year').change(function() {
    var curr_year = $(this).val();
    var optionMonth = "<option value=''>--月</option>";
      for(m=1; m<=12; m++){
        optionMonth += "<option value="+num2digit(m)+">" + num2digit(m) + '月' + "</option>";
      }
      $('#month').html(optionMonth);
      var now_month = (new Date).getMonth() + 1;
      $('#month option:eq(' + now_month + ')').prop('selected', true);

      var curr_month = $('#month option:selected').val();
      var getDays = getDaysInMonth(curr_year, curr_month);
      var optionYDay = "<option value=''>--日</option>";
          for(y = 1; y <= getDays; y++){
              optionYDay += "<option value="+num2digit(y)+">" + num2digit(y) + '日' + "</option>";
          }
      $('#day').html(optionYDay);
      $('#day option:eq(' + (new Date).getDate() + ')').prop('selected', true);

      if(curr_year == ''){
        $('#month').html("<option value=''>--月</option>");
        $('#day option:eq(' + '' + ')').prop('selected', true);
        $('#day').html("<option value=''>--日</option>");
      }
   });

  $('#month').change(function() {
    var year = $('#year option:selected').val();
    var month = num2digit($(this).val());
    var getDays = getDaysInMonth(year, month);
    var optionDay = "<option value=''>--日</option>";
    for(d = 1; d <= getDays; d++){
        optionDay += "<option value="+num2digit(d)+">" + num2digit(d) + '日' + "</option>";
    }
    $('#day').html(optionDay);
    if(month == '0'){
      $('#day').html("<option value=''>--日</option>");
    }
    $('#day option:eq(' + (new Date).getDate() + ')').prop('selected', true);
  });

  function getDaysInMonth(year,month) {
    return new Date(year, month, 0).getDate();
  }

  function num2digit(n){
    return n > 9 ? "" + n: "0" + n;
  }
</script>  

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>