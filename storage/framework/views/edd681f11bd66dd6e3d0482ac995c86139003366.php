<?php $__env->startSection('content'); ?>

<script>
  function getVal(val) {
    var month = '';
    var old_day = "<?php echo e(old('xray_date_day')); ?>";
    $('#day').find('option').remove();

    if ( $.isNumeric( val ) ) {
      month = val;
    } else {
      month = val.value;
    }

    $.ajax({
      method: "GET",
      url: "<?php echo e(route('ortho.xrays.get.day')); ?>",
      dataType: "json",
      data: { month: month }
    }).done(function( msg ) {
      // set value for select option month
      $('#day').append('<option value="0">--日</option>');
      $.each( msg, function( key, value ) {
        if ( old_day == value ) {
          $('#day').append('<option value="' + value + '" selected>' + value + '日</option>');
        } else {
          $('#day').append('<option value="' + value + '">' + value + '日</option>');
        }
      });
    });
  }
</script>

<?php echo Form::open(array('route' => 'ortho.xrays.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>放射線照射録管理　＞　レントゲンの入力</h3>
      
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title">名前</td>
            <td><?php echo e($xray->p_no); ?>　<?php echo e($xray->p_name); ?>（<?php echo e($xray->p_name_kana); ?>）</td>
            <td class="col-title">担当</td>
            <td>
              <?php foreach( $users as $user ): ?>
                <?php if( $user->id == $xray->p_dr ): ?>
                <?php echo e($user->u_name); ?>

                <?php endif; ?>
              <?php endforeach; ?>
            </td>
          </tr>
          <tr>
            <td class="col-title">生年月日</td>
            <td><?php echo e(date('Y', strtotime($patient->p_birthday))); ?>年<?php echo e(date('m', strtotime($patient->p_birthday))); ?>月<?php echo e(date('d', strtotime($patient->p_birthday))); ?>日</td>
            <td class="col-title">性別</td>
            <td><?php echo ($xray->p_sex == 1) ? '男' : '女'; ?></td>
          </tr>
        </tbody>
      </table>

      <table class="table table-bordered">

        <!-- p_id -->
        <input type="hidden" name="p_id" value="<?php echo e($patient->p_id); ?>">

        <!-- xray_date -->
        <?php
        $year_now = date('Y');
        $year_next = $year_now + 1;
        $year_prev = $year_now - 1;
        ?>
        <tr>
          <td class="col-title">撮影日</td>
          <td>
            <select name="xray_date_year" class="form-control form-control--small">
              <option value="0">----年</option>
              <option value="<?php echo e($year_prev); ?>" <?php if(old('xray_date_year') == $year_prev): ?> selected="" <?php endif; ?>><?php echo e($year_prev); ?>年</option>
              <option value="<?php echo e($year_now); ?>" <?php if(old('xray_date_year') == $year_now): ?> selected="" <?php endif; ?>><?php echo e($year_now); ?>年</option>
              <option value="<?php echo e($year_next); ?>" <?php if(old('xray_date_year') == $year_next): ?> selected="" <?php endif; ?>><?php echo e($year_next); ?>年</option>
            </select>
            <select name="xray_date_month" class="form-control form-control--small" id="month" onchange="getVal(this);">
              <option value="0">--月</option>
              <?php for( $i = 1; $i <= 12; $i++ ): ?>
              <option value="<?php echo e($i); ?>" <?php if(old('xray_date_month') == $i): ?> selected="" <?php endif; ?>><?php echo e($i); ?>月</option>
              <?php endfor; ?>
            </select>
            <select name="xray_date_day" class="form-control form-control--small" id="day">
              <option value="0">--日</option>
            </select>
            <img src="<?php echo e(asset('')); ?>public/backend/ortho/common/image/dummy-calendar.png" height="23" width="27">
            <span class="error-input"><?php if($errors->first('xray_date')): ?> <?php echo $errors->first('xray_date'); ?> <?php endif; ?></span>
          </td>
        </tr>

        <!-- xray_place (clinic_name, clinic_id) -->
        <tr>
          <td class="col-title">撮影場所</td>
          <td>
            <select name="xray_place" class="form-control form-control--small">
              <option value="0">----</option>
              <?php foreach( $clinics as $clinic ): ?>
              <option value="<?php echo e($clinic->clinic_id); ?>" <?php if(old('xray_place') == $clinic->clinic_id): ?> selected="" <?php endif; ?>><?php echo e($clinic->clinic_name); ?></option>
              <?php endforeach; ?>
            </select>
            <span class="error-input"><?php if($errors->first('xray_place')): ?> <?php echo $errors->first('xray_place'); ?> <?php endif; ?></span>
          </td>
        </tr>

        <!-- u_id -->
        <tr>
          <td class="col-title">撮影者</td>
          <td>
            <select name="u_id" class="form-control form-control--small">
              <option value="0">----</option>
              <?php foreach( $users as $user ): ?>
              <option value="<?php echo e($user->id); ?>" <?php if(old('u_id') == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
              <?php endforeach; ?>
            </select>
            <span class="error-input"><?php if($errors->first('u_id')): ?> <?php echo $errors->first('u_id'); ?> <?php endif; ?></span>
          </td>
        </tr>

        <!-- xray_cat -->
        <tr>
          <td class="col-title">区分</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_cat_1" type="checkbox" value="1" <?php if(old('xray_cat_1') == 1): ?> checked="" <?php endif; ?>>A_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_5" type="checkbox" value="1" <?php if(old('xray_cat_5') == 1): ?> checked="" <?php endif; ?>>C_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_9"  type="checkbox" value="1" <?php if(old('xray_cat_9') == 1): ?> checked="" <?php endif; ?>>10G_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_13"  type="checkbox" value="1" <?php if(old('xray_cat_13') == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_cat_2" type="checkbox" value="1" <?php if(old('xray_cat_2') == 1): ?> checked="" <?php endif; ?>>A_stage F</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_6" type="checkbox" value="1" <?php if(old('xray_cat_6') == 1): ?> checked="" <?php endif; ?>>D_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_10" type="checkbox" value="1" <?php if(old('xray_cat_10') == 1): ?> checked="" <?php endif; ?>>Ope前</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_14" type="checkbox" value="1" <?php if(old('xray_cat_14') == 1): ?> checked="" <?php endif; ?>>オクルーザル</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_cat_3" type="checkbox" value="1" <?php if(old('xray_cat_3') == 1): ?> checked="" <?php endif; ?>>B_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_7" type="checkbox" value="1" <?php if(old('xray_cat_7') == 1): ?> checked="" <?php endif; ?>>G_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_11" type="checkbox" value="1" <?php if(old('xray_cat_11') == 1): ?> checked="" <?php endif; ?>>Ope後</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_15" type="checkbox" value="1" <?php if(old('xray_cat_15') == 1): ?> checked="" <?php endif; ?>>矯正終了</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_cat_4" type="checkbox" value="1" <?php if(old('xray_cat_4') == 1): ?> checked="" <?php endif; ?>>B_stage F</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_8" type="checkbox" value="1" <?php if(old('xray_cat_8') == 1): ?> checked="" <?php endif; ?>>5G_stage</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_12" type="checkbox" value="1" <?php if(old('xray_cat_12') == 1): ?> checked="" <?php endif; ?>>経過</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_16" type="checkbox" value="1" <?php if(old('xray_cat_16') == 1): ?> checked="" <?php endif; ?>>その他</label>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_kind -->
        <tr>
          <td class="col-title">種類</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_kind_1" type="checkbox" value="1" <?php if(old('xray_kind_1') == 1): ?> checked="" <?php endif; ?>>パノラマ</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_kind_5" type="checkbox" value="1" <?php if(old('xray_kind_5') == 1): ?> checked="" <?php endif; ?>>オクルーザル左</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_kind_9" type="checkbox" value="1" <?php if(old('xray_kind_9') == 1): ?> checked="" <?php endif; ?>>その他</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_kind_2" type="checkbox" value="1" <?php if(old('xray_kind_2') == 1): ?> checked="" <?php endif; ?>>セファロ側</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_kind_6" type="checkbox" value="1" <?php if(old('xray_kind_6') == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_kind_3" type="checkbox" value="1" <?php if(old('xray_kind_3') == 1): ?> checked="" <?php endif; ?>>セファロ正</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_kind_7" type="checkbox" value="1" <?php if(old('xray_kind_7') == 1): ?> checked="" <?php endif; ?>>顔写真</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_kind_4" type="checkbox" value="1" <?php if(old('xray_kind_4') == 1): ?> checked="" <?php endif; ?>>オクルーザル右</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_kind_8" type="checkbox" value="1" <?php if(old('xray_kind_8') == 1): ?> checked="" <?php endif; ?>>手根骨</label>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_memo 1 -->
        <tr>
          <td class="col-title">備考1</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_memo_1" type="checkbox" value="1" <?php if(old('xray_memo_1') == 1): ?> checked="" <?php endif; ?>>CD-R</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_memo_5" type="checkbox" value="1" <?php if(old('xray_memo_5') == 1): ?> checked="" <?php endif; ?>>2回撮影</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_memo_2" type="checkbox" value="1" <?php if(old('xray_memo_2') == 1): ?> checked="" <?php endif; ?>>Dr.S</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_memo_6" type="checkbox" value="1" <?php if(old('xray_memo_6') == 1): ?> checked="" <?php endif; ?>>再治療</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_memo_3" type="checkbox" value="1" <?php if(old('xray_memo_3') == 1): ?> checked="" <?php endif; ?>>蓋裂</label>
                </div>
                <div class="checkbox">
                  <label><input name="xray_memo_7" type="checkbox" value="1" <?php if(old('xray_memo_7') == 1): ?> checked="" <?php endif; ?>>転院</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <label><input name="xray_memo_4" type="checkbox" value="1" <?php if(old('xray_memo_4') == 1): ?> checked="" <?php endif; ?>>過剰歯</label>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_memo -->
        <tr>
          <td class="col-title">備考2</td>
          <td>
            <textarea name="xray_memo" id="xray_memo" cols="60" rows="3" class="form-control"><?php echo e(old('xray_memo')); ?></textarea>
          </td>
        </tr>
      </table>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
<?php echo Form::close(); ?>


<script>
  $(document).ready(function(){
      var val = $('#month').find("option:selected").val();
      if ( val != 0) {
        getVal(val);
      }
  });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>