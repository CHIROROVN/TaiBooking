@extends('backend.ortho.ortho')

@section('content')

<section id="page">
  <div class="container content-page">
    <h3>予約の変更</h3>
    <p>変更してよろしいですか？</p>
    <div class="row">
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">変更前</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>123456 杉元　俊彦</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>2016年5月1日（日）　15:00～15:15 </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>たい矯正歯科</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>チェアー１</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>田井　規能</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>会津　実枝</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>シュワ</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">業務内容-2</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">救急</td>
              <td>救急です</td>
            </tr>
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>通常</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-6">
        <table class="table table-bordered treatment2-list">
          <tbody>
          <tr><td colspan="2">変更後</td></tr>
            <tr>
              <td class="col-title" style="width:30%">患者名</td>
              <td>123456 杉元　俊彦</td>
            </tr>
            <tr>
              <td class="col-title">予約日時</td>
              <td>2016年5月1日（日）　15:00～15:15 </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>たい矯正歯科</td>
            </tr>
            <tr>
              <td class="col-title">チェアー</td>
              <td>チェアー１</td>
            </tr>
            <tr>
              <td class="col-title">ドクター</td>
              <td>田井　規能</td>
            </tr>
            <tr>
              <td class="col-title">衛生士</td>
              <td>会津　実枝</td>
            </tr>
            <tr>
              <td class="col-title">装置</td>
              <td>シュワ</td>
            </tr>
            <tr>
              <td class="col-title">業務内容-1</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">業務内容-2</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">検査</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">保険診療</td>
              <td></td>
            </tr>
            <tr>
              <td class="col-title">救急</td>
              <td>救急ではない</td>
            </tr>
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>通常</td>
            </tr>
            <tr>
              <td class="col-title">備考</td>
              <td></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        {!! Form::open(array('route' => ['ortho.bookings.booking.change.confirm', 1], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
        <input type="hidden" name="booking_id" value="1">
        <input value="変更する（確認済）" name="save" type="submit" class="btn btn-sm btn-page">
        </form>
      </div>
    </div>
  </div>    
</section>


@endsection