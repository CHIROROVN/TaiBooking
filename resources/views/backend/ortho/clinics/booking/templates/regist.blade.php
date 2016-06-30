@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic booking template regist -->
  <section id="page">
    <div class="container">
      <div class="row content content--page">
        <h3>医院情報管理　＞　たい矯正歯科　＞　予約雛形の新規登録</h3>
        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="txtTemName">雛形名</label></td>
            <td>
              <input name="txtTemName" id="txtTemName" value="" type="text" class="form-control form-control--default">
              <!-- <input type="button" class="btn btn-sm btn-page no-border" name="button" value="保存する"> -->
            </td>
          </tr>
        </table>
        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center">時間</td>
              <td align="center">チェアー1</td>
              <td align="center">チェアー2</td>
              <td align="center">チェアー3</td>
              <td align="center">チェアー4</td>
              <td align="center">チェアー5</td>
              <td align="center">チェアー6</td>
              <td align="center">チェアー7</td>
              <td align="center">チェアー8</td>
              <td align="center">チェアー9</td>
              <td align="center">チェアー10</td>
              <td align="center">チェアー11</td>
              <td align="center">診断</td>
              <td align="center">相談</td>
              <td align="center">レントゲン</td>
              <td align="center">CT</td>
              <td align="center">筋電図</td>
            </tr>
            <tr>
              <td align="center">09:00～</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:15～</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:30～</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">09:45～</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">10:00～</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
            <tr>
              <td align="center">10:15～</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-blue">末設1</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-blue">末<br />設<br />定</td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
              <td align="center" class="col-brown"><img src="{{asset('public/backend/ortho/common/image')}}/img-col-shift-set.png" /></td>
            </tr>
          </table>
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='clinic_list.html'" value="医院一覧に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  <!-- End content clinic booking template regist -->
@endsection