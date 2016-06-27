@extends('backend.ortho.ortho')

@section('content')
	<!-- Content treatment 1 list -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　登録済み治療内容の一覧</h3>
      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='treatment1_regist.html'">
        </div>
      </div>
      <table class="table table-bordered table-striped treatment2-list">
        <tbody>
          <tr>
              <td align="center" class="col-title">治療内容</td>
              <td align="center" class="col-title">時間</td>
              <td align="center" class="col-title col-edit">編集</td>
              <td colspan="4" align="center" class="col-title col-action">表示順序</td>
            </tr>
            <tr>
              <td>なし</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button class="hidden">TOP</button></td>
              <td align="center" class=""><button class="hidden">↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>ch</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>SET</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>imp</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>rem</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>即日set</td>
              <td>60分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button>↓</button></td>
              <td align="center" class=""><button>LAST</button></td>
            </tr>
            <tr>
              <td>adv</td>
              <td>15分</td>
              <td align="center"><a href="treatment1_edit.html" class="btn btn-sm btn-edit">編集</a></td>
              <td align="center"><button>TOP</button></td>
              <td align="center" class=""><button>↑</button></td>
              <td align="center"><button class="hidden">↓</button></td>
              <td align="center" class=""><button class="hidden">LAST</button></td>
            </tr>
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='treatment1_regist.html'">
        </div>
      </div>
    </div>
  <!-- End content treatment 1 list -->
@endsection