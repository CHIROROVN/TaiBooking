@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.memos.edit', $memo->memo_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content">
        <h1>メモカレンダーの編集</h1>
          <div class="table-responsive">
            <table class="table table-bordered">

              <tr>
                <td class="col-title" width="15%">日時</td>
                <td>{{ formatDateJp($memo->memo_date) }}({{ DayJp($memo->memo_date) }})</td>
              </tr>

              <!-- memo_contents -->
              <tr>
                <td class="col-title"><label for="memo_contents">内容</label></td>
                <td>
                  @if ( old('memo_contetns') )
                  <textarea name="memo_contents" rows="5" id="memo_contents" class="form-control">{!! old('memo_contetns') !!}</textarea>
                  @else
                  <textarea name="memo_contents" rows="5" id="memo_contents" class="form-control">{!! $memo->memo_contents !!}</textarea>
                  @endif
                </td>
              </tr>
            </table>
          </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
      </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}

<script>
  $(document).ready(function(){
    CKEDITOR.replace( 'memo_contents', {
      language: 'ja',
      enterMode: Number(2),
      toolbar: [
        { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
        { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
        { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
        { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button' ] },
        '/',
        { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
        { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
        { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
        '/',
        { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
        { name: 'colors',      items : [ 'TextColor','BGColor' ] },
      ],
    });
  });
</script>

@endsection