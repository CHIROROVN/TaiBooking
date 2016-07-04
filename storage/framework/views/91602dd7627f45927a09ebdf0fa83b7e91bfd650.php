<?php $__env->startSection('content'); ?>
	<!-- Content clinic service regist -->
    <section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>医院情報管理　＞　たい矯正歯科　＞　業務自動枠の一覧　＞　リンガルrem　＞　使用設備と時間の新規登録</h3>
            <div class="table-responsive">
            <?php echo Form::open( ['id' => 'frmClinicServiceRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.clinics.services.template_regist', $clinic_id, $service_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']); ?>

              <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_1">使用する設備-1</label></td>
              <td>
                <input type="radio" name="service_facility_1_chair" id="service_facility_1_chair" value="-1" checked >
                治療（チェア）　　　
                <input type="radio" name="service_facility_1_chair" id="service_facility_1_other" value="1" <?php if(old('service_facility_1_chair') == '1'): ?> checked <?php endif; ?> >
                治療以外→
                <select name="service_facility_1" id="service_facility_1" class="form-control form-control--small sf1">
                  <option value="" selected="selected">▼選択</option>
                  <?php if($facilities): ?>
                    <?php foreach($facilities as $key1 => $facility1): ?>
                      <option value="<?php echo e($key1); ?>" <?php if(old('service_facility_1') == $key1): ?> selected="selected" <?php endif; ?>><?php echo e($facility1); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php if($errors->first('service_facility_1')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_facility_1'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_1">時間-1</label></td>
              <td>
                <select name="service_time_1" id="service_time_1" class="form-control form-control--small">
                  <option value="15" <?php if(old('service_time_1') == '15'): ?> selected="selected" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('service_time_1') == '30'): ?> selected="selected" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('service_time_1') == '45'): ?> selected="selected" <?php endif; ?>>45分</option>
                  <option value="60" <?php if(old('service_time_1') == '60'): ?> selected="selected" <?php endif; ?>>60分</option>
                  <option value="75" <?php if(old('service_time_1') == '75'): ?> selected="selected" <?php endif; ?>>75分</option>
                  <option value="90" <?php if(old('service_time_1') == '90'): ?> selected="selected" <?php endif; ?>>90分</option>
                  <option value="105" <?php if(old('service_time_1') == '105'): ?> selected="selected" <?php endif; ?>>105分</option>
                  <option value="120" <?php if(old('service_time_1') == '120'): ?> selected="selected" <?php endif; ?>>120分</option>
                </select>
              </td>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_2">使用する設備-2</label></td>
              <td>
                <input type="radio" name="service_facility_2_chair" id="service_facility_2_chair" value="-1" checked >
                治療（チェア）　　　
                <input type="radio" name="service_facility_2_chair" id="service_facility_2_other" value="1" <?php if(old('service_facility_2_chair') == '1'): ?> checked <?php endif; ?> >
                治療以外→
                <select name="service_facility_2" id="service_facility_2" class="form-control form-control--small sf2">
                  <option value="" selected="selected">▼選択</option>
                  <?php if($facilities): ?>
                    <?php foreach($facilities as $key2 => $facility2): ?>
                      <option value="<?php echo e($key2); ?>" <?php if(old('service_facility_2') == $key2): ?> selected="selected" <?php endif; ?>><?php echo e($facility2); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php if($errors->first('service_facility_2')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_facility_2'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_2">時間-2</label></td>
              <td>
                <select name="service_time_2" id="service_time_2" class="form-control form-control--small">
                  <option value="15" <?php if(old('service_time_2') == '15'): ?> selected="selected" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('service_time_2') == '30'): ?> selected="selected" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('service_time_2') == '45'): ?> selected="selected" <?php endif; ?>>45分</option>
                  <option value="60" <?php if(old('service_time_2') == '60'): ?> selected="selected" <?php endif; ?>>60分</option>
                  <option value="75" <?php if(old('service_time_2') == '75'): ?> selected="selected" <?php endif; ?>>75分</option>
                  <option value="90" <?php if(old('service_time_2') == '90'): ?> selected="selected" <?php endif; ?>>90分</option>
                  <option value="105" <?php if(old('service_time_2') == '105'): ?> selected="selected" <?php endif; ?>>105分</option>
                  <option value="120" <?php if(old('service_time_2') == '120'): ?> selected="selected" <?php endif; ?>>120分</option>
                </select>
              </td>
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_3">使用する設備-3</label></td>
              <td>
                <input type="radio" name="service_facility_3_chair" id="service_facility_3_chair" value="-1" checked >
                治療（チェア）　　　
                <input type="radio" name="service_facility_3_chair" id="service_facility_3_other" value="1" <?php if(old('service_facility_3_chair') == '1'): ?> checked <?php endif; ?> >
                治療以外→
                <select name="service_facility_3" id="service_facility_3" class="form-control form-control--small sf3">
                  <option value="" selected="selected">▼選択</option>
                  <?php if($facilities): ?>
                    <?php foreach($facilities as $key3 => $facility3): ?>
                      <option value="<?php echo e($key3); ?>" <?php if(old('service_facility_3') == $key3): ?> selected="selected" <?php endif; ?>><?php echo e($facility3); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php if($errors->first('service_facility_3')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_facility_3'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_3">時間-3</label></td>
              <td>
                <select name="service_time_3" id="service_time_3" class="form-control form-control--small">
                  <option value="15" <?php if(old('service_time_3') == '15'): ?> selected="selected" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('service_time_3') == '30'): ?> selected="selected" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('service_time_3') == '45'): ?> selected="selected" <?php endif; ?>>45分</option>
                  <option value="60" <?php if(old('service_time_3') == '60'): ?> selected="selected" <?php endif; ?>>60分</option>
                  <option value="75" <?php if(old('service_time_3') == '75'): ?> selected="selected" <?php endif; ?>>75分</option>
                  <option value="90" <?php if(old('service_time_3') == '90'): ?> selected="selected" <?php endif; ?>>90分</option>
                  <option value="105" <?php if(old('service_time_3') == '105'): ?> selected="selected" <?php endif; ?>>105分</option>
                  <option value="120" <?php if(old('service_time_3') == '120'): ?> selected="selected" <?php endif; ?>>120分</option>
                </select>
              </td>
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_4">使用する設備-4</label></td>
              <td>
                <input type="radio" name="service_facility_4_chair" id="service_facility_4_chair" value="-1" checked >
                治療（チェア）　　　
                <input type="radio" name="service_facility_4_chair" id="service_facility_4_other" value="1" <?php if(old('service_facility_4_chair') == '1'): ?> checked <?php endif; ?>>
                治療以外→
                <select name="service_facility_4" id="service_facility_4" class="form-control form-control--small sf4">
                  <option value="" selected="selected">▼選択</option>
                  <?php if($facilities): ?>
                    <?php foreach($facilities as $key4 => $facility4): ?>
                      <option value="<?php echo e($key4); ?>" <?php if(old('service_facility_4') == $key4): ?> selected="selected" <?php endif; ?>><?php echo e($facility4); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php if($errors->first('service_facility_4')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_facility_4'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_4">時間-4</label></td>
              <td>
                <select name="service_time_4" id="service_time_4" class="form-control form-control--small">
                  <option value="15" <?php if(old('service_time_4') == '15'): ?> selected="selected" <?php endif; ?>>15分</option>
                  <option value="30" <?php if(old('service_time_4') == '30'): ?> selected="selected" <?php endif; ?>>30分</option>
                  <option value="45" <?php if(old('service_time_4') == '45'): ?> selected="selected" <?php endif; ?>>45分</option>
                  <option value="60" <?php if(old('service_time_4') == '60'): ?> selected="selected" <?php endif; ?>>60分</option>
                  <option value="75" <?php if(old('service_time_4') == '75'): ?> selected="selected" <?php endif; ?>>75分</option>
                  <option value="90" <?php if(old('service_time_4') == '90'): ?> selected="selected" <?php endif; ?>>90分</option>
                  <option value="105" <?php if(old('service_time_4') == '105'): ?> selected="selected" <?php endif; ?>>105分</option>
                  <option value="120" <?php if(old('service_time_4') == '120'): ?> selected="selected" <?php endif; ?>>120分</option>
                </select>
              </td>
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_5">使用する設備-5</label></td>
              <td>
                <input type="radio" name="service_facility_5_chair" id="service_facility_5_chair" value="-1" checked >
                治療（チェア）　　　
                <input type="radio" name="service_facility_5_chair" id="service_facility_5_other" value="1" <?php if(old('service_facility_5_chair') == '1'): ?> checked <?php endif; ?> >
                治療以外→
                <select name="service_facility_5" id="service_facility_5" class="form-control form-control--small sf5">
                  <option value="" selected="selected">▼選択</option>
                  <?php if($facilities): ?>
                    <?php foreach($facilities as $key5 => $facility5): ?>
                      <option value="<?php echo e($key5); ?>" <?php if(old('service_facility_5') == $key5): ?> selected="selected" <?php endif; ?>><?php echo e($facility5); ?></option>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </select>
                <?php if($errors->first('service_facility_5')): ?>
                    <span class="error-input">※ <?php echo $errors->first('service_facility_5'); ?></span>
                <?php endif; ?>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_5">時間-5</label></td>
            <td>
            <select name="service_time_5" id="service_time_5" class="form-control form-control--small">
              <option value="15" <?php if(old('service_time_5') == '15'): ?> selected="selected" <?php endif; ?>>15分</option>
              <option value="30" <?php if(old('service_time_5') == '30'): ?> selected="selected" <?php endif; ?>>30分</option>
              <option value="45" <?php if(old('service_time_5') == '45'): ?> selected="selected" <?php endif; ?>>45分</option>
              <option value="60" <?php if(old('service_time_5') == '60'): ?> selected="selected" <?php endif; ?>>60分</option>
              <option value="75" <?php if(old('service_time_5') == '75'): ?> selected="selected" <?php endif; ?>>75分</option>
              <option value="90" <?php if(old('service_time_5') == '90'): ?> selected="selected" <?php endif; ?>>90分</option>
              <option value="105" <?php if(old('service_time_5') == '105'): ?> selected="selected" <?php endif; ?>>105分</option>
              <option value="120" <?php if(old('service_time_5') == '120'): ?> selected="selected" <?php endif; ?>>120分</option>
            </select>
          </td>
        </tr>
      </table>
              <br />
            </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="submit" name="button" id="button" value="登録する" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onClick="location.href='<?php echo e(route('ortho.facilities.index',[$clinic_id])); ?>'" value="登録済み自動枠の構成一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
        <?php echo Form::close(); ?>

      </div>
    </section>
  <!-- End content clinic service regist -->

  <script type="text/javascript">
    $('.sf1').click(function(event) {
      $("#service_facility_1_other").prop("checked", true); 
    });
    $('.sf2').click(function(event) {
      $("#service_facility_2_other").prop("checked", true); 
    });
    $('.sf3').click(function(event) {
      $("#service_facility_3_other").prop("checked", true); 
    });
    $('.sf4').click(function(event) {
      $("#service_facility_4_other").prop("checked", true); 
    });
    $('.sf5').click(function(event) {
      $("#service_facility_5_other").prop("checked", true); 
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>