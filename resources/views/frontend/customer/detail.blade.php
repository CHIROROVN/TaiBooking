@extends('frontend.frontend')

@section('content')
<!-- content customer detail -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h3><a href="home.html">ホーム</a>　＞　登録内容の参照</h3>
          <p>現在の登録内容は次の通りです。</p>
          <p>変更されたい場合は、営業担当までお問い合わせください。</p>
          <table class="table table-bordered">
            <tr>
              <td rowspan="2" class="col-title">担当者①</td>
              <td class="col-title">所属</td>
              <td>入試広報部</td>
              <td class="col-title">名前</td>
              <td>山田　花子</td>
              <td class="col-title">名前かな</td>
              <td>やまだ　はなこ</td>
            </tr>
           <tr>
              <td class="col-title">TEL</td>
              <td>086-256-9999</td>
              <td class="col-title">FAX</td>
              <td>086-256-9999</td>
              <td class="col-title">メール</td>
              <td>hoge@hoge.com</td>
            </tr>
            <tr>
              <td rowspan="2" class="col-title">担当者②</td>
              <td class="col-title">所属</td>
              <td></td>
              <td class="col-title">名前</td>
              <td></td>
              <td class="col-title">名前かな</td>
              <td></td>
            </tr>
           <tr>
              <td class="col-title">TEL</td>
              <td></td>
              <td class="col-title">FAX</td>
              <td></td>
              <td class="col-title">メール</td>
              <td></td>
            </tr>
            <tr>
              <td rowspan="2" class="col-title">担当者③</td>
              <td class="col-title">所属</td>
              <td></td>
              <td class="col-title">名前</td>
              <td></td>
              <td class="col-title">名前かな</td>
              <td></td>
            </tr>
           <tr>
              <td class="col-title">TEL</td>
              <td></td>
              <td class="col-title">FAX</td>
              <td></td>
              <td class="col-title">メール</td>
              <td></td>
            </tr>
          </table>
        </div>
      </div>
    </section>
    <!-- End content customer detail -->
@endsection