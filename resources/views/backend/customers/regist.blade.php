@extends('backend.backend')

@section('content')
<!-- content customer regist -->
    <section id="page">
      <div class="container">
      {!! Form::open( ['id' => 'frmCustomerRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => 'backend.customers.regist', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
        <div class="row content content--regist">
          <div class="msg-alert-action">
              @if ($message = Session::get('success'))
              <div class="alert alert-success  alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> {{ $message }}</li></strong></ul>
              </div>
            @elseif($message = Session::get('danger'))
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> {{ $message }}</li></strong></ul>
              </div>
            @endif
          </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="cus_code">学校コード <span class="note_required">※</span></label></td>
                <td>
                  <input name="cus_code" id="cus_code" type="text" class="form-control form-control--small" value="{{old('cus_code')}}">
                  @if ($errors->first('cus_code'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_code') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="cus_name">学校名 <span class="note_required">※</span></label></td>
                <td>
                  <input name="cus_name" id="cus_name" type="text" class="form-control form-control--default" value="{{old('cus_name')}}">
                  @if ($errors->first('cus_name'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_name') !!}</div>
                  @endif
                </td>
                
                <td class="col-title"><label for="cus_name_kana">学校名かな <span class="note_required">※</span></label></td>
                <td>
                  <input name="cus_name_kana" id="cus_name_kana" type="text" class="form-control form-control--default" value="{{old('cus_name_kana')}}">
                  @if ($errors->first('cus_name_kana'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_name_kana') !!}</div>
                  @endif
                </td>
              </tr>
              <tr>
                <td class="col-title"><label for="cus_title">見出し</label></td>
                <td>
                  <input name="cus_title" id="cus_title" type="text" class="form-control form-control--default" value="{{old('cus_title')}}">
                  @if ($errors->first('cus_title'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_title') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="cus_old_name">旧学校名</label></td>
                <td>
                  <input name="cus_old_name" id="cus_old_name" type="text" class="form-control form-control--default" value="{{old('cus_old_name')}}">
                  @if ($errors->first('cus_old_name'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_old_name') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="ent_id">親法人 <span class="note_required">※</span></label></td>
                <td>
                  <select name="ent_id" id="ent_id" class="form-control form-control--small">
                    <option value="" selected="selected">なし</option>
                    @if(count($enterprises) > 0)
                    @foreach($enterprises as $key => $ent)
                      <option value="{{$key}}" @if(old('ent_id') == $key) selected="selected" @endif >{{$ent}}</option>
                    @endforeach
                    @endif
                  </select>
                  @if ($errors->first('ent_id'))
                    <div class="help-block with-errors">※ {!! $errors->first('ent_id') !!}</div>
                  @endif
                </td>
              </tr>
              <tr>
                <td class="col-title"><label for="cus_pay">有料・無料 <span class="note_required">※</span></label></td>
                <td>
                  <input name="cus_pay" id="free" value="0" type="radio" @if(old('cus_pay') == '0') checked="checked"  @endif > 無料　　　
                  <input name="cus_pay" id="paid" value="1" type="radio" @if(old('cus_pay') == '1') checked="checked"  @endif > 有料
                  @if ($errors->first('cus_pay'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_pay') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="cus_sex">女子専用</label></td>
                <td>
                  <input name="cus_sex" id="cus_sex" value="2" type="checkbox" @if( old('cus_sex') == '2' ) checked="checked" @endif > 女子校
                  @if ($errors->first('cus_sex'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_sex') !!}</div>
                  @endif
                </td>
                <td rowspan="2" class="col-title"><label for="cus_notice">注意文言</label></td>
                <td rowspan="2"><textarea name="cus_notice" cols="40" rows="2" id="cus_notice" class="form-control form-control--default">@if( old('cus_notice') ){{old('cus_notice')}}@endif</textarea>
                  @if ($errors->first('cus_notice'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_notice') !!}</div>
                  @endif
                </td>
              </tr>
              <tr>
                <td class="col-title"><label for="cus_kind">学校区分 <span class="note_required">※</span></label></td>
                <td>
                  <select name="cus_kind" id="cus_kind" class="form-control form-control--small">
                    <option value="">▼選択</option>
                    <option value="01" @if( old('cus_kind') == '01') selected="selected" @endif >大学</option>
                    <option value="02" @if( old('cus_kind') == '02') selected="selected" @endif >職業大学</option>
                    <option value="11" @if( old('cus_kind') == '11') selected="selected" @endif >短期大学</option>
                    <option value="21" @if( old('cus_kind') == '21') selected="selected" @endif >専門学校</option>
                    <option value="22" @if( old('cus_kind') == '22') selected="selected" @endif >職業訓練法人</option>
                    <option value="23" @if( old('cus_kind') == '23') selected="selected" @endif >一般教育機関</option>
                    <option value="24" @if( old('cus_kind') == '24') selected="selected" @endif >留学・外国教育機関</option>
                    <option value="25" @if( old('cus_kind') == '25') selected="selected" @endif >新聞奨学会</option>
                    <option value="26" @if( old('cus_kind') == '26') selected="selected" @endif >看護学校</option>
                  </select>
                  @if ($errors->first('cus_kind'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_kind') !!}</div>
                  @endif
                </td>
                <td class="col-title"><label for="cus_owner">運営区分 <span class="note_required">※</span></label></td>
                <td>
                  <select name="cus_owner" id="cus_owner" class="form-control form-control--small">
                    <option value="" selected="selected">▼選択</option>
                    <option value="01" @if(old('cus_owner') == '01') selected="select"  @endif >国立</option>
                    <option value="02" @if(old('cus_owner') == '02') selected="selected"  @endif >公立</option>
                    <option value="03" @if(old('cus_owner') == '03') selected="selected"  @endif >私立</option>
                  </select>
                  @if ($errors->first('cus_owner'))
                    <div class="help-block with-errors">※ {!! $errors->first('cus_owner') !!}</div>
                  @endif
                </td>
              </tr>
            </tbody>
          </table>
          <table class="table table-bordered">
            <tr>
              <td rowspan="2" class="col-title">担当者①</td>
              <td class="col-title"><label for="cus_staff1_belong">所属</label></td>
              <td>
                <input name="cus_staff1_belong" id="cus_staff1_belong" type="text" class="form-control form-control--default" value="{{old('cus_staff1_belong')}}">
                @if ($errors->first('cus_staff1_belong'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_belong') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff1_name">名前 <span class="note_required">※</span></label></td>
              <td>
                <input name="cus_staff1_name" id="cus_staff1_name" type="text" class="form-control form-control--default" value="{{old('cus_staff1_name')}}" >
                @if ($errors->first('cus_staff1_name'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_name') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="textKanaName1">名前かな</label></td>
              <td>
                <input name="cus_staff1_name_kana" id="cus_staff1_name_kana" type="text" class="form-control form-control--default" value="{{old('cus_staff1_name_kana')}}">
                @if ($errors->first('cus_staff1_name_kana'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_name_kana') !!}</div>
                @endif
              </td>
            </tr>
           <tr>
              <td class="col-title"><label for="cus_staff1_tel">TEL</label></td>
              <td>
                <input name="cus_staff1_tel" id="cus_staff1_tel" type="text" class="form-control form-control--default" value="{{old('cus_staff1_tel')}}" >
                @if ($errors->first('cus_staff1_tel'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_tel') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff1_fax">FAX</label></td>
              <td>
                <input name="cus_staff1_fax" id="cus_staff1_fax" type="text" class="form-control form-control--default" value="{{old('cus_staff1_fax')}}" >
                @if ($errors->first('cus_staff1_fax'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_email') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff1_email">メール</label></td>
              <td>
                <input name="cus_staff1_email" id="cus_staff1_email" type="text" class="form-control form-control--default" value="{{old('cus_staff1_email')}}">
                @if ($errors->first('cus_staff1_email'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff1_email') !!}</div>
                @endif
              </td>
            </tr>
            <tr>
              <td rowspan="2" class="col-title">担当者②</td>
              <td class="col-title"><label for="cus_staff2_belong">所属</label></td>
              <td>
                <input name="cus_staff2_belong" id="cus_staff2_belong" type="text" class="form-control form-control--default" value="{{old('cus_staff2_belong')}}">
                @if ($errors->first('cus_staff2_belong'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_belong') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff2_name">名前</label></td>
              <td>
                <input name="cus_staff2_name" id="cus_staff2_name" type="text" class="form-control form-control--default" value="{{old('cus_staff2_name')}}">
                @if ($errors->first('cus_staff2_name'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_name') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff2_name_kana">名前かな</label></td>
              <td>
                <input name="cus_staff2_name_kana" id="cus_staff2_name_kana" type="text" class="form-control form-control--default" value="{{old('cus_staff2_name_kana')}}">
                @if ($errors->first('cus_staff2_name_kana'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_name_kana') !!}</div>
                @endif
              </td>
            </tr>
           <tr>
              <td class="col-title"><label for="cus_staff2_tel">TEL</label></td>
              <td>
                <input name="cus_staff2_tel" id="cus_staff2_tel" type="text" class="form-control form-control--default" value="{{old('cus_staff2_tel')}}">
                @if ($errors->first('cus_staff2_tel'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_tel') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff2_fax">FAX</label></td>
              <td>
                <input name="cus_staff2_fax" id="cus_staff2_fax" type="text" class="form-control form-control--default" value="{{old('cus_staff2_fax')}}" >
                @if ($errors->first('cus_staff2_fax'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_fax') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff2_email">メール</label></td>
              <td>
                <input name="cus_staff2_email" id="cus_staff2_email" type="text" class="form-control form-control--default" value="{{old('cus_staff2_email')}}">
                @if ($errors->first('cus_staff2_email'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff2_email') !!}</div>
                @endif
              </td>
            </tr>
            <tr>
              <td rowspan="2" class="col-title">担当者③</td>
             <td class="col-title"><label for="cus_staff3_belong">所属</label></td>
              <td>
                <input name="cus_staff3_belong" id="cus_staff3_belong" type="text" class="form-control form-control--default" value="{{old('cus_staff3_belong')}}" >
                @if ($errors->first('cus_staff3_belong'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_belong') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff3_name">名前</label></td>
              <td>
                <input name="cus_staff3_name" id="cus_staff3_name" type="text" class="form-control form-control--default" value="{{old('cus_staff3_name')}}" >
                @if ($errors->first('cus_staff3_name'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_name') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff3_name_kana">名前かな</label></td>
              <td>
                <input name="cus_staff3_name_kana" id="cus_staff3_name_kana" type="text" class="form-control form-control--default" value="{{old('cus_staff3_name_kana')}}">
                @if ($errors->first('cus_staff3_name_kana'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_name_kana') !!}</div>
                @endif
              </td>
            </tr>
           <tr>
              <td class="col-title"><label for="cus_staff3_tel">TEL</label></td>
              <td>
                <input name="cus_staff3_tel" id="cus_staff3_tel" type="text" class="form-control form-control--default" value="{{old('cus_staff3_tel')}}">
                @if ($errors->first('cus_staff3_tel'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_tel') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff3_fax">FAX</label></td>
              <td>
                <input name="cus_staff3_fax" id="cus_staff3_fax" type="text" class="form-control form-control--default" value="{{old('cus_staff3_fax')}}">
                @if ($errors->first('cus_staff3_fax'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_fax') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_staff3_email">メール</label></td>
              <td>
                <input name="cus_staff3_email" id="cus_staff3_email" type="text" class="form-control form-control--default" value="{{old('cus_staff3_email')}}" >
                @if ($errors->first('cus_staff3_email'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_staff3_email') !!}</div>
                @endif
              </td>
            </tr>
          </table>
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="cus_login">ログインID <span class="note_required">※</span></label></td>
              <td>
                <input name="cus_login" id="cus_login" type="text" class="form-control form-control--small" value="{{old('cus_login')}}" >
                @if ($errors->first('cus_login'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_login') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_passwd">パスワード <span class="note_required">※</span></label></td>
              <td>
                <input name="cus_passwd" id="cus_passwd" type="password" class="form-control form-control--default" value="{{old('cus_passwd')}}">
                @if ($errors->first('cus_passwd'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_passwd') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="cus_mail_send">メール送信</label></td>
              <td>
                <select name="cus_mail_send" id="cus_mail_send" class="form-control form-control--small">
                  <option value="0" selected="selected">しない</option>
                  <option value="1" @if(old('cus_mail_send') == '1') checked="checked" @endif >曜日指定</option>
                  <option value="2" @if(old('cus_mail_send') == '2') checked="checked" @endif >日付指定</option>
                </select>
                @if ($errors->first('cus_mail_send'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_mail_send') !!}</div>
                @endif
              </td>
            </tr>
           <tr>
              <td class="col-title"><label for="cus_mail_span">メール送信間隔</label></td>
              <td></td>
              <td class="col-title"><label for="cus_zip_pwd">ZIPパスワード</label></td>
              <td>
                <input name="cus_zip_pwd" id="cus_zip_pwd" type="password" class="form-control form-control--default">
                @if ($errors->first('cus_zip_pwd'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_zip_pwd') !!}</div>
                @endif
              </td>
              <td class="col-title"><label for="rdFileForamat">ファイル形式</label></td>
              <td>
                <input name="cus_mail_attach" id="mail_attach_csv" value="1" type="radio" @if( old('cus_mail_attach') == '1' ) checked="checked"  @endif > CSV　　　
                <input name="cus_mail_attach" id="mail_attach_excel" value="2" type="radio" @if( old('cus_mail_attach') == '2' ) checked="checked"  @endif > Excel
                @if ($errors->first('cus_mail_attach'))
                  <div class="help-block with-errors">※ {!! $errors->first('cus_mail_attach') !!}</div>
                @endif
              </td>
            </tr>
          </table>
        </div>
        <div class="row mar-bottom">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-primary">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </section>
    <!-- End content customer regist -->
@endsection