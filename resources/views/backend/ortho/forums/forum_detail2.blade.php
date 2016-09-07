@extends('backend.ortho.ortho')
@section('content')
      <!-- Content forum detail -->
    <section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>伝言板　＞　話題の参照</h3>
          <div class="text-right">
            <input onclick="location.href='{{route('ortho.forums.forum_reply', $comment->forum_id)}}'" value="この話題に返信する" class="btn btn-sm btn-page" type="button">
          </div>
          <table class="table table-bordered treatment2-list">
            <tr>
              <td class="col-title"  rowspan="3">
                @if(empty($comment->forum_user_id))不明 @else {{$comment->u_name_display}} @endif<br />
                {{formatDateTime($comment->forum_time, '/')}}<br />
                 @if(!empty(Auth::user()->u_power12))
                  @if(Auth::user()->u_power12 == 2)
                <a class="text-orange" href="{{route('ortho.forums.forum_edit',$comment->forum_id)}}">編集</a> / <a class="text-orange" href="{{route('ortho.forums.forum_delete_cnf',$comment->forum_id)}}">削除</a>
                 @elseif(Auth::user()->u_power12 == 1)
                    @if(checkOwn(Auth::user()->id, $comment->forum_id))
                    <a class="text-orange" href="{{route('ortho.forums.forum_edit',$comment->forum_id)}}">編集</a> / <a class="text-orange" href="{{route('ortho.forums.forum_delete_cnf',$comment->forum_id)}}">削除</a>
                    @endif
                  @endif
                @endif
              </td>
              <td>{{$comment->forum_title}}</td>
            </tr>
            <tr>
              <td><?php echo nl2br($comment->forum_contents) ?></td>
            </tr>
            <tr>
              <td>
                @if(!empty($comment->forum_file_path))
                  <a href="<?php echo $comment->forum_file_path;?>" target="_blank" class="text-orange">ファイル名</a>
                @else
                  <a href="javascript::void(0);" class="text-orange">ファイル名</a>
                @endif
              </td>
            </tr>
          </table>
          @if(count($commentrs))
            @foreach($commentrs as $cr)
            <table class="table table-bordered treatment2-list">
              <tr>
                <td class="col-title"  rowspan="3">
                  @if(empty($cr->forum_user_id))不明 @else {{$cr->u_name_display}} @endif<br />
                  {{formatDateTime($cr->forum_read_time, '/')}}<br />
                  @if(!empty(Auth::user()->u_power12))
                  @if(Auth::user()->u_power12 == 2)
                  <a class="text-orange" href="{{route('ortho.forums.forum_edit',$cr->forum_id)}}">編集</a> / <a class="text-orange" href="{{route('ortho.forums.forum_delete_cnf',$cr->forum_id)}}">削除</a>
                  @elseif(Auth::user()->u_power12 == 1)
                    @if(checkOwn(Auth::user()->id, $cr->forum_id))
                    <a class="text-orange" href="{{route('ortho.forums.forum_edit',$cr->forum_id)}}">編集</a> / <a class="text-orange" href="{{route('ortho.forums.forum_delete_cnf',$cr->forum_id)}}">削除</a>
                    @endif
                  @endif
                @endif
                </td>
                <td>{{$cr->forum_title}}</td>
              </tr>
              <tr>
                <td><?php echo nl2br($cr->forum_contents) ?></td>
              </tr>
              <tr>
                <td>
                  @if(!empty($cr->forum_file_path))
                    <a href="<?php echo $cr->forum_file_path;?>" target="_blank" class="text-orange">ファイル名</a>
                  @else
                    <a href="javascript::void(0);" class="text-orange">ファイル名</a>
                  @endif
              </tr>
            </table>
            @endforeach
          @endif

          <div class="text-right">
            <input onclick="location.href='{{route('ortho.forums.forum_reply',$comment->forum_id)}}'" value="この話題に返信する" class="btn btn-sm btn-page" type="button">
          </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('ortho.forums.forum_list')}}'" value="登録済み話題一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
  <!-- End content forum detail -->
@endsection