@extends('backend.backend')

@section('content')
<div class="container">

  <?php $arr_power = permistion(Auth::user()->u_power); ?>
  <div class="row content content--menu">

    <!-- message no access permisition -->
    @if ($message = Session::get('no_access'))
      <div class="alert alert-danger  alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <strong> {{ $message }}</strong>
      </div>
    @endif

    <!-- SUPPER_ADMIN and ADMIN ==> full -->
    @if ( in_array('SUPPER_ADMIN', $arr_power) || in_array('ADMIN', $arr_power) )
    <!-- column 1 -->
    <div class="col-md-4">
      <h2>個人情報管理業務</h2>
      <ul>
        <li><a href="{{route('backend.students.regist')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>個人情報の新規登録</a></li>
        <li><a href="{{route('backend.students.import')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>個人情報のCSV一括登録</a></li>
        <li><a href="{{ route('backend.students.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>個人情報の検索・一覧・修正・削除・CSV出力</a></li>
      </ul>
    </div>

    <!-- column 2 -->
    <div class="col-md-4">
      <h2>プレゼント発送業務</h2>
      <ul>
        <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>対象者の抽出・CSV出力</a></li>
      </ul>
      <h2>資料発送業務</h2>
      <ul>
        <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>対象者の抽出・表示・CSV出力</a></li>
      </ul>
      <h2>資料請求番号通知業務</h2>
      <ul>
        <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>資料請求番号等のCSV出力</a></li>
      </ul>
    </div>

    <!-- column 3 -->
    <div class="col-md-4">
      <h2>マスタ管理</h2>
      <ul>
        <li><a href="{{route('backend.customers.search')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>顧客マスタ管理</a></li>
        <li><a href="{{ route('backend.enterprises.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>法人マスタ管理</a></li>
        <li><a href="{{ route('backend.baitais.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>媒体マスタ管理</a></li>
        <li><a href="{{ route('backend.pamphlets.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>資料請求番号マスタ管理</a></li>
        <li><a href="{{ route('backend.gpamphlets.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>一括資料請求番号マスタ管理</a></li>
        <li><a href="{{ route('backend.bunyas.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>分野番号マスタ管理</a></li>
        <li><a href="{{route('backend.highshools.search')}}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>高等学校マスタ管理</a></li>
        <li><a href="{{ route('backend.universities.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>大学マスタ管理</a></li>
        <li><a href="{{ route('backend.presents.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>プレゼントマスタ管理</a></li>
        <li><a href="{{ route('backend.campaigns.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>キャンペーンマスタ管理</a></li>
        <li><a href="{{ route('backend.users.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>ユーザー管理</a></li>
      </ul>
    </div>
    @else
    <!-- not full -->
      <!-- MEMBER -->
      @if ( in_array('MEMBER', $arr_power) )
      <!-- column 3 -->
      <div class="col-md-4">
        <h2>マスタ管理</h2>
        <ul>
          <li><a href="{{ route('backend.customers.search') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>顧客マスタ管理</a></li>
          <li><a href="{{ route('backend.enterprises.index') }}"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>法人マスタ管理</a></li>
        </ul>
      </div>
      @endif

      <!-- PRINTER -->
      @if ( in_array('PRINTER', $arr_power) )
      <!-- column 2 -->
      <div class="col-md-4">
        <h2>資料請求番号通知業務</h2>
        <ul>
          <li><a href=""><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>資料請求番号等のCSV出力</a></li>
        </ul>
      </div>
      @endif

      <!-- STAFF -->
      @if ( in_array('STAFF', $arr_power) )
      <!-- column 1 -->
      <div class="col-md-4">
        <h2>個人情報管理業務</h2>
        <ul>
          <li><a href="student_regist.html"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>個人情報の新規登録</a></li>
        </ul>
      </div>
      @endif
    @endif
  </div>
</div>
@endsection