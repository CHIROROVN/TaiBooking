@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic service template list -->
    <section id="page">
      <div class="container content-page">
      <h3>医院情報管理　＞　たい矯正歯科　＞　業務自動枠の一覧　＞　リンガルrem</h3>
      <div class="row">
          <div class="col-md-12 text-right">
            &nbsp;
          </div>
      </div>
      <table class="table table-bordered table-striped treatment2-list">
        <tbody>
          <tr>
              <td align="center" class="col-title">使用する設備名</td>
              <td align="center" class="col-title">時間</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
            <tr>
              <td>チェア（治療）</td>
              <td>30分</td>
              <td align="center"><a href="{{route('ortho.facilities.edit', [$clinic_id, 1])}}" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"></td>
              <td align="center" class=""></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>レントゲン</td>
              <td>15分</td>
              <td align="center"><a href="clinic_facility_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="submit" name="button" value="業務自動枠一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.clinics.services.index',[$clinic_id])}}'">
          </div>
        </div>
      </div>    
    </section>
    <!-- End content clinic service template list -->
@endsection