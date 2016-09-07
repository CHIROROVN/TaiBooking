@extends('backend.ortho.ortho')
@section('content')
    <!-- Content forum detail -->
    <section id="page">
      <div class="container">
      {!! Form::open(array('route' => ['ortho.forums.forum_delete_cnf', $comment->forum_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8')) !!}
        <div class="row content-page">
          <h3>伝言板　＞　話題の削除を確認</h3>
          <table class="table table-bordered treatment2-list">
            <tr>
              <td class="col-title">話題のタイトル</td>
              <td>{{$comment->forum_title}}</td>
            </tr>
            <tr>
              <td class="col-title">本文</td>
              <td><?php echo nl2br($comment->forum_contents) ?></td>
            </tr>
            <tr>
              <td class="col-title">添付ファイル</td>
              <td><a href="<?php echo $comment->forum_file_path;?>" target="_blank" class="text-orange">ファイル名</a></td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onclick="location.href='{{route('ortho.forums.forum_delete', $comment->forum_id)}}'" value="削除する" class="btn btn-sm btn-page">
            <input type="button" onclick="goBack()" value="キャンセル" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </section>
  <!-- End content forum detail -->
  <script>
    function goBack() {
        window.history.go(-1);
    }
  </script>
@endsection