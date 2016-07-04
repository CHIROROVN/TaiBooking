<?php $__env->startSection('content'); ?>
<!-- Content xray_3dct_regist -->
  <section id="page">
  <?php echo Form::open( ['id' => 'frmX3dctRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.xrays.x3dct.edit', $ct->ct_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

    <div class="container">
      <div class="row content-page">
        <h3>放射線照射録管理　＞　3D-CTの入力</h3>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-title">名前</td>
              <td><?php echo e($patient->p_no); ?>　<?php echo e($patient->p_name); ?>（<?php echo e($patient->p_name_kana); ?>）</td>
              <td class="col-title">担当</td>
              <td>
                <?php foreach( $users as $user ): ?>
                  <?php if( $user->id == $patient->p_dr ): ?>
                  <?php echo e($user->u_name); ?>

                  <?php endif; ?>
                <?php endforeach; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title">生年月日</td>
              <td><?php echo e(date('Y', strtotime($patient->p_birthday))); ?>年<?php echo e(date('m', strtotime($patient->p_birthday))); ?>月<?php echo e(date('d', strtotime($patient->p_birthday))); ?>日</td>
              <td class="col-title">性別</td>
              <td><?php echo ($patient->p_sex == 1) ? '男' : '女'; ?></td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">
          <!-- p_id -->
          <input type="hidden" name="p_id" value="<?php echo e($patient->p_id); ?>">

          <!-- ct_date -->
          <tr>
            <td class="col-title">撮影日</td>
            <td>
              <?php $ct_year = date('Y', strtotime($ct->ct_date)); ?>
              <select style="text-align: center;" name="year" id="year" class="form-control form-control--small">
                <option value="">----年</option>
                <option value="<?php echo e($prevYear); ?>" <?php if($prevYear == $ct_year): ?> selected="" <?php endif; ?>><?php echo e($prevYear); ?>年</option>
                <option value="<?php echo e($currYear); ?>" <?php if($currYear == $ct_year): ?> selected="" <?php endif; ?>><?php echo e($currYear); ?>年</option>
                <option value="<?php echo e($nextYear); ?>" <?php if($nextYear == $ct_year): ?> selected="" <?php endif; ?>><?php echo e($nextYear); ?>年</option>
              </select>
              <select style="text-align: center;" name="month" id="month" class="form-control form-control--small">
                <option value="">--月</option>
              </select>
              <select style="text-align: center;" name="day" id="day" class="form-control form-control--small">
                <option value="">--日</option>               
              </select>
              <img src="<?php echo e(asset('public/backend/ortho/common/image/dummy-calendar.png')); ?>" height="23" width="27">
              <span class="error-input"><?php if($errors->first('ct_date')): ?> <?php echo $errors->first('ct_date'); ?> <?php endif; ?></span>
            </td>
          </tr>

          <!-- u_id -->
          <tr>
            <td class="col-title">撮影者</td>
            <td>
              <select name="u_id" class="form-control form-control--small">
                <option value="0">----</option>
                <?php foreach( $users as $user ): ?>
                  <?php if( old('u_id') ): ?>
                  <option value="<?php echo e($user->id); ?>" <?php if(old('u_id') == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
                  <?php else: ?>
                  <option value="<?php echo e($user->id); ?>" <?php if($ct->u_id == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <span class="error-input"><?php if($errors->first('u_id')): ?> <?php echo $errors->first('u_id'); ?> <?php endif; ?></span>
            </td>
          </tr>

          <tr>
            <td class="col-title">区分</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_cat_1') ): ?>
                    <label><input name="ct_cat_1" type="checkbox" value="1" <?php if(old('ct_cat_1') == 1): ?> checked="" <?php endif; ?>>1回目</label>
                    <?php else: ?>
                    <label><input name="ct_cat_1" type="checkbox" value="1" <?php if($ct->ct_cat_1 == 1): ?> checked="" <?php endif; ?>>1回目</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_cat_2') ): ?>
                    <label><input name="ct_cat_2" type="checkbox" value="1" <?php if(old('ct_cat_2') == 1): ?> checked="" <?php endif; ?>>2回目</label>
                    <?php else: ?>
                    <label><input name="ct_cat_2" type="checkbox" value="1" <?php if($ct->ct_cat_2 == 1): ?> checked="" <?php endif; ?>>2回目</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_cat_3') ): ?>
                    <label><input name="ct_cat_3"  type="checkbox" value="1" <?php if(old('ct_cat_3') == 1): ?> checked="" <?php endif; ?>>3回目</label>
                    <?php else: ?>
                    <label><input name="ct_cat_3"  type="checkbox" value="1" <?php if($ct->ct_cat_3 == 1): ?> checked="" <?php endif; ?>>3回目</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_cat_4') ): ?>
                    <label><input name="ct_cat_4" type="checkbox" value="1" <?php if(old('ct_cat_4') == 1): ?> checked="" <?php endif; ?>>Ope前</label>
                    <?php else: ?>
                    <label><input name="ct_cat_4" type="checkbox" value="1" <?php if($ct->ct_cat_4 == 1): ?> checked="" <?php endif; ?>>Ope前</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_cat_5') ): ?>
                    <label><input name="ct_cat_5" type="checkbox" value="1" <?php if(old('ct_cat_5') == 1): ?> checked="" <?php endif; ?>>Ope後</label>
                    <?php else: ?>
                    <label><input name="ct_cat_5" type="checkbox" value="1" <?php if($ct->ct_cat_5 == 1): ?> checked="" <?php endif; ?>>Ope後</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_cat_6') ): ?>
                    <label><input name="ct_cat_6" type="checkbox" value="1" <?php if(old('ct_cat_6') == 1): ?> checked="" <?php endif; ?>>インプラント</label>
                    <?php else: ?>
                    <label><input name="ct_cat_6" type="checkbox" value="1" <?php if($ct->ct_cat_6 == 1): ?> checked="" <?php endif; ?>>インプラント</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_cat_7') ): ?>
                    <label><input name="ct_cat_7" type="checkbox" value="1" <?php if(old('ct_cat_7') == 1): ?> checked="" <?php endif; ?>>その他</label>
                    <?php else: ?>
                    <label><input name="ct_cat_7" type="checkbox" value="1" <?php if($ct->ct_cat_7 == 1): ?> checked="" <?php endif; ?>>その他</label>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <!-- ct_mode -->
          <tr>
            <td class="col-title">モード</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_mode_1') ): ?>
                    <label><input name="ct_mode_1" type="checkbox" value="1" <?php if(old('ct_mode_1') == 1): ?> checked="" <?php endif; ?>>I</label>
                    <?php else: ?>
                    <label><input name="ct_mode_1" type="checkbox" value="1" <?php if($ct->ct_mode_1 == 1): ?> checked="" <?php endif; ?>>I</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_mode_2') ): ?>
                    <label><input name="ct_mode_2" type="checkbox" value="1" <?php if(old('ct_mode_2') == 1): ?> checked="" <?php endif; ?>>P</label>
                    <?php else: ?>
                    <label><input name="ct_mode_2" type="checkbox" value="1" <?php if($ct->ct_mode_2 == 1): ?> checked="" <?php endif; ?>>P</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_mode_3') ): ?>
                    <label><input name="ct_mode_3" type="checkbox" value="1" <?php if(old('ct_mode_3') == 1): ?> checked="" <?php endif; ?>>F</label>
                    <?php else: ?>
                    <label><input name="ct_mode_3" type="checkbox" value="1" <?php if($ct->ct_mode_3 == 1): ?> checked="" <?php endif; ?>>F</label>
                    <?php endif; ?>
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
                    <?php if( old('ct_condition_1') ): ?>
                    <label><input name="ct_condition_1" type="checkbox" value="1" <?php if(old('ct_condition_1') == 1): ?> checked="" <?php endif; ?>>100kv 10mA</label>
                    <?php else: ?>
                    <label><input name="ct_condition_1" type="checkbox" value="1" <?php if($ct->ct_condition_1 == 1): ?> checked="" <?php endif; ?>>100kv 10mA</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_condition_3') ): ?>
                    <label><input name="ct_condition_3" type="checkbox" value="1" <?php if(old('ct_condition_3') == 1): ?> checked="" <?php endif; ?>>120kv 5mA</label>
                    <?php else: ?>
                    <label><input name="ct_condition_3" type="checkbox" value="1" <?php if($ct->ct_condition_3 == 1): ?> checked="" <?php endif; ?>>120kv 5mA</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_condition_2') ): ?>
                    <label><input name="ct_condition_2" type="checkbox" value="1" <?php if(old('ct_condition_2') == 1): ?> checked="" <?php endif; ?>>100kv 15mA</label>
                    <?php else: ?>
                    <label><input name="ct_condition_2" type="checkbox" value="1" <?php if($ct->ct_condition_2 == 1): ?> checked="" <?php endif; ?>>100kv 15mA</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_condition_4') ): ?>
                    <label><input name="ct_condition_4" type="checkbox" value="1" <?php if(old('ct_condition_4') == 1): ?> checked="" <?php endif; ?>>120kv 10mA</label>
                    <?php else: ?>
                    <label><input name="ct_condition_4" type="checkbox" value="1" <?php if($ct->ct_condition_4 == 1): ?> checked="" <?php endif; ?>>120kv 10mA</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_condition_5') ): ?>
                    <label><input name="ct_condition_5" type="checkbox" value="1" <?php if(old('ct_condition_5') == 1): ?> checked="" <?php endif; ?>>120kv 15mA</label>
                    <?php else: ?>
                    <label><input name="ct_condition_5" type="checkbox" value="1" <?php if($ct->ct_condition_5 == 1): ?> checked="" <?php endif; ?>>120kv 15mA</label>
                    <?php endif; ?>
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
                    <?php if( old('ct_memo_1') ): ?>
                    <label><input name="ct_memo_1" type="checkbox" value="1" <?php if(old('ct_memo_1') == 1): ?> checked="" <?php endif; ?>>CD-R</label>
                    <?php else: ?>
                    <label><input name="ct_memo_1" type="checkbox" value="1" <?php if($ct->ct_memo_1 == 1): ?> checked="" <?php endif; ?>>CD-R</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_memo_5') ): ?>
                    <label><input name="ct_memo_5" type="checkbox" value="1" <?php if(old('ct_memo_5') == 1): ?> checked="" <?php endif; ?>>2回撮影</label>
                    <?php else: ?>
                    <label><input name="ct_memo_5" type="checkbox" value="1" <?php if($ct->ct_memo_5 == 1): ?> checked="" <?php endif; ?>>2回撮影</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_memo_2') ): ?>
                    <label><input name="ct_memo_2" type="checkbox" value="1" <?php if(old('ct_memo_2') == 1): ?> checked="" <?php endif; ?>>Dr.S</label>
                    <?php else: ?>
                    <label><input name="ct_memo_2" type="checkbox" value="1" <?php if($ct->ct_memo_2 == 1): ?> checked="" <?php endif; ?>>Dr.S</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_memo_6') ): ?>
                    <label><input name="ct_memo_6" type="checkbox" value="1" <?php if(old('ct_memo_6') == 1): ?> checked="" <?php endif; ?>>再治療</label>
                    <?php else: ?>
                    <label><input name="ct_memo_6" type="checkbox" value="1" <?php if($ct->ct_memo_6 == 1): ?> checked="" <?php endif; ?>>再治療</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_memo_3') ): ?>
                    <label><input name="ct_memo_3" type="checkbox" value="1" <?php if(old('ct_memo_3') == 1): ?> checked="" <?php endif; ?>>口蓋裂</label>
                    <?php else: ?>
                    <label><input name="ct_memo_3" type="checkbox" value="1" <?php if($ct->ct_memo_3 == 1): ?> checked="" <?php endif; ?>>口蓋裂</label>
                    <?php endif; ?>
                  </div>
                  <div class="checkbox">
                    <?php if( old('ct_memo_7') ): ?>
                    <label><input name="ct_memo_7" type="checkbox" value="1" <?php if(old('ct_memo_7') == 1): ?> checked="" <?php endif; ?>>転院</label>
                    <?php else: ?>
                    <label><input name="ct_memo_7" type="checkbox" value="1" <?php if($ct->ct_memo_7 == 1): ?> checked="" <?php endif; ?>>転院</label>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    <?php if( old('ct_memo_4') ): ?>
                    <label><input name="ct_memo_4" type="checkbox" value="1" <?php if(old('ct_memo_4') == 1): ?> checked="" <?php endif; ?>>過剰歯</label>
                    <?php else: ?>
                    <label><input name="ct_memo_4" type="checkbox" value="1" <?php if($ct->ct_memo_4 == 1): ?> checked="" <?php endif; ?>>過剰歯</label>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">備考2</td>
            <td>
              <?php if( old('ct_memo') ): ?>
              <textarea name="ct_memo" cols="60" rows="3" class="form-control"><?php echo e(old('ct_memo')); ?></textarea>
              <?php else: ?>
              <textarea name="ct_memo" cols="60" rows="3" class="form-control"><?php echo e($ct->ct_memo); ?></textarea>
              <?php endif; ?>
            </td>
          </tr>
        </table>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <!-- save -->
          <input name="btnSave" id="btnSave" value="登録する" type="submit" class="btn btn-sm btn-page">
          <!-- delete -->
          <input type="button" value="削除" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($ct->ct_id); ?>"/>
          <!-- Modal -->
          <div class="modal fade" id="myModal-<?php echo e($ct->ct_id); ?>" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"><?php echo e(trans('common.modal_header_delete')); ?></h4>
                </div>
                <div class="modal-body">
                  <p><?php echo e(trans('common.modal_content_delete')); ?></p>
                </div>
                <div class="modal-footer">
                  <a href="<?php echo e(route('ortho.xrays.x3dct.delete', [ $ct->ct_id, 'patient_id' => $patient->p_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
                </div>
              </div>
            </div>
          </div>
          <!-- end Modal -->
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
    var ct_month = '<?php
                    if ( empty($ct->ct_date) ) {
                      echo '';
                    } else {
                      echo date('m', strtotime($ct->ct_date));
                    }
                  ?>';

      for(m=1; m<=12; m++){
        if ( m == ct_month ) {
          optionMonth += "<option value="+num2digit(m)+" selected>" + num2digit(m) + '月' + "</option>";
        } else {
          optionMonth += "<option value="+num2digit(m)+">" + num2digit(m) + '月' + "</option>";
        }
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
    var ct_day = '<?php
                    if ( empty($ct->ct_date) ) {
                      echo '';
                    } else {
                      echo date('d', strtotime($ct->ct_date));
                    }
                  ?>';
    for(d = 1; d <= getDays; d++){
      if ( d == ct_day ) {
        optionDay += "<option value="+num2digit(d)+" selected>" + num2digit(d) + '日' + "</option>";
      } else {
        optionDay += "<option value="+num2digit(d)+">" + num2digit(d) + '日' + "</option>";
      }
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