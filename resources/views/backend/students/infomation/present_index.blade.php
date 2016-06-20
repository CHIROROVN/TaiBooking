@extends('backend.backend')
@section('content')
	<!-- content student present list -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <table class="table table-bordered">
            <tr>
              <td class="col-title">氏名</td>
              <td>山田　太郎</td>
              <td class="col-title">ふりがな</td>
              <td>やまだ　たろう</td>
              <td class="col-title">誕生日</td>
              <td>西暦 1980 年 12 月 25 日</td>
            </tr>
            <tr>
              <td class="col-title">性別</td>
              <td>男</td>
              <td class="col-title">高校</td>
              <td>岡山高等学校</td>
              <td class="col-title">学年</td>
              <td>3 年生（4/1現在）</td>
            </tr>
            <tr>
              <td class="col-title">郵便番号</td>
              <td>700-0001</td>
              <td class="col-title">住所</td>
              <td colspan="3">岡山県　倉敷市　福井125-7　スギモトマンション1101</td>
            </tr>
            <tr>
              <td class="col-title">電話番号</td>
              <td>086-111-1111</td>
              <td class="col-title">メールアドレス</td>
              <td>sugimoto@chiroro.co.jp</td>
              <td class="col-title">ステータス</td>
              <td>本登録</td>
            </tr>
          </table>
          <div class="text-right">
            <input onclick="location.href='student_present_regist.html'" value="希望プレゼント情報の新規登録" type="button" class="btn btn-sm btn-primary">
          </div>
          <table class="table table-bordered table-striped clearfix">
            <tr>
              <td class="col-title" align="center">日付</td>
              <td class="col-title" align="center">媒体番号</td>
              <td colspan="4" class="col-title" align="center">キャンペーン番号</td>
              <td class="col-title" align="center">編集</td>
              <td class="col-title" align="center">削除</td>
            </tr>
            <tr>
              <td>2016/08/31</td>
              <td align="right">12345</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="center"><input onclick="location.href='student_present_edit.html'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
              <td align="center"><input onclick="location.href='student_present_delete_cnf.html'" value="削除" type="button" type="button" class="btn btn-xs btn-primary"></td>
            </tr>
            <tr>
              <td>2016/08/31</td>
              <td align="right">12345</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="center"><input onclick="location.href='student_present_edit.html'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
              <td align="center"><input onclick="location.href='student_present_delete_cnf.html'" value="削除" type="button" type="button" class="btn btn-xs btn-primary"></td>
            </tr>
            <tr>
              <td>2016/08/31</td>
              <td align="right">12345</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="right">123</td>
              <td align="center"><input onclick="location.href='student_present_edit.html'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
              <td align="center"><input onclick="location.href='student_present_delete_cnf.html'" value="削除" type="button" type="button" class="btn btn-xs btn-primary"></td>
            </tr>
          </table>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='student_detail.html'" value="詳細に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student present list -->
@endsection