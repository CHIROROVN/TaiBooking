@extends('backend.backend')
@section('content')
	<!-- content student contact regist -->
    <section id="page">
      <div class="container">
        {!! Form::open( ['id' => 'frmContactRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['backend.students.contact.regist', $stu_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
        <div class="row content content--list">
          <h3><a style="text-decoration:none;" href="{{route('backend.students.contact.index')}}">お問い合わせ管理</a>　＞　お問い合わせ情報の新規登録</h3>
          <table class="table table-bordered">
            <tr>
              <td class="col-title">日付 <span class="note_required">※</span></td>
              <td><label for="date">西暦</label>
                <input name="year" id="year" class="form-control form-control--small-xs" type="text"> 年 
                <input name="month" id="month" class="form-control form-control--small-xs" type="text"> 月 
                <input name="day" id="day" class="form-control form-control--small-xs" type="text"> 日
                <input name="dateNow" id="dateNow" value="今日" type="button" class="btn btn-xs btn-primary">
                  @if ($errors->first('year'))
                    <div class="help-block with-errors">※ {!! $errors->first('year') !!}</div>
                  @endif
                  @if ($errors->first('month'))
                    <div class="help-block with-errors">※ {!! $errors->first('month') !!}</div>
                  @endif
                  @if ($errors->first('day'))
                    <div class="help-block with-errors">※ {!! $errors->first('day') !!}</div>
                  @endif
              </td>
              <td class="col-title">応対者</td>
              <td>{{@Auth::user()->u_name}}
              <input name="contact_fst_user" id="contact_fst_user" value="{{@Auth::user()->u_id}}" type="hidden">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="contact_title">タイトル <span class="note_required">※</span></label></td>
              <td colspan="3"><input name="contact_title" id="contact_title" class="form-control form-control--large" type="text">
                  @if ($errors->first('contact_title'))
                    <div class="help-block with-errors">※ {!! $errors->first('contact_title') !!}</div>
                  @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="contact_main">内容 <span class="note_required">※</span></label></td>
              <td colspan="3"><textarea name="contact_main" cols="70" rows="5" id="contact_main" class="form-control form-control--large"></textarea>
                  @if ($errors->first('contact_main'))
                    <div class="help-block with-errors">※ {!! $errors->first('contact_main') !!}</div>
                  @endif
              </td>
            </tr>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-primary mar-right">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('backend.students.contact.index')}}'" value="お問い合わせ情報一覧に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </section>
<script type="text/javascript">
  var date  = new Date();
  var day   = convert2Digit(date.getDay());
  var month = convert2Digit(date.getMonth()+1);
  var year  = date.getFullYear();
  $('#dateNow').click(function(event) {
    $('#year').val(year);
    $('#month').val(month);
    $('#day').val(day);
  });

  function convert2Digit(num){
    return num > 9 ? "" + num: "0" + num;
  }
</script>
    <!-- End content student contact regist -->
@endsection