@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => 'ortho.interviews.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="content-page">
  <h3>問診票の登録</h3>
  <table class="table table-bordered interview-regist">
    <tbody>

      <!-- patient_id -->
      <input type="hidden" name="patient_id" value="{{ $patient_id }}">

      <!-- booking_id -->
      <input type="hidden" name="booking_id" value="{{ $booking_id }}">

      <!-- clinic_id -->
      <input type="hidden" name="clinic_id" value="{{ $clinic_id }}">

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q1</span>　ご本人様について</td>
      </tr>

      <tr>
        <td width="20%">ふりがな <span class="note_required">※</span></td>
        <td>
          <div class="row">
            
            <!-- q1_1_sei -->
            <div class="col-md-6 col-lg-6 form-horizontal">
              <label class="control-label col-sm-2" for="q1_1_sei">せい：</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" name="q1_1_sei" id="q1_1_sei" value="{{ old('q1_1_sei') }}" />
                <span class="error-input">@if ($errors->first('q1_1_sei')) ※{!! $errors->first('q1_1_sei') !!} @endif</span>
              </div>
            </div>

            <!-- q1_1_mei -->
            <div class="col-md-6 col-lg-6 form-horizontal">
              <label class="control-label col-sm-2" for="q1_1_mei"> めい：</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" name="q1_1_mei" id="q1_1_mei" value="{{ old('q1_1_mei') }}" />
                <span class="error-input">@if ($errors->first('q1_1_mei')) ※{!! $errors->first('q1_1_mei') !!} @endif</span>
              </div>
            </div>
          </div>
        </td>
      </tr>

      <tr>
        <td>お名前 <span class="note_required">※</span></td>
        <td>
          <div class="row">

            <!-- q1_2_sei -->
            <div class="col-md-6 col-lg-6 form-horizontal">
              <label class="control-label col-sm-2" for="q1_2_sei">姓：</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" name="q1_2_sei" id="q1_2_sei" value="{{ old('q1_2_sei') }}" />
                <span class="error-input">@if ($errors->first('q1_2_sei')) ※{!! $errors->first('q1_2_sei') !!} @endif</span>
              </div>
            </div>

            <!-- q1_2_mei -->
            <div class="col-md-6 col-lg-6 form-horizontal">
              <label class="control-label col-sm-2" for="q1_2_mei">名：</label>
              <div class="col-sm-10">
                <input class="form-control" type="text" name="q1_2_mei" id="q1_2_mei" value="{{ old('q1_2_mei') }}" />
                <span class="error-input">@if ($errors->first('q1_2_mei')) ※{!! $errors->first('q1_2_mei') !!} @endif</span>
              </div>
            </div>
          </div>
        </td>
      </tr>

      <!-- q1_3 -->
      <tr>
        <td>結婚</td>
        <td>
          <label class="radio-inline"><input type="radio" name="q1_3" value="1" @if(old('q1_3') == 1) checked="" @endif>結婚</label>
          <label class="radio-inline"><input type="radio" name="q1_3" value="2" @if(old('q1_3') == 2) checked="" @endif>未婚</label>
        </td>
      </tr>

      <!-- q1_4 -->
      <tr>
        <td>性別</td>
        <td>
          <label class="radio-inline"><input type="radio" name="q1_4" value="1" @if(old('q1_4') == 1) checked="" @endif>男</label>
         <label class="radio-inline"><input type="radio" name="q1_4" value="2" @if(old('q1_4') == 2) checked="" @endif>女</label>
        </td>
      </tr>

      <!-- q1_5 -->
      <tr>
        <td>ご住所</td>
        <td>
            <!-- q1_5_zip_1, q1_5_zip_2 -->
            <div class="row margin-top-5">
              <div class="col-md-6 col-lg-6">
                <label for="q1_5_zip_1">〒</label>
                <input class="form-control zip-code-1" type="text" name="q1_5_zip_1" id="q1_5_zip_1" maxlength="3" value="{{ old('q1_5_zip_1') }}" /> -
                <input class="form-control zip-code-2" type="text" name="q1_5_zip_2" id="q1_5_zip_2" maxlength="4" value="{{ old('q1_5_zip_2') }}" />
              </div>
            </div>

            <!-- q1_5_pref -->
            <div class="row margin-top-5">
              <div class="col-md-6 col-lg-6">
                <select class="form-control person-charge" name="q1_5_pref" id="q1_5_pref">
                  <option data-hidden="true"></option>
                  @foreach ( $prefs as $prefKey => $prefValue )
                  <option value="{{ $prefKey }}" @if(old('q1_5_pref') == $prefKey) selected @endif >{{ $prefValue }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <!-- q1_5_address_1 -->
            <div class="row margin-top-5">
              <div class="col-md-6 col-lg-6">
                <input class="form-control" type="text" name="q1_5_address_1" id="q1_5_address_1" placeholder="例）岡山市北区1-2-3" value="{{ old('q1_5_address_1') }}" />
              </div>
            </div>

            <!-- q1_5_address_2 -->
            <div class="row margin-top-5">
              <div class="col-md-6 col-lg-6">
                <input class="form-control" type="text" name="q1_5_address_2" id="q1_5_address_2" placeholder="マンション名などをご記入ください" value="{{ old('q1_5_address_2') }}" />
              </div>
            </div>
          </td>
      </tr>

      <!-- q1_6 -->
      <tr>
          <td>電話番号 <span class="note_required">※</span></td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_6" id="q1_6" value="{{ old('q1_6') }}" />
              <span class="error-input">@if ($errors->first('q1_6')) ※{!! $errors->first('q1_6') !!} @endif</span>
            </div></div>
          </td>
      </tr>

      <!-- q1_7 -->
      <tr>
          <td>FAX</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_7" id="q1_7" value="{{ old('q1_7') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_8 -->
      <tr>
          <td>携帯電話</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_8" id="q1_8" value="{{ old('q1_8') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_9 -->
      <tr>
          <td>メールアドレス <span class="note_required">※</span></td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_9" id="q1_9" placeholder="例）example@domain.co.jp" value="{{ old('q1_9') }}" />
              <span class="error-input">@if ($errors->first('q1_9')) ※{!! $errors->first('q1_9') !!} @endif</span>
            </div></div>
          </td>
      </tr>

      <!-- q1_10 -->
      <tr>
          <td>生年月日</td>
          <td>
            <div class="row">
            <div class="col-md-12">
            <input class="form-control date abc" type="text" name="q1_10_year" id="q1_10_year" placeholder="年" value="{{ old('q1_10_year') }}" />
            <label for="birthday-year">年</label>
            <input class="form-control date" type="text" name="q1_10_month" id="q1_10_month" placeholder="月" value="{{ old('q1_10_month') }}" />
            <label for="birthday-month">月</label>
            <input class="form-control date" type="text" name="q1_10_day" id="q1_10_day" placeholder="日" value="{{ old('q1_10_day') }}" />
            <label for="birthday-day">日</label>
            </div>
            </div>
          </td>
      </tr>

      <!-- q1_11 -->
      <tr>
          <td>学校名またはお勤め先</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_11" id="q1_11" placeholder="学校・勤務先をご記入ください" value="{{ old('q1_11') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_12 -->
      <tr>
          <td>趣味・興味のあること</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_12" id="q1_12" placeholder="趣味・興味をご記入ください" value="{{ old('q1_12') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_13 -->
      <tr>
          <td>保護者様のお名前</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_13" id="q1_13" placeholder="" value="{{ old('q1_13') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_14 -->
      <tr>
          <td>保護者様のお勤め先</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_14" id="q1_14" placeholder="" value="{{ old('q1_14') }}" />
            </div></div>
          </td>
      </tr>

      <!-- q1_15 -->
      <tr>
          <td>保護者様のご連絡先</td>
          <td>
            <div class="row"><div class="col-sm-6">
              <input class="form-control" type="text" name="q1_15" id="q1_15" placeholder="" value="{{ old('q1_15') }}" />
            </div></div>
          </td>
      </tr>

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q2</span>　虫歯治療で通院される決まった歯科医院はありますか？</td>
      </tr>

      <!-- q2_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q2_kind" value="1" id="q2_kind_1" placeholder="" @if(old('q2_kind') == 1) checked="" @endif />
                <label for="q2_kind_1" class="font-weight-nomal">はい</label>&nbsp;&nbsp;
                <label for="q2_sq" class="font-weight-nomal">医院名：</label>
                <input class="form-control date" type="text" name="q2_sq" id="q2_sq" placeholder="" value="{{ old('q2_sq') }}" />
              </div>
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q2_kind" value="2" id="q2_kind_2" placeholder="" @if(old('q2_kind') == 2) checked="" @endif />
                <label for="q2_kind_2" class="font-weight-nomal">いいえ</label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q3</span>　たい矯正歯科を知ったきっかけは何ですか？（最も影響されたものを１つだけ選んでください）</td>
      </tr>

      <!-- q3_kind -->
      <tr>
          <td colspan="2">
          <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
              <input class="" type="radio" name="q3_kind" value="1" id="q3_kind_1" placeholder="" @if(old('q3_kind') == 1) checked="" @endif />
              <label for="q3_kind_1" class="font-weight-nomal">歯科医院からの紹介</label>&nbsp;&nbsp;
              <label for="q3_sq" class="font-weight-nomal">医院名：</label>
              <input class="form-control date" type="text" name="q3_sq" id="q3_sq" placeholder="" value="{{ old('q3_sq') }}" />
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
              <input class="" type="radio" name="q3_kind" value="2" id="q3_kind_2" placeholder="" @if(old('q3_kind') == 2) checked="" @endif />
              <label for="q3_kind_2" class="font-weight-nomal">たい矯正歯科の看板・広告・ホームページを見て</label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
              <input class="" type="radio" name="q3_kind" value="3" id="q3_kind_3" placeholder="" @if(old('q3_kind') == 3) checked="" @endif />
              <label for="q3_kind_3" class="font-weight-nomal">家族･兄弟が、たい矯正歯科で治療を受けている</label>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3">
              <input class="" type="radio" name="q3_kind" value="4" id="q3_kind_4" placeholder="" @if(old('q3_kind') == 4) checked="" @endif />
              <label for="q3_kind_4" class="font-weight-nomal">友人・知人の紹介</label>
            </div>
          </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q4</span>　たい矯正歯科を知ったきっかけは何ですか？（最も影響されたものを１つだけ選んでください）</td>
      </tr>

      <!-- q4_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q4_kind" value="1" id="q4_kind_1" placeholder="" @if(old('q4_kind') == 1) checked="" @endif />
                <label for="q4_kind_1" class="font-weight-nomal">ご本人の希望</label>&nbsp;&nbsp;
              </div>
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q4_kind" value="2" id="q4_kind_2" placeholder="" @if(old('q4_kind') == 2) checked="" @endif />
                <label for="q4_kind_2" class="font-weight-nomal">ご家族の希望 </label>&nbsp;&nbsp;
              </div>
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q4_kind" value="3" id="q4_kind_3" placeholder="" @if(old('q4_kind') == 3) checked="" @endif />
                <label for="q4_kind_3" class="font-weight-nomal">学校健診</label>&nbsp;&nbsp;
              </div>
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <input class="" type="radio" name="q4_kind" value="4" id="q4_kind_4" placeholder="" @if(old('q4_kind') == 4) checked="" @endif />
                <label for="q4_kind_4" class="font-weight-nomal">たい矯正歯科の評判を聞いて</label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q5</span>　以下の当てはまるところを選択してください</td>
      </tr>
      
      <!-- q5 -->
      <tr>
          <td colspan="2">
            <!-- A -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-a">
                A：前歯に隙間がある
              </div>

              <!-- q5_a_1 -->
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_1" id="q5_a_1_1" placeholder="" value="5" @if(old('q5_a_1') == 5) checked="" @endif />
                  <label for="q5_a_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_1" id="q5_a_1_2" placeholder="" value="4" @if(old('q5_a_1') == 4) checked="" @endif />
                  <label for="q5_a_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_1" id="q5_a_1_3" placeholder="" value="3" @if(old('q5_a_1') == 3) checked="" @endif />
                  <label for="q5_a_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_1" id="q5_a_1_4" placeholder="" value="2" @if(old('q5_a_1') == 2) checked="" @endif />
                  <label for="q5_a_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_1" id="q5_a_1_5" placeholder="" value="1" @if(old('q5_a_1') == 1) checked="" @endif />
                  <label for="q5_a_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者：</label><br>

                <!-- q5_a_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_2" id="q5_a_2_1" placeholder="" value="5" @if(old('q5_a_2') == 5) checked="" @endif />
                  <label for="q5_a_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_2" id="q5_a_2_2" placeholder="" value="4" @if(old('q5_a_2') == 4) checked="" @endif />
                  <label for="q5_a_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_2" id="q5_a_2_3" placeholder="" value="3" @if(old('q5_a_2') == 3) checked="" @endif />
                  <label for="q5_a_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_2" id="q5_a_2_4" placeholder="" value="2" @if(old('q5_a_2') == 2) checked="" @endif />
                  <label for="q5_a_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_a_2" id="q5_a_2_5" placeholder="" value="1" @if(old('q5_a_2') == 1) checked="" @endif />
                  <label for="q5_a_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- B -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                B：咬み合わせが深い
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_b_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_1" id="q5_b_1_1" placeholder="" value="5" @if(old('q5_b_1') == 5) checked="" @endif />
                  <label for="q5_b_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_1" id="q5_b_1_2" placeholder="" value="4" @if(old('q5_b_1') == 4) checked="" @endif />
                  <label for="q5_b_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_1" id="q5_b_1_3" placeholder="" value="3" @if(old('q5_b_1') == 3) checked="" @endif />
                  <label for="q5_b_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_1" id="q5_b_1_4" placeholder="" value="2" @if(old('q5_b_1') == 2) checked="" @endif />
                  <label for="q5_b_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_1" id="q5_b_1_5" placeholder="" value="1" @if(old('q5_b_1') == 1) checked="" @endif />
                  <label for="q5_b_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_b_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_2" id="q5_b_2_1" placeholder="" value="5" @if(old('q5_b_2') == 5) checked="" @endif />
                  <label for="q5_b_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_2" id="q5_b_2_2" placeholder="" value="4" @if(old('q5_b_2') == 4) checked="" @endif />
                  <label for="q5_b_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_2" id="q5_b_2_3" placeholder="" value="3" @if(old('q5_b_2') == 3) checked="" @endif />
                  <label for="q5_b_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_2" id="q5_b_2_4" placeholder="" value="2" @if(old('q5_b_2') == 2) checked="" @endif />
                  <label for="q5_b_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_b_2" id="q5_b_2_5" placeholder="" value="1" @if(old('q5_b_2') == 1) checked="" @endif />
                  <label for="q5_b_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- C -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                C：八重歯がある
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_c_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_1" id="q5_c_1_1" placeholder="" value="5" @if(old('q5_c_1') == 5) checked="" @endif />
                  <label for="q5_c_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_1" id="q5_c_1_2" placeholder="" value="4" @if(old('q5_c_1') == 4) checked="" @endif />
                  <label for="q5_c_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_1" id="q5_c_1_3" placeholder="" value="3" @if(old('q5_c_1') == 3) checked="" @endif />
                  <label for="q5_c_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_1" id="q5_c_1_4" placeholder="" value="2" @if(old('q5_c_1') == 2) checked="" @endif />
                  <label for="q5_c_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_1" id="q5_c_1_5" placeholder="" value="1" @if(old('q5_c_1') == 1) checked="" @endif />
                  <label for="q5_c_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_c_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_2" id="q5_c_2_1" placeholder="" value="5" @if(old('q5_c_2') == 5) checked="" @endif />
                  <label for="q5_c_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_2" id="q5_c_2_2" placeholder="" value="4" @if(old('q5_c_2') == 4) checked="" @endif />
                  <label for="q5_c_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_2" id="q5_c_2_3" placeholder="" value="3" @if(old('q5_c_2') == 3) checked="" @endif />
                  <label for="q5_c_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_2" id="q5_c_2_4" placeholder="" value="2" @if(old('q5_c_2') == 2) checked="" @endif />
                  <label for="q5_c_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_c_2" id="q5_c_2_5" placeholder="" value="1" @if(old('q5_c_2') == 1) checked="" @endif />
                  <label for="q5_c_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- D -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                D：あごが痛い
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_d_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_1" id="q5_d_1_1" placeholder="" value="5" @if(old('q5_d_1') == 5) checked="" @endif />
                  <label for="q5_d_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_1" id="q5_d_1_2" placeholder="" value="4" @if(old('q5_d_1') == 4) checked="" @endif />
                  <label for="q5_d_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_1" id="q5_d_1_3" placeholder="" value="3" @if(old('q5_d_1') == 3) checked="" @endif />
                  <label for="q5_d_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_1" id="q5_d_1_4" placeholder="" value="2" @if(old('q5_d_1') == 2) checked="" @endif />
                  <label for="q5_d_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_1" id="q5_d_1_5" placeholder="" value="1" @if(old('q5_d_1') == 1) checked="" @endif />
                  <label for="q5_d_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_d_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_2" id="q5_d_2_1" placeholder="" value="5" @if(old('q5_d_2') == 5) checked @endif />
                  <label for="q5_d_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_2" id="q5_d_2_2" placeholder="" value="4" @if(old('q5_d_2') == 4) checked @endif />
                  <label for="q5_d_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_2" id="q5_d_2_3" placeholder="" value="3" @if(old('q5_d_2') == 3) checked @endif />
                  <label for="q5_d_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_2" id="q5_d_2_4" placeholder="" value="2" @if(old('q5_d_2') == 2) checked @endif />
                  <label for="q5_d_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_d_2" id="q5_d_2_5" placeholder="" value="1" @if(old('q5_d_2') == 1) checked @endif />
                  <label for="q5_d_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- E -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                E：歯がでこぼこに生えている
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_e_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_1" id="q5_e_1_1" placeholder="" value="5" @if(old('q5_e_1') == 5) checked="" @endif />
                  <label for="q5_e_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_1" id="q5_e_1_2" placeholder="" value="4" @if(old('q5_e_1') == 4) checked="" @endif />
                  <label for="q5_e_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_1" id="q5_e_1_3" placeholder="" value="3" @if(old('q5_e_1') == 3) checked="" @endif />
                  <label for="q5_e_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_1" id="q5_e_1_4" placeholder="" value="2" @if(old('q5_e_1') == 2) checked="" @endif />
                  <label for="q5_e_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_1" id="q5_e_1_5" placeholder="" value="1" @if(old('q5_e_1') == 1) checked="" @endif />
                  <label for="q5_e_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_e_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_2" id="q5_e_2_1" placeholder="" value="5" @if(old('q5_e_2') == 5) checked="" @endif />
                  <label for="q5_e_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_2" id="q5_e_2_2" placeholder="" value="4" @if(old('q5_e_2') == 4) checked="" @endif />
                  <label for="q5_e_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_2" id="q5_e_2_3" placeholder="" value="3" @if(old('q5_e_2') == 3) checked="" @endif />
                  <label for="q5_e_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_2" id="q5_e_2_4" placeholder="" value="2" @if(old('q5_e_2') == 2) checked="" @endif />
                  <label for="q5_e_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_e_2" id="q5_e_2_5" placeholder="" value="1" @if(old('q5_e_2') == 1) checked="" @endif />
                  <label for="q5_e_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- G -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                G：下の歯が出ている
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_g_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_1" id="q5_g_1_1" placeholder="" value="5" @if(old('q5_g_1') == 5) checked="" @endif />
                  <label for="q5_g_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_1" id="q5_g_1_2" placeholder="" value="4" @if(old('q5_g_1') == 4) checked="" @endif />
                  <label for="q5_g_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_1" id="q5_g_1_3" placeholder="" value="3" @if(old('q5_g_1') == 3) checked="" @endif />
                  <label for="q5_g_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_1" id="q5_g_1_4" placeholder="" value="2" @if(old('q5_g_1') == 2) checked="" @endif />
                  <label for="q5_g_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_1" id="q5_g_1_5" placeholder="" value="1" @if(old('q5_g_1') == 1) checked="" @endif />
                  <label for="q5_g_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_g_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_2" id="q5_g_2_1" placeholder="" value="5" @if(old('q5_g_2') == 5) checked="" @endif />
                  <label for="q5_g_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_2" id="q5_g_2_2" placeholder="" value="4" @if(old('q5_g_2') == 4) checked="" @endif />
                  <label for="q5_g_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_2" id="q5_g_2_3" placeholder="" value="3" @if(old('q5_g_2') == 3) checked="" @endif />
                  <label for="q5_g_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_2" id="q5_g_2_4" placeholder="" value="2" @if(old('q5_g_2') == 2) checked="" @endif />
                  <label for="q5_g_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_g_2" id="q5_g_2_5" placeholder="" value="1" @if(old('q5_g_2') == 1) checked="" @endif />
                  <label for="q5_g_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- H -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q q5-b">
                H：あごのゆがみ
              </div>
              <div class="col-md-12 col-lg-12">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_h_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_1" id="q5_h_1_1" placeholder="" value="5" @if(old('q5_h_1') == 5) checked @endif />
                  <label for="q5_h_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_1" id="q5_h_1_2" placeholder="" value="4" @if(old('q5_h_1') == 4) checked @endif />
                  <label for="q5_h_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_1" id="q5_h_1_3" placeholder="" value="3" @if(old('q5_h_1') == 3) checked @endif/>
                  <label for="q5_h_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_1" id="q5_h_1_4" placeholder="" value="2" @if(old('q5_h_1') == 2) checked @endif />
                  <label for="q5_h_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_1" id="q5_h_1_5" placeholder="" value="1" @if(old('q5_h_1') == 1) checked @endif />
                  <label for="q5_h_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_h_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_2" id="q5_h_2_1" placeholder="" value="5" @if(old('q5_h_2') == 5) checked="" @endif />
                  <label for="q5_h_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_2" id="q5_h_2_2" placeholder="" value="4" @if(old('q5_h_2') == 4) checked="" @endif />
                  <label for="q5_h_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_2" id="q5_h_2_3" placeholder="" value="3" @if(old('q5_h_2') == 3) checked="" @endif />
                  <label for="q5_h_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_2" id="q5_h_2_4" placeholder="" value="2" @if(old('q5_h_2') == 2) checked="" @endif />
                  <label for="q5_h_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_h_2" id="q5_h_2_5" placeholder="" value="1" @if(old('q5_h_2') == 1) checked="" @endif />
                  <label for="q5_h_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <!-- I -->
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q">
                I：奥歯で噛んだときに前歯の上下に隙間が空く
              </div>
              <div class="col-md-12 col-lg-12 q5-a-1">
                <label for="" class="font-weight-nomal">本人　：</label><br>

                <!-- q5_i_1 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_1" id="q5_i_1_1" placeholder="" value="5" @if(old('q5_i_1') == 5) checked="" @endif />
                  <label for="q5_i_1_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_1" id="q5_i_1_2" placeholder="" value="4" @if(old('q5_i_1') == 4) checked="" @endif />
                  <label for="q5_i_1_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_1" id="q5_i_1_3" placeholder="" value="3" @if(old('q5_i_1') == 3) checked="" @endif />
                  <label for="q5_i_1_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_1" id="q5_i_1_4" placeholder="" value="2" @if(old('q5_i_1') == 2) checked="" @endif />
                  <label for="q5_i_1_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_1" id="q5_i_1_5" placeholder="" value="1" @if(old('q5_i_1') == 1) checked="" @endif />
                  <label for="q5_i_1_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12 group-q-child">
                <label for="" class="font-weight-nomal">保護者　：</label><br>

                <!-- q5_i_2 -->
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_2" id="q5_i_2_1" placeholder="" value="5" @if(old('q5_i_2') == 5) checked="" @endif />
                  <label for="q5_i_2_1" class="font-weight-nomal">非常に気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_2" id="q5_i_2_2" placeholder="" value="4" @if(old('q5_i_2') == 4) checked="" @endif />
                  <label for="q5_i_2_2" class="font-weight-nomal">少し気になる</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_2" id="q5_i_2_3" placeholder="" value="3" @if(old('q5_i_2') == 3) checked="" @endif />
                  <label for="q5_i_2_3" class="font-weight-nomal">それ程気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_2" id="q5_i_2_4" placeholder="" value="2" @if(old('q5_i_2') == 2) checked="" @endif />
                  <label for="q5_i_2_4" class="font-weight-nomal">全く気にならない</label>&nbsp;&nbsp;
                </div>
                <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                  <input class="" type="radio" name="q5_i_2" id="q5_i_2_5" placeholder="" value="1" @if(old('q5_i_2') == 1) checked="" @endif />
                  <label for="q5_i_2_5" class="font-weight-nomal">当てはまらない</label>
                </div>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q6</span>　先天性の疾患をお持ちですか？（保険診療が可能な場合があります）</td>
      </tr>

      <!-- q6_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q6_kind_1">
                <input type="radio" name="q6_kind" id="q6_kind_1" value="1" @if(old('q6_kind') == 1) checked="" @endif>はい</label>
                <div class="col-md-12 col-lg-12">
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_1" value="1" @if(old('q6_sq_1') == 1) checked="" @endif /> 唇顎口蓋裂</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_2" value="1" @if(old('q6_sq_2') == 1) checked="" @endif /> ゴールデンハー症候群(鰓弓異常症含む)</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_3" value="1" @if(old('q6_sq_3') == 1) checked="" @endif /> 鎖骨･頭蓋骨異骨形成</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_4" value="1" @if(old('q6_sq_4') == 1) checked="" @endif /> クルーゾン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_5" value="1" @if(old('q6_sq_5') == 1) checked="" @endif /> トリチャーコリンズ症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_6" value="1" @if(old('q6_sq_6') == 1) checked="" @endif /> ピエールロバン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_7" value="1" @if(old('q6_sq_7') == 1) checked="" @endif /> ダウン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_8" value="1" @if(old('q6_sq_8') == 1) checked="" @endif /> ラッセルシルバー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_9" value="1" @if(old('q6_sq_9') == 1) checked="" @endif /> ターナー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_10" value="1" @if(old('q6_sq_10') == 1) checked="" @endif /> ベックウィズ・ウィードマン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_11" value="1" @if(old('q6_sq_11') == 1) checked="" @endif /> 尖図合指症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_12" value="1" @if(old('q6_sq_12') == 1) checked="" @endif /> 先天性ミオパチー</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_13" value="1" @if(old('q6_sq_13') == 1) checked="" @endif /> 大理石骨病</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_14" value="1" @if(old('q6_sq_14') == 1) checked="" @endif /> 口-顔-指症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_15" value="1" @if(old('q6_sq_15') == 1) checked="" @endif /> カブキ症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_16" value="1" @if(old('q6_sq_16') == 1) checked="" @endif /> ビンダー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_17" value="1" @if(old('q6_sq_17') == 1) checked="" @endif /> クリッペル・トレノーネイ・ウェーバー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_18" value="1" @if(old('q6_sq_18') == 1) checked="" @endif /> 小舌症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_19" value="1" @if(old('q6_sq_19') == 1) checked="" @endif /> 骨形成不全症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_20" value="1" @if(old('q6_sq_20') == 1) checked="" @endif /> 口笛顔貌症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_21" value="1" @if(old('q6_sq_21') == 1) checked="" @endif /> ルビンスタイン・ティビ症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_22" value="1" @if(old('q6_sq_22') == 1) checked="" @endif /> 下垂体性小人症(成長ホルモン分泌不全症)</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_23" value="1" @if(old('q6_sq_23') == 1) checked="" @endif /> リング18症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_24" value="1" @if(old('q6_sq_24') == 1) checked="" @endif /> 顔面半側肥大症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_25" value="1" @if(old('q6_sq_25') == 1) checked="" @endif/> エリス・ヴァン・クレベルト症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_26" value="1" @if(old('q6_sq_26') == 1) checked="" @endif /> 軟骨形成不全症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_27" value="1" @if(old('q6_sq_27') == 1) checked="" @endif /> 外胚葉異形成症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_28" value="1" @if(old('q6_sq_28') == 1) checked="" @endif /> 神経線維腫症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_29" value="1" @if(old('q6_sq_29') == 1) checked="" @endif /> 基底細胞母斑症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_30" value="1" @if(old('q6_sq_30') == 1) checked="" @endif /> ヌーナン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_31" value="1" @if(old('q6_sq_31') == 1) checked="" @endif /> マルファン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_32" value="1" @if(old('q6_sq_32') == 1) checked="" @endif /> プラダーウィリー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_33" value="1" @if(old('q6_sq_33') == 1) checked="" @endif /> 顔面裂</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_34" value="1" @if(old('q6_sq_34') == 1) checked="" @endif /> ロンベルグ症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_35" value="1" @if(old('q6_sq_35') == 1) checked="" @endif /> 筋ジストロフィー</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_36" value="1" @if(old('q6_sq_36') == 1) checked="" @endif /> 色素失調症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_37" value="1" @if(old('q6_sq_37') == 1) checked="" @endif /> メービウス症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_38" value="1" @if(old('q6_sq_38') == 1) checked="" @endif /> ウィリアムズ症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_39" value="1" @if(old('q6_sq_39') == 1) checked="" @endif /> スティックラー症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_40" value="1" @if(old('q6_sq_40') == 1) checked="" @endif /> 常染色体欠失症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_41" value="1" @if(old('q6_sq_41') == 1) checked="" @endif /> 頭蓋骨癒合症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_42" value="1" @if(old('q6_sq_42') == 1) checked="" @endif /> ラーセン症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_43" value="1" @if(old('q6_sq_43') == 1) checked="" @endif /> 濃化異骨症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_44" value="1" @if(old('q6_sq_44') == 1) checked="" @endif /> 6歯以上の非症候性部分性無歯症</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_45" value="1" @if(old('q6_sq_45') == 1) checked="" @endif /> マーシャル症候群</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q6_sq_46" value="1" @if(old('q6_sq_46') == 1) checked="" @endif /> ポリエックス症候群(クラインフェルダー症候群)</label>&nbsp;&nbsp;
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q6_kind_2">
                <input type="radio" name="q6_kind" id="q6_kind_2" value="2" @if(old('q6_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q6_kind_3">
                <input type="radio" name="q6_kind" id="q6_kind_3" value="3" @if(old('q6_kind') == 3) checked="" @endif>わからない</label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q7</span>　大きな病気にかかったことがありますか？</td>
      </tr>

      <!-- q7_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q7_kind_1">
                <input type="radio" name="q7_kind" id="q7_kind_1" value="1" @if(old('q7_kind_1') == 1) checked="" @endif>はい</label>
                <div class="col-md-12 col-lg-12">
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q7_sq_1" value="1" @if(old('q7_sq_1') == 1) checked="" @endif /> 心臓病</label>&nbsp;&nbsp;
                  </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q7_sq_2" value="1" @if(old('q7_sq_2') == 1) checked="" @endif /> 肝臓病</label>&nbsp;&nbsp;
                  </div>
                    <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q7_sq_3" value="1" @if(old('q7_sq_3') == 1) checked="" @endif /> 脳梗塞&nbsp;&nbsp;</label>&nbsp;&nbsp;
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"><input type="checkbox" name="q7_sq_4" value="1" @if(old('q7_sq_4') == 1) checked="" @endif /> その他 病名：&nbsp;&nbsp;</label>&nbsp;&nbsp;
                    <input class="form-control date" type="text" name="q7_sq" value="{{ old('q7_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q7_kind_2">
                <input type="radio" name="q7_kind" id="q7_kind_2" value="2" @if(old('q7_kind_1') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q8</span>　食べ物・薬・金属などでアレルギーを起こしたことがありますか？</td>
      </tr>

      <!-- q8_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q8_kind_1">
                <input type="radio" name="q8_kind" id="q8_kind_1" value="1" @if(old('q8_kind') == 1) checked="" @endif>はい</label>
                <div class="col-md-12 col-lg-12">
                  <label class="font-weight-nomal"><input type="checkbox" name="q8_kind_1_1" value="1" @if(old('q8_kind_1_1') == 1) checked="" @endif /> 具体的に分かれば教えてください：&nbsp;&nbsp;</label>&nbsp;&nbsp;
                  <input class="form-control" type="text" name="q8_sq" value="{{ old('q8_sq') }}" />
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q8_kind_2">
                <input type="radio" name="q8_kind" id="q8_kind_2" value="2" @if(old('q8_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q8_kind_3">
                <input type="radio" name="q8_kind" id="q8_kind_3" value="3" @if(old('q8_kind') == 3) checked="" @endif>わからない </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q9</span>　感染症（B型肝炎、C型肝炎、HIV、梅毒）にかかっていますか？</td>
      </tr>

      <!-- q9_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q9_kind" id="q9_kind_1" value="1" @if(old('q9_kind') == 1) checked="" @endif>はい </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q9_kind" id="q9_kind_2 " value="2" @if(old('q9_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q9_kind" id="q9_kind_3" value="3" @if(old('q9_kind') == 3) checked="" @endif>わからない</label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q10</span>　現在、歯科以外に病院に通院されていますか？</td>
      </tr>

      <!-- q10_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q10_kind_1">
                <input type="radio" name="q10_kind" id="q10_kind_1" value="1" @if(old('q10_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q10_kind_1_1">病院名:</label>
                    <input class="form-control date" id="q10_kind_1_1" type="text" name="q10_sq_1" value="{{ old('q10_sq_1') }}" />
                    <input class="form-control date" id="q10_kind_1_2" type="text" name="q10_sq_2" value="{{ old('q10_sq_2') }}" />
                    <label class="radio-inline" for="q10_kind_1_2">科</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q10_kind_2">
                <input type="radio" name="q10_kind" id="q10_kind_2" value="2" @if(old('q10_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q11</span>　現在服用している薬はありますか？</td>
      </tr>

      <!-- q11_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q11_kind_1">
                <input type="radio" name="q11_kind" id="q11_kind_1" value="1" @if(old('q11_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q11_kind_1_1"> お薬の名称</label>
                    <input class="form-control date" id="q11_kind_1_1" type="text" name="q11_sq" value="{{ old('q11_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q11_kind_2">
                <input type="radio" name="q11_kind" id="q11_kind_2" value="2" @if(old('q11_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q12</span>　現在、妊娠されていますか？また、その可能性がありますか？</td>
      </tr>

      <!-- q12_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q12_kind" id="q12_kind_1" value="1" @if(old('q12_kind') == 1) checked="" @endif>はい </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q12_kind" id="q12_kind_2 " value="2" @if(old('q12_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q13</span>　過去に顔や、あご、歯を強く打ったことがありますか？</td>
      </tr>

      <!-- q13_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q13_kind_1">
                <input type="radio" name="q13_kind" id="q13_kind_1" value="1" @if(old('q13_kind_1') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q13_kind_1_1"> 部位：</label>
                    <input class="form-control date" id="q13_kind_1_1" type="text" name="q13_sq_1" value="{{ old('q13_sq_1') }}" />
                    <label class="radio-inline" for="q13_kind_1_2"> 病院名：</label>
                    <input class="form-control date" id="q13_kind_1_2" type="text" name="q13_sq_2" value="{{ old('q13_sq_2') }}" />
                    <input class="form-control date" id="q13_kind_1_3" type="text" name="q13_sq_3" value="{{ old('q13_sq_3') }}" />
                    <label class="radio-inline" for="q13-科">科</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q13_kind_2">
                <input type="radio" name="q13_kind" id="q13_kind_2" value="2" @if(old('q13_kind_1') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q14</span>　鼻がよく詰まりますか？</td>
      </tr>

      <!-- q14_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q14_kind_1">
                <input type="radio" name="q14_kind" id="q14_kind_1" value="1" @if(old('q14_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q14_kind_2"> 原因は？：</label>
                    <input class="form-control date" id="q14_kind_2" type="text" name="q14_sq" value="{{ old('q14_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q14_kind_2">
                <input type="radio" name="q14_kind" id="q14_kind_2" value="2" @if(old('q14_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q15</span>　発言しにくい言葉がありますか？</td>
      </tr>

      <!-- q15_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q15_kind_1">
                <input type="radio" name="q15_kind" id="q15_kind_1" value="1" @if(old('q15_kind') == 1) checked @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q15_kind_1_1"> たとえば、それはどんな言葉ですか？：</label>
                    <input class="form-control date" id="q15_kind_1_1" type="text" name="q15_sq" value="{{ old('q15_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q15_kind_2">
                <input type="radio" name="q15_kind" id="q15_kind_2" value="2" @if(old('q15_kind') == 2) checked @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q16</span>　指をしゃぶる癖や、つめをかむ癖、ほおづえをつくことがありますか？</td>
      </tr>

      <!-- q16_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q16_kind_1)">
                <input type="radio" name="q16_kind" id="q16_kind_1" value="1" @if(old('q16_kind') == 1) checked="" @endif>はい(現在進行形)</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q16_kind_2">
                <input type="radio" name="q16_kind" id="q16_kind_2" value="2" @if(old('q16_kind') == 2) checked="" @endif>はい(過去形)</label>
                <div class="col-md-12 col-lg-12">
                  <input class="form-control date" id="q16_kind_2_1" type="text" name="q16_sq" value="{{ old('q16_sq') }}" />
                  <label class="radio-inline" for="q16_kind_2_1">歳ごろまで</label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q16_kind_3">
                <input type="radio" name="q16_kind" id="q16_kind_3" value="3" @if(old('q16_kind') == 3) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q17</span>　歯ぎしりをしますか？</td>
      </tr>

      <!-- q17_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q17_kind" id="q17_kind_1" value="1" @if(old('q17_kind') == 1) checked="" @endif>はい </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q17_kind" id="q17_kind_2" value="2" @if(old('q17_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q17_kind" id="q17_kind_3" value="3" @if(old('q17_kind') == 3) checked="" @endif>わからない </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q18</span>　たびたび、頭痛や関節の痛みがありますか？</td>
      </tr>

      <!-- q18_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q18_kind" id="q18_kind_1" value="1" @if(old('q18_kind') == 1) checked="" @endif>はい </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline"><input type="radio" name="q18_kind" id="q18_kind_2" value="2" @if(old('q18_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q19</span>　食べ物で食べにくいものがありますか？</td>
      </tr>

      <!-- q19_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q19_kind_1">
                <input type="radio" name="q19_kind" id="q19_kind_1" value="1" @if(old('q19_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q19_kind_1_1"> それは何ですか？：</label>
                    <input class="form-control date" id="q19_kind_1_1" type="text" name="q19_sq" value="{{ old('q19_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q19_kind_2">
                <input type="radio" name="q19_kind" id="q19_kind_2" value="2" @if(old('q19_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q20</span>　矯正治療を受ける上で留意してほしいことがら（体質や各種障害）はありますか？</td>
      </tr>

      <!-- q20_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q20_kind_1">
                <input type="radio" name="q20_kind" id="q20_kind_1" value="1" @if(old('q20_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q20_kind_1_1">内容：</label>
                    <input class="form-control date" id="q20_kind_1_1" type="text" name="q20_sq" value="{{ old('q20_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q20_kind_2">
                <input type="radio" name="q20_kind" id="q20_kind_2" value="2" @if(old('q20_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q21</span>　現在治療中の歯がありますか？</td>
      </tr>

      <!-- q21_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q21_kind_1">
                <input type="radio" name="q21_kind" id="q21_kind_1" value="1" @if(old('q21_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q21_kind_1_1">部位：</label>
                    <input class="form-control date" id="q21_kind_1_1" type="text" name="q21_sq_1" value="{{ old('q21_sq_1') }}" />
                    <label class="radio-inline" for="q21_kind_1_2">治療内容：</label>
                    <input class="form-control date" id="q21_kind_1_2" type="text" name="q21_sq_2" value="{{ old('q21_sq_2') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q21_kind_2">
                <input type="radio" name="q21_kind" id="q21_kind_2" value="2" @if(old('q21_kind') == 2) checked="" @endif>いいえ </label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q21_kind_2_1">最後に歯医者にかかったのは何歳ごろですか？：</label>
                    <input class="form-control date" id="q21_kind_2_1" type="text" name="q21_sq_3" value="{{ old('q21_sq_3') }}" />
                    <label class="radio-inline" for="q21_kind_2_1">歳ごろ</label>
                  </div>
                </div>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q22</span>　今、歯並び以外で気にされていることはありますか？（例：親知らずが痛い、詰め物が取れているなど）</td>
      </tr>

      <!-- q22 -->
      <tr>
          <td colspan="2">
            <input class="form-control" type="text" name="q22" value="{{ old('q22') }}" />
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q23</span>　過去に矯正治療の相談を受けたことがありますか？</td>
      </tr>

      <!-- q23_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q23_kind_1">
                <input type="radio" name="q23_kind" id="q23_kind_1" value="1" @if(old('q23_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q23_kind_1_1">歯科医院名：</label>
                    <input class="form-control date" id="q23_kind_1_1" type="text" name="q23_sq" value="{{ old('q23_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q23_kind_2">
                <input type="radio" name="q23_kind" id="q23_kind_2" value="2" @if(old('q23_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q24</span>　現在、ご家族・ご親戚の方が矯正治療を受けられていれば、お名前と続柄を教えてください</td>
      </tr>

      <!-- q24_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q24_kind_1">
                <input type="radio" name="q24_kind" id="q24_kind_1" value="1" @if(old('q24_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q24_kind_1_1">お名前：</label>
                    <input class="form-control date" id="q24_kind_1_1" type="text" name="q24_sq_1" value="{{ old('q24_sq_1') }}" />
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q24_kind_1_2">続柄：</label>
                    <input class="form-control date" id="q24_kind_1_2" type="text" name="q24_sq_2" value="{{ old('q24_sq_2') }}" />
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q24_kind_1_3">歯科医院名：</label>
                    <input class="form-control date" id="q24_kind_1_3" type="text" name="q24_sq_3" value="{{ old('q24_sq_3') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q24_kind_2">
                <input type="radio" name="q24_kind" id="q24_kind_2" value="2" @if(old('q24_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q25</span>　過去、ご家族・ご親戚の方で矯正治療を受けた方がいらっしゃれば、お名前と続柄を教えて下さい</td>
      </tr>

      <!-- q25_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q25_kind_1">
                <input type="radio" name="q25_kind" id="q25_kind_1" value="1" @if(old('q25_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q25_kind_1_1">お名前：</label>
                    <input class="form-control date" id="q25_kind_1_1" type="text" name="q25_sq_1" value="{{ old('q25_sq_1') }}" />
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q25_kind_1_2">続柄：</label>
                    <input class="form-control date" id="q25_kind_1_2" type="text" name="q25_sq_2" value="{{ old('q25_sq_2') }}" />
                  </div>
                  <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                    <label class="radio-inline" for="q25_kind_1_3">歯科医院名：</label>
                    <input class="form-control date" id="q25_kind_1_3" type="text" name="q25_sq_3" value="{{ old('q25_sq_3') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q25_kind_2">
                <input type="radio" name="q25_kind" id="q25_kind_2" value="2" @if(old('q25_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q26</span>　転勤・引越し・留学等のご予定はありますか？</td>
      </tr>

      <!-- q26_kind -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q26_kind_1">
                <input type="radio" name="q26_kind" id="q26_kind_1" value="1" @if(old('q26_kind') == 1) checked="" @endif>はい</label>
                <div class="row">
                  <div class="col-md-12 col-lg-12">
                    <label class="radio-inline" for="q26_kind_1_1">いつ頃？：</label>
                    <input class="form-control date" id="q26_kind_1_1" type="text" name="q26_sq" value="{{ old('q26_sq') }}" />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="radio-inline" for="q26_kind_2">
                <input type="radio" name="q26_kind" id="q26_kind_2" value="2" @if(old('q26_kind') == 2) checked="" @endif>いいえ </label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q27</span>　以下の項目のうち、気になるものを選択してください</td>
      </tr>

      <!-- q27 -->
      <tr>
          <td colspan="2">
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_1">
                <input type="checkbox" name="q27_1" id="q27_1" value="1" @if(old('q27_1') == 1) checked="" @endif>矯正装置が入っている期間、保定装置の期間など治療期間について気になる</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_2">
                <input type="checkbox" name="q27_2" id="q27_2" value="1" @if(old('q27_2') == 1) checked="" @endif>治療費がどのくらいになるか気になる</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_3">
                <input type="checkbox" name="q27_3" id="q27_3" value="1" @if(old('q27_3') == 1) checked="" @endif>仕事上、接客の機会が多いので、支障が無いか、気になる </label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_4">
                <input type="checkbox" name="q27_4" id="q27_4" value="1" @if(old('q27_4') == 1) checked="" @endif>スポーツをしている</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_5">
                <input type="checkbox" name="q27_5" id="q27_5" value="1" @if(old('q27_5') == 1) checked="" @endif>管楽器の演奏をすることがある</label>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 col-lg-12">
                <label class="checkbox-inline" for="q27_6">
                <input type="checkbox" name="q27_6" id="q27_6" value="1" @if(old('q27_6') == 1) checked="" @endif>普段の生活で、(受験・仕事など)ストレスがかかることがある</label>
              </div>
            </div>
          </td>
      </tr>

      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q28</span>　その他、矯正治療を進めていく上で、ご不安・ご希望の点があればお書きください</td>
      </tr>
      
      <!-- q28 -->
      <tr>
          <td colspan="2">
            <textarea name="q28" id="q28" cols="30" rows="10" class="form-control  form-control-full">{{ old('q28') }}</textarea>
          </td>
      </tr>

    </tbody>
  </table>

  <div class="float-left margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
    </div>
  </div>
</div>
{!! Form::close() !!}

@stop


@section('script')
  <script type="text/javascript">
    $(document).ready(function(){
      // 1
      $(function () {
        $('#txt1').datetimepicker();
      });
      // 2
      $(function () {
        $('#txt2').datetimepicker();
      });
      // 3
      $(function () {
        $('#txt3').datetimepicker();
      });

      // year
      $(function () {
        $('#q1_10_year').datetimepicker({
          viewMode: 'years',
          format: 'YYYY'
        });
      });
      // month
      $(function () {
        $('#q1_10_month').datetimepicker({
          viewMode: 'months',
          format: 'MM'
        });
      });
      // day
      $(function () {
        $('#q1_10_day').datetimepicker({
          viewMode: 'days',
          format: 'DD'
        });
      });
    });
    
  </script>
@stop