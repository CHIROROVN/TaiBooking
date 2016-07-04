<?php $__env->startSection('content'); ?>

<?php echo Form::open(array('route' => 'ortho.bookings.booking.1st.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')); ?>

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　新患予約の新規登録</h3>
        <div class="table-responsive">
          <table class="table table-bordered">

            <!-- p_name -->
            <tr>
              <td class="col-title"><label for="p_name">患者名</label></td>
              <td><input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo e(old('p_name')); ?>" /></td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_kana">患者名よみ</label></td>
              <td><input type="text" name="p_name_kana" id="p_name_kana" class="form-control" value="<?php echo e(old('p_name_kana')); ?>" /></td>
            </tr>

            <!-- p_sex -->
            <tr>
              <td class="col-title">性別</td>
              <td>
                <div class="row">
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="1" <?php if(old('p_sex') == 1): ?> checked="" <?php endif; ?> /> 男
                  </div>
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="2" <?php if(old('p_sex') == 2): ?> checked="" <?php endif; ?> /> 女
                  </div>
                </div>
              </td>
            </tr>

            <!-- p_tel -->
            <tr>
              <td class="col-title"><label for="p_tel">電話番号</label></td>
              <td><input type="text" name="p_tel" id="p_tel" class="form-control" value="<?php echo e(old('p_tel')); ?>" /></td>
            </tr>

            <!-- if check -> insert to table "t_1st" -->
            <tr>
              <td class="col-title"><label for="insert_to_tbl_first">問診票の入力</label></td>
              <td>
                <div class="checkbox">
                  <label><input type="checkbox" name="insert_to_tbl_first" id="insert_to_tbl_first" value="1" <?php if(old('insert_to_tbl_first') == 1): ?> checked="" <?php endif; ?> />初診者一覧にも自動登録（＝問診票の新規登録）</label>
                </div>
              </td>
            </tr>

            <!-- booking_date -->
            <tr>
              <td class="col-title"><label for="cbReservation">予約日時</label></td>
              <td>2016年6月15日(水)　10:00～11:30
              </td>
            </tr>

            <!-- clinic_id -->
            <tr>
              <td class="col-title">医院</td>
              <td>たい矯正歯科</td>
            </tr>

            <!-- facility_id -->
            <tr>
              <td class="col-title"><label for="facility_id">設備</label></td>
              <td>
                <select name="facility_id" id="facility_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- doctor_id -->
            <tr>
              <td class="col-title"><label for="doctor_id">ドクター</label></td>
              <td>
                <select name="doctor_id" id="doctor_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- hygienist_id -->
            <tr>
              <td class="col-title"><label for="hygienist_id">衛生士</label></td>
              <td>
                <select name="hygienist_id" id="hygienist_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- equipment_id -->
            <tr>
              <td class="col-title"><label for="equipment_id">装置</label></td>
              <td>
                <select name="equipment_id" id="equipment_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

              <!-- service_1 -->
            <tr>
              <td class="col-title"><label for="cbTreatContent1">業務内容-1</label></td>
              <td>
                <select name="cbTreatContent1" id="cbTreatContent1" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- service_2 -->
            <tr>
              <td class="col-title"><label for="cbTreatContent2">業務内容-2</label></td>
              <td>
                <select name="cbTreatContent2" id="cbTreatContent2" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- inspection_id -->
            <tr>
              <td class="col-title"><label for="inspection_id">検査</label></td>
              <td>
                <select name="inspection_id" id="inspection_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

            <!-- insurance_id -->
            <tr>
              <td class="col-title"><label for="insurance_id">保険診療</label></td>
              <td>
                <select name="insurance_id" id="insurance_id" class="form-control">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>

              <!-- emergency_flag -->
            <tr>
              <td class="col-title"><label for="emergency_flag">救急</label></td>
              <td>
                <div class="checkbox">
                  <label><input name="emergency_flag" value="1" type="checkbox" id="emergency_flag">救急です</label>
                </div>
              </td>
            </tr>

              <!-- booking_status -->
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>
                <div class="radio">
                  <label><input name="booking_status" value="1" type="radio">通常</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="2" type="radio">「TEL待ち」です</label>
                </div>
                <div class="radio">
                  <label>
                    <input name="booking_status" value="3" type="radio">「リコール」です→

                    <!-- booking_recall_ym -->
                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--sm">
                      <option selected="selected">▼選択</option>
                      <option>1ヶ月後</option>
                      <option>2ヶ月後</option>
                      <option>3ヶ月後</option>
                      <option>4ヶ月後</option>
                      <option>5ヶ月後</option>
                      <option>6ヶ月後</option>
                    </select>
                  </label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="4" type="radio">未作成技工物TEL待ち</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="5" type="radio">作成済み技工物キャンセル</label>
                </div>
              </td>
            </tr>

            <!-- booking_memo -->
            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control"><?php echo e(old('booking_memo')); ?></textarea></td>
            </tr>
          </table>
        </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="history.back()" value="前の画面に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>