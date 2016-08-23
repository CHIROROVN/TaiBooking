@extends('backend.ortho.ortho')
@section('content')
    
  <!-- content forum list -->
    <section id="page">
      <div class="container content-page">
        <h3>伝言板　＞　話題の一覧</h3>
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
            <input value="新しい話題を作る" class="btn btn-sm btn-page" type="button" onclick="location.href='{{route('ortho.forums.forum_regist')}}'">
          </div>
        </div>
        <table class="table table-bordered table-striped treatment2-list">
          <tbody>
                <tr>
                  <td class="col-title" align="center" style="width:50px"></td>
                  <td class="col-title" align="center" style="width:30%;">話題</td>
                  <td class="col-title" align="center">返答数</td>
                  <td class="col-title" align="center">読数</td>
                  <td class="col-title" align="center">名前</td>
                  <td class="col-title" align="center">最終更新日</td>
                </tr>
            @if(!count($forums))
                <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
            @else
            @foreach($forums as $forum)
            <tr>
              <td align="center">
                @if(reader($forum->forum_id))
                <img src="{{asset('public/backend/ortho')}}/common/image/mail_close.gif" height="14" width="13">
                @else
                <img src="{{asset('public/backend/ortho')}}/common/image/mail_open.gif" height="14" width="13">
                @endif
              </td>
              <td><a href="{{route('ortho.forums.forum_detail', $forum->forum_id)}}">{{$forum->forum_title}}</a></td>
              <td align="center">{{countReply($forum->forum_id)}}</td>
              <td align="center">@if(!empty($forum->forum_view)){{$forum->forum_view}}@else 0 @endif</td>
              <td align="center">@if(empty($forum->forum_user_id))不明 @else {{$forum->u_name_display}} @endif</td>
              <td align="center">{{formatDateTime($forum->forum_time, '/')}}</td>
            </tr>
            <tr>
            @endforeach
            @endif
          </tbody>
        </table>

        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            {!! $forums->appends([])->render(new App\Pagination\SimplePagination($forums)) !!}
          </div>
        </div>
       
        <div class="row margin-bottom mar-top20">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('ortho.forums.forum_search')}}'" value="キーワード検索" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>    
    </section>
  <!-- End content forum list -->
@endsection