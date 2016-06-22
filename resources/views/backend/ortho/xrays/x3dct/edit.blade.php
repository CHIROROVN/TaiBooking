@extends('backend.ortho.ortho')

@section('content')
<!-- Content xray_3dct_regist -->
  <section id="page">
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
              <select name="select3" class="form-control form-control--small">
                <option>----年</option>
              </select>
              <select name="select3" class="form-control form-control--small">
                <option>--月</option>
              </select>
              <select name="select3" class="form-control form-control--small">
                <option>--日</option>
              </select>
              <img src="common/image/dummy-calendar.png" height="23" width="27">
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
          <input name="button" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  <!-- End content xray_3dct_regist -->
@endsection