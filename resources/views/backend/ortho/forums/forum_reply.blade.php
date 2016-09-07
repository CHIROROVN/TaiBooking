@extends('backend.ortho.ortho')
@section('content')
          <!-- Content forum reply -->
      <section id="page">
        <div class="container">
          <div class="row content-page content--patient-brother">
            <h3>伝言板　＞　話題の返信</h3>
              <div class="table-responsive">
                <table class="table table-bordered treatment2-list">
                  <tr>
                    <td class="col-title"  rowspan="3">
                      @if(empty($comment->forum_user_id))不明 @else {{$comment->u_name_display}} @endif<br />
                      {{formatDateTime($comment->forum_read_time, '/')}}<br />
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
                    <td><a href="<?php echo $comment->forum_file_path;?>" target="_blank" class="text-orange">ファイル名</a></td>
                  </tr>
                </table>
        {!! Form::open(array('route' => ['ortho.forums.forum_reply',$comment->forum_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8')) !!}
                <input type="hidden" name="forum_id" id="forum_id" value="{{$comment->forum_id}}">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="forum_title">話題のタイトル <span class="note_required">※</span></label></td>
                    <td><input type="text" name="forum_title" id="forum_title" class="form-control form-control--sm" value="{{old('forum_title')}}" />
                      <span class="error-input">@if ($errors->first('forum_title')) ※{!! $errors->first('forum_title') !!} @endif</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title"><label for="textDetail">本文 <span class="note_required">※</span></label></td>
                    <td>
                      <textarea name="forum_contents" cols="80" rows="5" id="forum_contents" class="form-control form-control-full">{{old('forum_contents')}}</textarea>
                      <span class="error-input">@if ($errors->first('forum_contents')) ※{!! $errors->first('forum_contents') !!} @endif</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title"><label for="forum_file_path">添付ファイル</label></td>
                    <td>
                    <!-- upload file -->
                        <div style="position:relative;display:inline-block;">
                          <a class='btn btn-sm btn-page fl-left' href='javascript:;'>
                            ファイル...
                            <input type="file" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="forum_file_path" id="forum_file_path" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
                          </a>
                          &nbsp;
                          <span class='label label-info' id="upload-file-info"></span>
                        </div>
                      <!-- End upload file -->
                      →ファイル名：
                      <input name="forum_file_name" id="forum_file_name" type="text" class="form-control form-control--sm"/>

                      <span class="error-input">@if ($errors->first('forum_file_path')) ※{!! $errors->first('forum_file_path') !!} @endif</span>
                      <span class="error-input">@if ($errors->first('forum_file_name')) ※{!! $errors->first('forum_file_name') !!} @endif</span>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input name="button" id="button" value="返信を登録する" type="submit" class="btn btn-sm btn-page">
          </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input onclick="location.href='{{route('ortho.forums.forum_list')}}'" value="登録済み話題一覧に戻る" type="button" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </section>
      <!-- End content forum reply -->
@endsection