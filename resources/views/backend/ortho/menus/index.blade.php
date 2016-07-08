@extends('backend.ortho.ortho')

@section('content')
    <section id="page">
      <div class="container">
        <div class="row content content--menu">
          <h1>メニュー</h1>
          <div class="col-md-4 col-lg-4">
            <!-- power 1 -->
            @if(!empty(Auth::user()->u_power1))
            <h2>患者管理</h2>
            <ul>
              <li><a href="{{ route('ortho.patients.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>患者の新規登録・一覧・変更・削除・予約表示・来院履歴・コミュニケーションノート</a></li>
            </ul>
            @endif

            <!-- power 2 -->
            @if(!empty(Auth::user()->u_power2))
            <h2>予約管理</h2>
            <ul>
              <li><a href="{{ route('ortho.bookings.booking_search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>新患の予約を取る</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>来院履歴登録～次回の予約を取る</a></li>
              <li><a href="{{ route('ortho.patients.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>予約の変更・キャンセル処理</a></li>
              <li><a href="{{route('ortho.bookings.list1_list')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>TEL待ちリストから予約を取る</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>急患の予約を取る</a></li>
              <li><a href="{{ route('ortho.bookings.booking.monthly') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>予約簿の表示</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>予約状況の模式図</a></li>
            </ul>
            @endif

            <!-- power 3 -->
            @if(!empty(Auth::user()->u_power3))
            <h2>院長予定管理</h2>
            <ul>
              <li><a href="ddr-calendar.html"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>院長予定のカレンダー表示・新規登録・変更・削除</a></li>
            </ul>
            @endif

            <h2>メモ管理</h2>
            <ul>
              <li><a href="{{ route('ortho.memos.calendar') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>カレンダー表示・メモの新規登録・変更・削除</a></li>
            </ul>

          </div>
          <div class="col-md-4 col-lg-4">

            <!-- power 5 -->
            @if(!empty(Auth::user()->u_power5))
            <h2>月1回の予約業務前処理</h2>
            <ul>
              <li><a href="{{route('ortho.shifts.list_edit')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>シフトの新規登録・一覧・変更・削除</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>予約簿テンプレートの適用と個別調整</a></li>
            </ul>
            @endif

            <!-- power 6 -->
            @if(!empty(Auth::user()->u_power6))
            <h2>医院情報管理</h2>
            <ul>
              <li><a href="{{ route('ortho.clinics.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>医院の新規登録・一覧・変更・削除・設備管理・業務枠管理・予約簿テンプレート管理</a></li>
            </ul>
            @endif

            <!-- power 7 -->
            @if(!empty(Auth::user()->u_power7))
            <h2>各種リスト表示</h2>
            <ul>
              <li><a href="{{route('ortho.bookings.list1_list')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「TEL待ち」リストの表示</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「無断キャンセル」リストの表示</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「リコール」リストの表示</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「未作成技工物TEL待ち」リストの表示</a></li>
              <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「作成済み技工物キャンセル」リストの表示</a></li>
            </ul>
            @endif

            <!-- power 10 -->
            @if(!empty(Auth::user()->u_power10))
            <h2>初診業務</h2>
            <ul>
              <li><a href="{{ route('ortho.interviews.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>初診リスト表示・問診票の入力</a></li>
            </ul>
            @endif
          </div>
          <div class="col-md-4 col-lg-4">

            <!-- power 4 -->
            @if(!empty(Auth::user()->u_power4))
            <h2>放射線照射録管理</h2>
            <ul>
              <li><a href="{{ route('ortho.xrays.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>放射線照射の検索・登録・表示</a></li>
            </ul>
            @endif

            <!-- power 8 -->
            @if(!empty(Auth::user()->u_power8))
            <h2>共通マスタ管理</h2>
            <ul>
              <li><a href="{{ route('ortho.areas.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「地域」項目の新規登録・一覧・変更・削除</a></li>
              <li><a href="{{route('ortho.services.index')}}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「業務名」項目の新規登録・一覧・変更・削除</a></li>
              <li><a href="{{route('ortho.equipments.index')}}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「装置」項目の新規登録・一覧・変更・削除</a></li>
              <li><a href="{{route('ortho.treatments.treatment1.index')}}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「治療内容」項目の新規登録・一覧・変更・削除</a></li>
              <li><a href="{{ route('ortho.inspections.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「検査」項目の新規登録・一覧・変更・削除</a></li>
              <li><a href="{{ route('ortho.insurances.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「保険診療」項目の新規登録・一覧・変更・削除</a></li>
            </ul>
            @endif

            <!-- power 9 -->
            @if(!empty(Auth::user()->u_power9))
            <h2>ユーザー管理</h2>
            <ul>
              <li><a href="{{ route('ortho.users.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>ユーザーの新規登録・一覧・変更・削除</a></li>
              <li><a href="{{ route('ortho.belongs.index') }}"><p><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>「所属」項目の新規登録・一覧・変更・削除</a></li>
            </ul>
            @endif
          </div>
        </div>
      </div>
    </section>
@endsection