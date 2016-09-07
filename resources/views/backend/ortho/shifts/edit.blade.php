@extends('backend.ortho.ortho')

@section('content')
	  <!-- Content shift edit -->
  <section id="page">
    <div class="container">
      <div class="row content-page content--patient-brother">
        <h3>シフト管理　＞　シフトの編集</h3>
          <div class="table-responsive">
            <table class="table table-bordered">
              <tr>
                <td class="col-title">日付</td>
                <td>
                  <span class="mar-right">2016年5月1日(日)</span>
                  <div class="checkbox">
                    <label><input type="checkbox" name="checkbox" value="checkbox" />午前のみ　　　</label>
                  </div>
                  <div class="checkbox">
                    <label><input type="checkbox" name="checkbox" value="checkbox" />午後のみ　　　　　</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td class="col-title">メンバー</td>
                <td>杉元　俊彦</td>
              </tr>
              <tr>
                <td class="col-title"><label for="cbClinic">医院</label></td>
                <td>
                  <select name="cbClinic" id="cbClinic" class="form-control form-control--small">
                    <option>▼選択</option>
                  </select>
                </td>
               </tr>
            </table>
          </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button" id="button" value="変更内容を保存する" type="submit" class="btn btn-sm btn-page mar-right">
          <input name="button2" id="button2" value="削除する" type="submit" class="btn btn-sm btn-page">
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="history.back()" value="元の画面に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  <!-- End content shift edit -->
@endsection