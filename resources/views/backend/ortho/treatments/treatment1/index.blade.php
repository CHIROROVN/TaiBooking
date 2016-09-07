@extends('backend.ortho.ortho')

@section('content')
	<!-- Content treatment 1 list -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　登録済み治療内容の一覧</h3>
      <div class="msg-alert-action margin-top-15">
      @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @elseif($message = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @endif
    </div>

      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.treatments.treatment1.regist')}}'">
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
            @if(!count($treatment1s))
				<tr>
		          <td colspan="4" align="center">{{ trans('common.no_data_correspond') }}</td>
				</tr>
            @else
            <?php 
	            $i = 0;
	            $count = count($treatment1s);
	          ?>
            	@foreach($treatment1s as $treatment1)
            	<?php $i++; ?>
	            	<tr>
		              <td>{{$treatment1->treatment_name}}</td>
		              <td>{{$treatment1->treatment_time}}分</td>
		              <td align="center">
		              	<a href="{{route('ortho.treatments.treatment1.edit', $treatment1->treatment_id)}}" class="btn btn-sm btn-edit">編集</a>
		              </td>
		              <td align="center">
	                    <button onclick="location.href='{{ url('ortho/treatment1/orderby-top?id=' . $treatment1->treatment_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">TOP
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='{{ url('ortho/treatment1/orderby-up?id=' . $treatment1->treatment_id) }}'" class="@if($i < 2) {{'hidden'}} @endif">↑</button>
	                  </td>
	                  <td align="center">
	                    <button onclick="location.href='{{ url('ortho/treatment1/orderby-down?id=' . $treatment1->treatment_id) }}'" class="@if($i == $count) {{'hidden'}} @endif">↓</button>
	                  </td>
	                  <td align="center" class="">
	                    <button onclick="location.href='{{ url('ortho/treatment1/orderby-last?id=' . $treatment1->treatment_id) }}'" class="@if($i == $count) {{'hidden'}} @endif">LAST</button>
	                  </td>
		            </tr>
	            @endforeach
            @endif
        </tbody>
      </table>
      <div class="row">
        <div class="col-md-12 text-right">
          <input type="submit" name="button" value="治療内容の新規登録" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.treatments.treatment1.regist')}}'">
        </div>
      </div>
    </div>
  <!-- End content treatment 1 list -->
@endsection