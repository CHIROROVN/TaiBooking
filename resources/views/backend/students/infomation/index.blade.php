@extends('backend.backend')
@section('content')
	<!-- Content student list -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
            <p>全12345件中、999件が該当しました。うち、1～8件を表示しています。</p>

            <div class="row fl-right mar-bottom">
                <div class="col-md-12">
                    <input onclick="location.href='{{ route('backend.students.regist') }}'" value="個人の新規登録" type="button" class="btn btn-sm btn-primary"/>
                </div>
            </div>

            <table class="table table-bordered table-striped">
              <tr>
                <td class="col-title" align="center">会員ID</td>
                <td class="col-title" align="center">名前</td>
                <td class="col-title" align="center">名前よみ</td>
                <td class="col-title" align="center">性別</td>
                <td class="col-title" align="center">都道府県名</td>
                <td class="col-title" align="center">電話番号</td>
                <td class="col-title" align="center">個人情報管理</td>
                <td class="col-title" align="center">資料請求情報管理</td>
                <td class="col-title" align="center">問い合わせ管理</td>
                <td class="col-title" align="center">希望プレゼント管理</td>
              </tr>
              @if ( empty($students) || count($students) == 0 )
              <tr><td colspan="10" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td></tr>
              @else
                @foreach ( $students as $student)
                <tr>
                  <td align="right">12345678</td>
                  <td>山田　太郎</td>
                  <td>やまだ　たろう</td>
                  <td>男</td>
                  <td>岡山県</td>
                  <td>086-000-0000</td>
                  <td align="center"><input type="button" onClick="location.href='student_detail.html'" value="個人情報管理" class="btn btn-xs btn-primary"/></td>
                  <td align="center"><input type="button" onClick="location.href='student_brochure_list.html'" value="資料請求情報管理" class="btn btn-xs btn-primary"/></td>
                  <td align="center"><input type="button" onClick="location.href='student_contact_list.html'" value="問い合わせ管理" class="btn btn-xs btn-primary"/></td>
                  <td align="center"><input type="button" onClick="location.href='student_present_list.html'" value="希望プレゼント管理" class="btn btn-xs btn-primary"/></td>
                </tr>
                @endforeach
              @endif
            </table>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input name="button5" value="前の8件を表示" type="submit" class="btn btn-sm btn-primary btn-mar-right">
            <input name="button4" value="次の8件を表示" type="submit" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student list -->
@endsection