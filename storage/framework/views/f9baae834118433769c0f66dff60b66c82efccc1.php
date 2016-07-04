<?php $__env->startSection('content'); ?>

<script>
  function getVal(val) {
    var month = '';
    var old_day = "<?php echo (old('xray_date_day')) ? old('xray_date_day') : date('d', strtotime($xray->xray_date)); ?>";
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

<?php echo Form::open(array('route' => ['ortho.xrays.edit', $xray->xray_id], 'enctype'=>'multipart/form-data')); ?>

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
              <?php if( old('xray_date_year') ): ?>
              <option value="<?php echo e($year_prev); ?>" <?php if(old('xray_date_year') == $year_prev): ?> selected="" <?php endif; ?>><?php echo e($year_prev); ?>年</option>
              <option value="<?php echo e($year_now); ?>" <?php if(old('xray_date_year') == $year_now): ?> selected="" <?php endif; ?>><?php echo e($year_now); ?>年</option>
              <option value="<?php echo e($year_next); ?>" <?php if(old('xray_date_year') == $year_next): ?> selected="" <?php endif; ?>><?php echo e($year_next); ?>年</option>
              <?php else: ?>
              <option value="<?php echo e($year_prev); ?>" <?php if(date('Y', strtotime($xray->xray_date)) == $year_prev): ?> selected="" <?php endif; ?>><?php echo e($year_prev); ?>年</option>
              <option value="<?php echo e($year_now); ?>" <?php if(date('Y', strtotime($xray->xray_date)) == $year_now): ?> selected="" <?php endif; ?>><?php echo e($year_now); ?>年</option>
              <option value="<?php echo e($year_next); ?>" <?php if(date('Y', strtotime($xray->xray_date)) == $year_next): ?> selected="" <?php endif; ?>><?php echo e($year_next); ?>年</option>
              <?php endif; ?>
            </select>
            <select name="xray_date_month" class="form-control form-control--small" id="month" onchange="getVal(this);">
              <option value="0">--月</option>
              <?php for( $i = 1; $i <= 12; $i++ ): ?>
                <?php if( old('xray_date_month') ): ?>
                <option value="<?php echo e($i); ?>" <?php if(old('xray_date_month') == $i): ?> selected="" <?php endif; ?>><?php echo e($i); ?>月</option>
                <?php else: ?>
                <option value="<?php echo e($i); ?>" <?php if(date('m', strtotime($xray->xray_date)) == $i): ?> selected="" <?php endif; ?>><?php echo e($i); ?>月</option>
                <?php endif; ?>
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
                <?php if( old('xray_place') ): ?>
                <option value="<?php echo e($clinic->clinic_id); ?>" <?php if(old('xray_place') == $clinic->clinic_id): ?> selected="" <?php endif; ?>><?php echo e($clinic->clinic_name); ?></option>
                <?php else: ?>
                <option value="<?php echo e($clinic->clinic_id); ?>" <?php if($xray->xray_place == $clinic->clinic_id): ?> selected="" <?php endif; ?>><?php echo e($clinic->clinic_name); ?></option>
                <?php endif; ?>
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
                <?php if( old('u_id') ): ?>
                <option value="<?php echo e($user->id); ?>" <?php if(old('u_id') == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
                <?php else: ?>
                <option value="<?php echo e($user->id); ?>" <?php if($xray->u_id == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
                <?php endif; ?>
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
                  <?php if( old('xray_cat_1') ): ?>
                  <label><input name="xray_cat_1" type="checkbox" value="1" <?php if(old('xray_cat_1') == 1): ?> checked="" <?php endif; ?>>A_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_1" type="checkbox" value="1" <?php if($xray->xray_cat_1 == 1): ?> checked="" <?php endif; ?>>A_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_5') ): ?>
                  <label><input name="xray_cat_5" type="checkbox" value="1" <?php if(old('xray_cat_5') == 1): ?> checked="" <?php endif; ?>>C_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_5" type="checkbox" value="1" <?php if($xray->xray_cat_5 == 1): ?> checked="" <?php endif; ?>>C_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_9') ): ?>
                  <label><input name="xray_cat_9"  type="checkbox" value="1" <?php if(old('xray_cat_9') == 1): ?> checked="" <?php endif; ?>>10G_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_9"  type="checkbox" value="1" <?php if($xray->xray_cat_9 == 1): ?> checked="" <?php endif; ?>>10G_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_13') ): ?>
                  <label><input name="xray_cat_13"  type="checkbox" value="1" <?php if(old('xray_cat_13') == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                  <?php else: ?>
                  <label><input name="xray_cat_13"  type="checkbox" value="1" <?php if($xray->xray_cat_13 == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_cat_2') ): ?>
                  <label><input name="xray_cat_2" type="checkbox" value="1" <?php if(old('xray_cat_2') == 1): ?> checked="" <?php endif; ?>>A_stage F</label>
                  <?php else: ?>
                  <label><input name="xray_cat_2" type="checkbox" value="1" <?php if($xray->xray_cat_2 == 1): ?> checked="" <?php endif; ?>>A_stage F</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_6') ): ?>
                  <label><input name="xray_cat_6" type="checkbox" value="1" <?php if(old('xray_cat_6') == 1): ?> checked="" <?php endif; ?>>D_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_6" type="checkbox" value="1" <?php if($xray->xray_cat_6 == 1): ?> checked="" <?php endif; ?>>D_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_10') ): ?>
                  <label><input name="xray_cat_10" type="checkbox" value="1" <?php if(old('xray_cat_10') == 1): ?> checked="" <?php endif; ?>>Ope前</label>
                  <?php else: ?>
                  <label><input name="xray_cat_10" type="checkbox" value="1" <?php if($xray->xray_cat_10 == 1): ?> checked="" <?php endif; ?>>Ope前</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <label><input name="xray_cat_14" type="checkbox" value="1" <?php if(old('xray_cat_14') == 1): ?> checked="" <?php endif; ?>>オクルーザル</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_cat_3') ): ?>
                  <label><input name="xray_cat_3" type="checkbox" value="1" <?php if(old('xray_cat_3') == 1): ?> checked="" <?php endif; ?>>B_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_3" type="checkbox" value="1" <?php if($xray->xray_cat_3 == 1): ?> checked="" <?php endif; ?>>B_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_7') ): ?>
                  <label><input name="xray_cat_7" type="checkbox" value="1" <?php if(old('xray_cat_7') == 1): ?> checked="" <?php endif; ?>>G_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_7" type="checkbox" value="1" <?php if($xray->xray_cat_7 == 1): ?> checked="" <?php endif; ?>>G_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_11') ): ?>
                  <label><input name="xray_cat_11" type="checkbox" value="1" <?php if(old('xray_cat_11') == 1): ?> checked="" <?php endif; ?>>Ope後</label>
                  <?php else: ?>
                  <label><input name="xray_cat_11" type="checkbox" value="1" <?php if($xray->xray_cat_11 == 1): ?> checked="" <?php endif; ?>>Ope後</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_15') ): ?>
                  <label><input name="xray_cat_15" type="checkbox" value="1" <?php if(old('xray_cat_15') == 1): ?> checked="" <?php endif; ?>>矯正終了</label>
                  <?php else: ?>
                  <label><input name="xray_cat_15" type="checkbox" value="1" <?php if($xray->xray_cat_15 == 1): ?> checked="" <?php endif; ?>>矯正終了</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_cat_4') ): ?>
                  <label><input name="xray_cat_4" type="checkbox" value="1" <?php if(old('xray_cat_4') == 1): ?> checked="" <?php endif; ?>>B_stage F</label>
                  <?php else: ?>
                  <label><input name="xray_cat_4" type="checkbox" value="1" <?php if($xray->xray_cat_4 == 1): ?> checked="" <?php endif; ?>>B_stage F</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_8') ): ?>
                  <label><input name="xray_cat_8" type="checkbox" value="1" <?php if(old('xray_cat_8') == 1): ?> checked="" <?php endif; ?>>5G_stage</label>
                  <?php else: ?>
                  <label><input name="xray_cat_8" type="checkbox" value="1" <?php if($xray->xray_cat_8 == 1): ?> checked="" <?php endif; ?>>5G_stage</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_12') ): ?>
                  <label><input name="xray_cat_12" type="checkbox" value="1" <?php if(old('xray_cat_12') == 1): ?> checked="" <?php endif; ?>>経過</label>
                  <?php else: ?>
                  <label><input name="xray_cat_12" type="checkbox" value="1" <?php if($xray->xray_cat_12 == 1): ?> checked="" <?php endif; ?>>経過</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_cat_16') ): ?>
                  <label><input name="xray_cat_16" type="checkbox" value="1" <?php if(old('xray_cat_16') == 1): ?> checked="" <?php endif; ?>>その他</label>
                  <?php else: ?>
                  <label><input name="xray_cat_16" type="checkbox" value="1" <?php if($xray->xray_cat_16 == 1): ?> checked="" <?php endif; ?>>その他</label>
                  <?php endif; ?>
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
                  <?php if( old('xray_kind_1') ): ?>
                  <label><input name="xray_kind_1" type="checkbox" value="1" <?php if(old('xray_kind_1') == 1): ?> checked="" <?php endif; ?>>パノラマ</label>
                  <?php else: ?>
                  <label><input name="xray_kind_1" type="checkbox" value="1" <?php if($xray->xray_kind_1 == 1): ?> checked="" <?php endif; ?>>パノラマ</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_kind_5') ): ?>
                  <label><input name="xray_kind_5" type="checkbox" value="1" <?php if(old('xray_kind_5') == 1): ?> checked="" <?php endif; ?>>オクルーザル左</label>
                  <?php else: ?>
                  <label><input name="xray_kind_5" type="checkbox" value="1" <?php if($xray->xray_kind_5 == 1): ?> checked="" <?php endif; ?>>オクルーザル左</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_kind_9') ): ?>
                  <label><input name="xray_kind_9" type="checkbox" value="1" <?php if(old('xray_kind_9') == 1): ?> checked="" <?php endif; ?>>その他</label>
                  <?php else: ?>
                  <label><input name="xray_kind_9" type="checkbox" value="1" <?php if($xray->xray_kind_9 == 1): ?> checked="" <?php endif; ?>>その他</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_kind_2') ): ?>
                  <label><input name="xray_kind_2" type="checkbox" value="1" <?php if(old('xray_kind_2') == 1): ?> checked="" <?php endif; ?>>セファロ側</label>
                  <?php else: ?>
                  <label><input name="xray_kind_2" type="checkbox" value="1" <?php if($xray->xray_kind_2 == 1): ?> checked="" <?php endif; ?>>セファロ側</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_kind_6') ): ?>
                  <label><input name="xray_kind_6" type="checkbox" value="1" <?php if(old('xray_kind_6') == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                  <?php else: ?>
                  <label><input name="xray_kind_6" type="checkbox" value="1" <?php if($xray->xray_kind_6 == 1): ?> checked="" <?php endif; ?>>デンタル</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_kind_3') ): ?>
                  <label><input name="xray_kind_3" type="checkbox" value="1" <?php if(old('xray_kind_3') == 1): ?> checked="" <?php endif; ?>>セファロ正</label>
                  <?php else: ?>
                  <label><input name="xray_kind_3" type="checkbox" value="1" <?php if($xray->xray_kind_3 == 1): ?> checked="" <?php endif; ?>>セファロ正</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_kind_7') ): ?>
                  <label><input name="xray_kind_7" type="checkbox" value="1" <?php if(old('xray_kind_7') == 1): ?> checked="" <?php endif; ?>>顔写真</label>
                  <?php else: ?>
                  <label><input name="xray_kind_7" type="checkbox" value="1" <?php if($xray->xray_kind_7 == 1): ?> checked="" <?php endif; ?>>顔写真</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_kind_4') ): ?>
                  <label><input name="xray_kind_4" type="checkbox" value="1" <?php if(old('xray_kind_4') == 1): ?> checked="" <?php endif; ?>>オクルーザル右</label>
                  <?php else: ?>
                  <label><input name="xray_kind_4" type="checkbox" value="1" <?php if($xray->xray_kind_4 == 1): ?> checked="" <?php endif; ?>>オクルーザル右</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_kind_8') ): ?>
                  <label><input name="xray_kind_8" type="checkbox" value="1" <?php if(old('xray_kind_8') == 1): ?> checked="" <?php endif; ?>>手根骨</label>
                  <?php else: ?>
                  <label><input name="xray_kind_8" type="checkbox" value="1" <?php if($xray->xray_kind_8 == 1): ?> checked="" <?php endif; ?>>手根骨</label>
                  <?php endif; ?>
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
                  <?php if( old('xray_memo_1') ): ?>
                  <label><input name="xray_memo_1" type="checkbox" value="1" <?php if(old('xray_memo_1') == 1): ?> checked="" <?php endif; ?>>CD-R</label>
                  <?php else: ?>
                  <label><input name="xray_memo_1" type="checkbox" value="1" <?php if($xray->xray_memo_1 == 1): ?> checked="" <?php endif; ?>>CD-R</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_memo_5') ): ?>
                  <label><input name="xray_memo_5" type="checkbox" value="1" <?php if(old('xray_memo_5') == 1): ?> checked="" <?php endif; ?>>2回撮影</label>
                  <?php else: ?>
                  <label><input name="xray_memo_5" type="checkbox" value="1" <?php if($xray->xray_memo_5 == 1): ?> checked="" <?php endif; ?>>2回撮影</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_memo_2') ): ?>
                  <label><input name="xray_memo_2" type="checkbox" value="1" <?php if(old('xray_memo_2') == 1): ?> checked="" <?php endif; ?>>Dr.S</label>
                  <?php else: ?>
                  <label><input name="xray_memo_2" type="checkbox" value="1" <?php if($xray->xray_memo_2 == 1): ?> checked="" <?php endif; ?>>Dr.S</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <?php if( old('xray_memo_6') ): ?>
                  <label><input name="xray_memo_6" type="checkbox" value="1" <?php if(old('xray_memo_6') == 1): ?> checked="" <?php endif; ?>>再治療</label>
                  <?php else: ?>
                  <label><input name="xray_memo_6" type="checkbox" value="1" <?php if($xray->xray_memo_6 == 1): ?> checked="" <?php endif; ?>>再治療</label>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_memo_3') ): ?>
                  <label><input name="xray_memo_3" type="checkbox" value="1" <?php if(old('xray_memo_3') == 1): ?> checked="" <?php endif; ?>>蓋裂</label>
                  <?php else: ?>
                  <label><input name="xray_memo_3" type="checkbox" value="1" <?php if($xray->xray_memo_3 == 1): ?> checked="" <?php endif; ?>>蓋裂</label>
                  <?php endif; ?>
                </div>
                <div class="checkbox">
                  <label><input name="xray_memo_7" type="checkbox" value="1" <?php if(old('xray_memo_7') == 1): ?> checked="" <?php endif; ?>>転院</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  <?php if( old('xray_memo_4') ): ?>
                  <label><input name="xray_memo_4" type="checkbox" value="1" <?php if(old('xray_memo_4') == 1): ?> checked="" <?php endif; ?>>過剰歯</label>
                  <?php else: ?>
                  <label><input name="xray_memo_4" type="checkbox" value="1" <?php if($xray->xray_memo_4 == 1): ?> checked="" <?php endif; ?>>過剰歯</label>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_memo -->
        <tr>
          <td class="col-title">備考2</td>
          <td>
            <?php if( old('xray_memo') ): ?>
            <textarea name="xray_memo" id="xray_memo" cols="60" rows="3" class="form-control"><?php echo e(old('xray_memo')); ?></textarea>
            <?php else: ?>
            <textarea name="xray_memo" id="xray_memo" cols="60" rows="3" class="form-control"><?php echo e($xray->xray_memo); ?></textarea>
            <?php endif; ?>
          </td>
        </tr>
      </table>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <!-- save -->
        <input name="" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
        <!-- delete -->
        <input type="button" value="削除" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal-<?php echo e($xray->xray_id); ?>"/>
          <!-- Modal -->
          <div class="modal fade" id="myModal-<?php echo e($xray->xray_id); ?>" role="dialog">
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
                  <a href="<?php echo e(route('ortho.xrays.delete', [ $xray->xray_id ])); ?>" class="btn btn-sm btn-page"><?php echo e(trans('common.modal_btn_delete')); ?></a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal"><?php echo e(trans('common.modal_btn_cancel')); ?></button>
                </div>
              </div>
            </div>
          </div>
          <!-- end Modal -->
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