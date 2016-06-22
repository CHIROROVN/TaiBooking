@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　患者の一覧　＞　放射線照射録の表示</h3>
    <table class="table table-bordered">
      <tbody>
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
      </tbody>
    </table>
    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼レントゲン
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='{{ route('ortho.xrays.regist') }}'" value="レントゲン新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">種類</td>
          <td align="center">撮影場所</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        <tr>
          <td>2016/05/01</td>
          <td>経過</td>
          <td>パノラマ <br />デンタル</td>
          <td>4F</td>
          <td>杉元　俊彦</td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/12/31</td>
          <td>B_stage</td>
          <td>パノラマ<br />セファロ側</td>
          <td>3F</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button5" id="button5" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/09/01</td>
          <td>経過</td>
          <td>パノラマ <br />デンタル</td>
          <td>4F</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼3D-CT
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='xray_3dct_regist.html'" value="3D-CT新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">モード</td>
          <td align="center">撮影条件</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        <tr>
          <td>2016/05/01</td>
          <td>3回目</td>
          <td>P</td>
          <td>120kv 10mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/12/31</td>
          <td>2回目</td>
          <td>P</td>
          <td>120kv 10mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/09/01</td>
          <td>1回目</td>
          <td>P</td>
          <td>120kv 5mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.xrays.index') }}'" value="患者一覧に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
@endsection