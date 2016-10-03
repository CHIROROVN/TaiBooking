@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.memos.regist',$memo_date], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content">
        <h1>メモカレンダーの登録</h1>
          <table class="table table-bordered">

            <!-- memo_date -->
            <input type="hidden" name="memo_date" value="{{ $memo_date }}">
            <tr>
              <td class="col-title" width="15%">日時</td>
              <td>{{ formatDateJp($memo_date) }}({{ DayJp($memo_date) }})
              <span class="error-input">@if ($errors->first('memo_date')) {!! $errors->first('memo_date') !!} @endif</span></td>
            </tr>

            <!-- memo_contents -->
            <tr>
              <td class="col-title"><label for="memo_contents">内容 <span class="note_required">※</span></label></td>
              <td>
                <textarea name="memo_contents" rows="5" id="memo_contents" class="form-control">{!! old('memo_contetns') !!}</textarea>
                <span class="error-input">@if ($errors->first('memo_contents')) ※{!! $errors->first('memo_contents') !!} @endif</span>
              </td>
            </tr>
          </table>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
      </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}

@stop


@section('script')
  <script>
    $(document).ready(function(){
      CKEDITOR.replace( 'memo_contents', {
        language: 'ja',
        enterMode: Number(2),
        toolbar: [
          { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
          { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
          '/',
          { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
          { name: 'colors',      items : [ 'TextColor','BGColor' ] },
        ],
      });
    });
  </script>
@stop