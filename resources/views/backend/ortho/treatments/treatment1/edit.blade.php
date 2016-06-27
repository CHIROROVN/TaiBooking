@extends('backend.ortho.ortho')

@section('content')
	<!-- Content treatment1 regist -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　治療内容の新規登録</h3>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="texttreatname">治療内容</label></td>
            <td>
              <input class="form-control" type="text" name="txttreatname" id="texttreatname" />
            </td>
          </tr>
          <tr>
            <td class="col-title"><label for="texttreatname">時間</label></td>
            <td>
              <select>
                <option>15分</option>
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
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="submit" name="button" value="登録済み治療内容一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='treatment1_list.html'">
        </div>
      </div>
    </div>
  <!-- End content treatment1 regist -->
@endsection