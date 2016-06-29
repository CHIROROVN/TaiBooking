@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic service regist -->
    <section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>医院情報管理　＞　たい矯正歯科　＞　業務自動枠の一覧　＞　リンガルrem　＞　使用設備と時間の新規登録</h3>
            <div class="table-responsive">
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="cbEquipment">使用する設備-1</label></td>
                  <td>
                    <input type="radio" name="radio" id="radio" value="radio">
                    治療（チェア）　　　
                    <input type="radio" name="radio2" id="radio2" value="radio2">
                    治療以外→
<select name="select" id="cbEquipment" class="form-control form-control--small">
                <option>▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="cbTime">時間-1</label></td>
                  <td>
                    <select name="select2" id="cbTime" class="form-control form-control--small">
                      <option selected="selected">15分</option>
                      <option>30分</option>
                      <option>45分</option>
                      <option>60分</option>
                      <option>75分</option>
                      <option>90分</option>
                      <option>105分</option>
                      <option>120分</option>
                    </select>
                  </td>
                </tr>
              </table>
              <br />
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="cbEquipment">使用する設備-2</label></td>
                  <td>
                    <input type="radio" name="radio" id="radio" value="radio">
                    治療（チェア）　　　
                    <input type="radio" name="radio2" id="radio2" value="radio2">
                    治療以外→
<select name="select" id="cbEquipment" class="form-control form-control--small">
                <option>▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="cbTime">時間-2</label></td>
                  <td>
                    <select name="select2" id="cbTime" class="form-control form-control--small">
                      <option selected="selected">15分</option>
                      <option>30分</option>
                      <option>45分</option>
                      <option>60分</option>
                      <option>75分</option>
                      <option>90分</option>
                      <option>105分</option>
                      <option>120分</option>
                    </select>
                  </td>
                </tr>
              </table>
              <br />
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="cbEquipment">使用する設備-3</label></td>
                  <td>
                    <input type="radio" name="radio" id="radio" value="radio">
                    治療（チェア）　　　
                    <input type="radio" name="radio2" id="radio2" value="radio2">
                    治療以外→
<select name="select" id="cbEquipment" class="form-control form-control--small">
                <option>▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="cbTime">時間-3</label></td>
                  <td>
                    <select name="select2" id="cbTime" class="form-control form-control--small">
                      <option selected="selected">15分</option>
                      <option>30分</option>
                      <option>45分</option>
                      <option>60分</option>
                      <option>75分</option>
                      <option>90分</option>
                      <option>105分</option>
                      <option>120分</option>
                    </select>
                  </td>
                </tr>
              </table>
              <br />
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="cbEquipment">使用する設備-4</label></td>
                  <td>
                    <input type="radio" name="radio" id="radio" value="radio">
                    治療（チェア）　　　
                    <input type="radio" name="radio2" id="radio2" value="radio2">
                    治療以外→
<select name="select" id="cbEquipment" class="form-control form-control--small">
                <option>▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="cbTime">時間-4</label></td>
                  <td>
                    <select name="select2" id="cbTime" class="form-control form-control--small">
                      <option selected="selected">15分</option>
                      <option>30分</option>
                      <option>45分</option>
                      <option>60分</option>
                      <option>75分</option>
                      <option>90分</option>
                      <option>105分</option>
                      <option>120分</option>
                    </select>
                  </td>
                </tr>
              </table>
              <br />
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="cbEquipment">使用する設備-5</label></td>
                  <td>
                    <input type="radio" name="radio" id="radio" value="radio">
                    治療（チェア）　　　
                    <input type="radio" name="radio2" id="radio2" value="radio2">
                    治療以外→
<select name="select" id="cbEquipment" class="form-control form-control--small">
                <option>▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title"><label for="cbTime">時間-5</label></td>
                  <td>
                    <select name="select2" id="cbTime" class="form-control form-control--small">
                      <option selected="selected">15分</option>
                      <option>30分</option>
                      <option>45分</option>
                      <option>60分</option>
                      <option>75分</option>
                      <option>90分</option>
                      <option>105分</option>
                      <option>120分</option>
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
            <input type="button" onClick="location.href='{{route('ortho.facilities.index',[$clinic_id])}}'" value="登録済み自動枠の構成一覧に戻るQQQ" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
  <!-- End content clinic service regist -->
@endsection