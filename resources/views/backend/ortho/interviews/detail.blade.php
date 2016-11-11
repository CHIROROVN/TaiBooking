@extends('backend.ortho.ortho')

@section('content')

<div class="content-page">
    <?php
        $first_id = 0;
        if ( isset($interview->first_id) ) {
            $first_id = $interview->first_id;
        }
    ?>
  <h3>問診票の参照</h3>
  <div class="text-right">
    <input onclick="location.href='{{ route('ortho.interviews.edit', $first_id) }}'" value="編集する" class="btn btn-sm btn-page btn-mar-right" type="button">
    <input value="削除する" class="btn btn-sm btn-page" type="button" data-toggle="modal" data-target="#myModal">
    <!-- Trigger the modal with a button -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
        </div>
        <div class="modal-body">
          <p>{{ trans('common.modal_content_delete') }}</p>
        </div>
        <div class="modal-footer">
          <a href="{{ route('ortho.interviews.delete', [ $first_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
          <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
        </div>
      </div>
    </div>
    </div>
    <!-- end modal -->
  </div>
  <table class="table table-bordered interview-regist treatment2-list">
    <tbody>
      <tr>
        <td colspan="2" class="col-title">●医院使用欄</td>
      </tr>
      <tr>
        <td width="25%">問診票記入場所</td>
        <td>
          <div class="row">
            <div class="col-md-6 col-lg-6">{{ @$clinics[$interview->q0_1_clinic]->clinic_name }}</div>
            <div class="col-md-6 col-lg-6">日付：テスト-{{ @$interview->q0_1_date }}</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>相談を行った場所</td>
        <td>
          <div class="row">
            <div class="col-md-6 col-lg-6">{{ @$clinics[$interview->q0_2_clinic]->clinic_name }}</div>
            <div class="col-md-6 col-lg-6">日付：テスト-{{ @$interview->q0_2_date }}</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>相談担当者</td>
        <td>{{ @$users[$interview->q0_3_user]->u_name }}</td>
      </tr>
      <tr>
        <td>紹介元医院</td>
        <td>
          <div class="row">
            <div class="col-md-6 col-lg-6">{{ @$clinics[$interview->q0_4_clinic]->clinic_name }}</div>
            <div class="col-md-6 col-lg-6">日付：テスト-{{ @$interview->q0_4_date }}</div>
          </div>
        </td>
      </tr>
      <tr>
        <td>主訴</td>
        <td>テスト-{{ @$interview->q0_5 }}</td>
      </tr>
      <tr>
        <td>所見</td>
        <td>テスト-{{ @$interview->q0_6 }}</td>
      </tr>
      <tr>
        <td>説明チェック</td>
        <td>テスト-{{ @$interview->q0_7 }}</td>
      </tr>
      <tr>
        <td>資料チェック</td>
        <td>テスト-{{ @$interview->q0_8 }}</td>
      </tr>
      <tr>
        <td>メモ</td>
        <td>テスト-{{ @$interview->q0_9 }}</td>
      </tr>

      <!-- Q1 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q1</span>　ご本人様について</td>
      </tr>
      <tr>
        <td>ふりがな</td>
        <td>
          <div class="row">
            <div class="col-md-6 col-lg-6">
              せい：{{ @$interview->q1_1_sei }}
            </div>
            <div class="col-md-6 col-lg-6">
              めい：{{ @$interview->q1_1_mei }}
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>お名前</td>
        <td>
          <div class="row">
            <div class="col-md-6 col-lg-6">
              姓：{{ @$interview->q1_2_sei }}
            </div>
            <div class="col-md-6 col-lg-6">
              名：{{ @$interview->q1_2_mei }}
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>結婚</td>
        <td>テスト-<?php echo (@$interview->q1_3 == 1) ? '結婚' : '未婚'; ?></td>
      </tr>
      <tr>
        <td>性別</td>
        <td>テスト-<?php echo (@$interview->q1_4 == 1) ? '男' : '女'; ?></td>
      </tr>
      <tr>
        <td>ご住所</td>
        <td>
          <div class="row margin-top-5">
            <div class="col-md-6 col-lg-6">
              <label for="">〒</label>
              {{ @$interview->q1_5_zip_1 }} - {{ @$interview->q1_5_zip_2 }}
            </div>
          </div>
          <div class="row margin-top-5">
            <div class="col-md-6 col-lg-6">
              <?php echo (@$prefs[$interview->q1_5_pref]) ? $prefs[$interview->q1_5_pref] : ''; ?>
            </div>
          </div>
          <div class="row margin-top-5">
            <div class="col-md-6 col-lg-6">
              {{ @$interview->q1_5_address_1 }}
            </div>
          </div>
          <div class="row margin-top-5">
            <div class="col-md-6 col-lg-6">
              {{ @$interview->q1_5_address_2 }}
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>電話番号</td>
        <td>テスト-{{ @$interview->q1_6 }}</td>
      </tr>
      <tr>
        <td>FAX</td>
        <td>テスト-{{ @$interview->q1_7 }}</td>
      </tr>
      <tr>
        <td>携帯電話</td>
        <td>テスト-{{ @$interview->q1_8 }}</td>
      </tr>
      <tr>
        <td>メールアドレス</td>
        <td>テスト-{{ @$interview->q1_9 }}</td>
      </tr>
      <tr>
        <td>生年月日</td>
        <td><?php echo (isset($interview->q1_10)) ? formatDate($interview->q1_10) : ''; ?></td>
      </tr>
      <tr>
        <td>学校名またはお勤め先</td>
        <td>テスト-{{ @$interview->q1_11 }}</td>
      </tr>
      <tr>
        <td>趣味・興味のあること</td>
        <td>テスト-{{ @$interview->q1_12 }}</td>
      </tr>
      <tr>
        <td>保護者様のお名前</td>
        <td>{{ @$interview->q1_13 }}</td>
      </tr>
      <tr>
        <td>保護者様のお勤め先</td>
        <td>{{ @$interview->q1_14 }}</td>
      </tr>
      <tr>
        <td>保護者様のご連絡先</td>
        <td>{{ @$interview->q1_15 }}</td>
      </tr>

      <!-- Q2 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q2</span>　虫歯治療で通院される決まった歯科医院はありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
        @if ( isset($interview->q2_kind) && $interview->q2_kind == 1 )
        はい   医院名：{{ $interview->q2_sq }}
        @elseif ( isset($interview->q2_kind) && $interview->q2_kind == 2 )
        いいえ
        @endif
        </td>
      </tr>

      <!-- Q3 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q3</span>　たい矯正歯科を知ったきっかけは何ですか？（最も影響されたものを１つだけ選んでください）</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q3_kind) && $interview->q3_kind == 1 )
            歯科医院からの紹介   医院名：{{ $interview->q3_kind }}
            @elseif ( isset($interview->q3_kind) && $interview->q3_kind == 2 )
            たい矯正歯科の看板・広告・ホームページを見て
            @elseif ( isset($interview->q3_kind) && $interview->q3_kind == 3 )
            家族･兄弟が、たい矯正歯科で治療を受けている
            @elseif ( isset($interview->q3_kind) && $interview->q3_kind == 4 )
            友人・知人の紹介
            @endif
        </td>
      </tr>

      <!-- Q4 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q4</span>　たい矯正歯科を知ったきっかけは何ですか？（最も影響されたものを１つだけ選んでください）</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q4_kind) && $interview->q4_kind == 1 )
            ご本人の希望
            @elseif ( isset($interview->q4_kind) && $interview->q4_kind == 2 )
            ご家族の希望
            @elseif ( isset($interview->q4_kind) && $interview->q4_kind == 3 )
            学校健診
            @elseif ( isset($interview->q4_kind) && $interview->q4_kind == 4 )
            たい矯正歯科の評判を聞いて
            @endif
        </td>
      </tr>

      <!-- Q5 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q5</span>　以下の当てはまるところを選択してください</td>
      </tr>
      <tr>
        <td colspan="2">
          <!-- A -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-a">
              A：前歯に隙間がある
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_a_1]) ? $q5[$interview->q5_a_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者： <?php echo (@$q5[$interview->q5_a_2]) ? $q5[$interview->q5_a_2] : ''; ?></label>
            </div>
          </div>
          <!-- B -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              B：咬み合わせが深い
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_b_1]) ? $q5[$interview->q5_b_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_b_2]) ? $q5[$interview->q5_b_2] : ''; ?></label>
            </div>
          </div>
          <!-- C -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              C：八重歯がある
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_c_1]) ? $q5[$interview->q5_c_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_c_2]) ? $q5[$interview->q5_c_2] : ''; ?></label>
            </div>
          </div>
          <!-- D -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              D：あごが痛い
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_d_1]) ? $q5[$interview->q5_d_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_d_2]) ? $q5[$interview->q5_d_2] : ''; ?></label>
            </div>
          </div>
          <!-- E -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              E：歯がでこぼこに生えている
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_e_1]) ? $q5[$interview->q5_e_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_e_2]) ? $q5[$interview->q5_e_2] : ''; ?></label>
            </div>
          </div>
          <!-- G -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              G：下の歯が出ている
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_g_1]) ? $q5[$interview->q5_g_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_g_2]) ? $q5[$interview->q5_g_2] : ''; ?></label>
            </div>
          </div>
          <!-- H -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q q5-b">
              H：あごのゆがみ
            </div>
            <div class="col-md-12 col-lg-12">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_h_1]) ? $q5[$interview->q5_h_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_h_2]) ? $q5[$interview->q5_h_2] : ''; ?></label>
            </div>
          </div>
          <!-- I -->
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q">
              I：奥歯で噛んだときに前歯の上下に隙間が空く
            </div>
            <div class="col-md-12 col-lg-12 q5-a-1">
              <label for="" class="font-weight-nomal">本人　： <?php echo (@$q5[$interview->q5_i_1]) ? $q5[$interview->q5_i_1] : ''; ?></label>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-lg-12 group-q-child">
              <label for="" class="font-weight-nomal">保護者　： <?php echo (@$q5[$interview->q5_i_2]) ? $q5[$interview->q5_i_2] : ''; ?></label><br>
            </div>
          </div>
        </td>
      </tr>

      <!-- Q6 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q6</span>　先天性の疾患をお持ちですか？（保険診療が可能な場合があります）</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q6_kind) && $interview->q6_kind == 1 )
            はい
            <div class="col-md-12 col-lg-12">
              @if ( isset($interview->q6_sq_1) && $interview->q6_sq_1 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 唇顎口蓋裂</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_2) && $interview->q6_sq_2 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ゴールデンハー症候群(鰓弓異常症含む)</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_3) && $interview->q6_sq_3 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 鎖骨･頭蓋骨異骨形成</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_4) && $interview->q6_sq_4 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> クルーゾン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_5) && $interview->q6_sq_5 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> トリチャーコリンズ症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_6) && $interview->q6_sq_6 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ピエールロバン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_7) && $interview->q6_sq_7 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ダウン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_8) && $interview->q6_sq_8 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ラッセルシルバー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_9) && $interview->q6_sq_9 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ターナー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_10) && $interview->q6_sq_10 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ベックウィズ・ウィードマン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_11) && $interview->q6_sq_11 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 尖図合指症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_12) && $interview->q6_sq_12 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 先天性ミオパチー</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_13) && $interview->q6_sq_13 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 大理石骨病</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_14) && $interview->q6_sq_14 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 口-顔-指症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_15) && $interview->q6_sq_15 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> カブキ症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_16) && $interview->q6_sq_16 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ビンダー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_17) && $interview->q6_sq_17 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> クリッペル・トレノーネイ・ウェーバー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_18) && $interview->q6_sq_18 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 小舌症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_19) && $interview->q6_sq_19 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 骨形成不全症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_20) && $interview->q6_sq_20 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 口笛顔貌症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_21) && $interview->q6_sq_21 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ルビンスタイン・ティビ症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_22) && $interview->q6_sq_22 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 下垂体性小人症(成長ホルモン分泌不全症)</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_23) && $interview->q6_sq_23 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> リング18症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_24) && $interview->q6_sq_24 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 顔面半側肥大症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_25) && $interview->q6_sq_25 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> エリス・ヴァン・クレベルト症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_26) && $interview->q6_sq_26 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 軟骨形成不全症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_27) && $interview->q6_sq_27 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 外胚葉異形成症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_28) && $interview->q6_sq_28 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 神経線維腫症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_29) && $interview->q6_sq_29 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 基底細胞母斑症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_30) && $interview->q6_sq_30 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ヌーナン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_31) && $interview->q6_sq_31 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> マルファン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_32) && $interview->q6_sq_32 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> プラダーウィリー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_33) && $interview->q6_sq_33 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 顔面裂</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_34) && $interview->q6_sq_34 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ロンベルグ症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_35) && $interview->q6_sq_35 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 筋ジストロフィー</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_36) && $interview->q6_sq_36 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 色素失調症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_37) && $interview->q6_sq_37 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> メービウス症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_38) && $interview->q6_sq_38 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ウィリアムズ症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_39) && $interview->q6_sq_39 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> スティックラー症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_40) && $interview->q6_sq_40 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 常染色体欠失症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_41) && $interview->q6_sq_41 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 頭蓋骨癒合症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_42) && $interview->q6_sq_42 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ラーセン症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_43) && $interview->q6_sq_43 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 濃化異骨症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_44) && $interview->q6_sq_44 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> 6歯以上の非症候性部分性無歯症</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_45) && $interview->q6_sq_45 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> マーシャル症候群</label>&nbsp;&nbsp;
              </div>
              @endif
              @if ( isset($interview->q6_sq_46) && $interview->q6_sq_46 == 1 )
              <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                <label class="font-weight-nomal"> ポリエックス症候群(クラインフェルダー症候群)</label>&nbsp;&nbsp;
              </div>
              @endif
            </div>
            @elseif ( isset($interview->q6_kind) && $interview->q6_kind == 2 )
            いいえ
            @elseif ( isset($interview->q6_kind) && $interview->q6_kind == 3 )
            わからない
            @endif
        </td>
      </tr>

      <!-- Q7 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q7</span>　大きな病気にかかったことがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q7_kind) && $interview->q7_kind == 1 )
            はい<br>
              <div class="col-md-12 col-lg-12">
                  @if ( isset($interview->q7_sq_1) && $interview->q7_sq_1 == 1 )
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"> 心臓病</label>&nbsp;&nbsp;
                  </div>
                  @endif
                  @if ( isset($interview->q7_sq_2) && $interview->q7_sq_2 == 1 )
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"> 肝臓病</label>&nbsp;&nbsp;
                  </div>
                  @endif
                  @if ( isset($interview->q7_sq_3) && $interview->q7_sq_3 == 1 )
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"> 脳梗塞&nbsp;&nbsp;</label>&nbsp;&nbsp;
                  </div>
                  @endif
                  @if ( isset($interview->q7_sq_4) && $interview->q7_sq_4 == 1 )
                  <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3">
                    <label class="font-weight-nomal"> その他 病名：{{ @$interview->q7_sq }}&nbsp;&nbsp;</label>&nbsp;&nbsp;
                  </div>
                  @endif
              </div>
            @elseif ( isset($interview->q7_kind) && $interview->q7_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q8 -->
      <tr>
        <td colspan="2"  class="col-title"><span class="span-q">Q8</span>　食べ物・薬・金属などでアレルギーを起こしたことがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q8_kind) && $interview->q8_kind == 1 )
            はい<br>
              @if ( isset($interview->q8_sq) )
              {{ @$interview->q8_sq }}
              @endif
            @elseif ( isset($interview->q8_kind) && $interview->q8_kind == 2 )
            いいえ
            @elseif ( isset($interview->q8_kind) && $interview->q8_kind == 3 )
            わからない
            @endif
        </td>
      </tr>

      <!-- Q9 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q9</span>　感染症（B型肝炎、C型肝炎、HIV、梅毒）にかかっていますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q9_kind) && $interview->q9_kind == 1 )
            はい
            @elseif ( isset($interview->q9_kind) && $interview->q9_kind == 2 )
            いいえ
            @elseif ( isset($interview->q9_kind) && $interview->q9_kind == 3 )
            わからない
            @endif
        </td>
      </tr>

      <!-- Q10 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q10</span>　現在、歯科以外に病院に通院されていますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q10_kind) && $interview->q10_kind == 1 )
            はい<br>
                病院名:{{ @$interview->q10_sq_1 }} {{ @$interview->q10_sq_2 }} 科
            @elseif ( isset($interview->q10_kind) && $interview->q10_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q11 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q11</span>　現在服用している薬はありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q11_kind) && $interview->q11_kind == 1 )
            はい<br>
                お薬の名称:{{ @$interview->q11_sq }}
            @elseif ( isset($interview->q11_kind) && $interview->q11_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q12 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q12</span>　現在、妊娠されていますか？また、その可能性がありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q12_kind) && $interview->q12_kind == 1 )
            はい
            @elseif ( isset($interview->q11_kind) && $interview->q11_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q13 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q13</span>　過去に顔や、あご、歯を強く打ったことがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q13_kind) && $interview->q13_kind == 1 )
            はい<br>
            部位： {{ @$interview->q13_sq_1 }} 病院名： {{ @$interview->q13_sq_2 }} {{ @$interview->q13_sq_3 }} 科
            @elseif ( isset($interview->q13_kind) && $interview->q13_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q14 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q14</span>　鼻がよく詰まりますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q14_kind) && $interview->q14_kind == 1 )
            はい<br>
            原因は？： {{ @$interview->q14_sq }}
            @elseif ( isset($interview->q14_kind) && $interview->q14_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q15 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q15</span>　発言しにくい言葉がありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q15_kind) && $interview->q15_kind == 1 )
            はい<br>
            たとえば、それはどんな言葉ですか？： {{ @$interview->q15_sq }}
            @elseif ( isset($interview->q15_kind) && $interview->q15_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q16 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q16</span>　指をしゃぶる癖や、つめをかむ癖、ほおづえをつくことがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q16_kind) && $interview->q16_kind == 1 )
            はい(現在進行形)
            @elseif ( isset($interview->q16_kind) && $interview->q16_kind == 2 )
            はい(過去形)<br>
            {{ @$interview->q16_sq }}歳ごろまで
            @elseif ( isset($interview->q16_kind) && $interview->q16_kind == 3 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q17 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q17</span>　歯ぎしりをしますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q17_kind) && $interview->q17_kind == 1 )
            はい
            @elseif ( isset($interview->q17_kind) && $interview->q17_kind == 2 )
            いいえ
            @elseif ( isset($interview->q17_kind) && $interview->q17_kind == 3 )
            わからない
            @endif
        </td>
      </tr>

      <!-- Q18 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q18</span>　たびたび、頭痛や関節の痛みがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q18_kind) && $interview->q18_kind == 1 )
            はい
            @elseif ( isset($interview->q18_kind) && $interview->q18_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q19 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q19</span>　食べ物で食べにくいものがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q19_kind) && $interview->q19_kind == 1 )
            はい<br>
            それは何ですか？：{{ @$interview->q19_sq }}
            @elseif ( isset($interview->q19_kind) && $interview->q19_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

        <!-- Q20 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q20</span>　矯正治療を受ける上で留意してほしいことがら（体質や各種障害）はありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q20_kind) && $interview->q20_kind == 1 )
            はい<br>
            内容：{{ @$interview->q20_sq }}
            @elseif ( isset($interview->q20_kind) && $interview->q20_kind == 2 )
            いいえ
            @endif
        </td>
      </tr>

      <!-- Q21 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q21</span>　現在治療中の歯がありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
            @if ( isset($interview->q21_kind) && $interview->q21_kind == 1 )
            はい<br>
            部位： {{ @$interview->q21_sq_1 }} 治療内容：{{ @$interview->q21_sq_2 }}
            @elseif ( isset($interview->q21_kind) && $interview->q21_kind == 2 )
            いいえ<br>
            最後に歯医者にかかったのは何歳ごろですか？：{{ @$interview->q21_sq_3 }}
            @endif
        </td>
      </tr>

      <!-- Q22 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q22</span>　今、歯並び以外で気にされていることはありますか？（例：親知らずが痛い、詰め物が取れているなど）</td>
      </tr>
      <tr>
        <td colspan="2">{{ @$interview->q22 }}</td>
      </tr>

      <!-- Q23 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q23</span>　過去に矯正治療の相談を受けたことがありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
          @if ( isset($interview->q23_kind) && $interview->q23_kind == 1 )
          {{ @$interview->q23_sq }}
          @endif
        </td>
      </tr>

      <!-- Q24 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q24</span>　現在、ご家族・ご親戚の方が矯正治療を受けられていれば、お名前と続柄を教えてください</td>
      </tr>
      <tr>
        <td colspan="2">
          @if ( isset($interview->q24_kind) && $interview->q24_kind == 1 )
          {{ @$interview->q24_sq_1 }}
          {{ @$interview->q24_sq_2 }}
          {{ @$interview->q24_sq_3 }}
          @endif
        </td>
      </tr>

      <!-- Q25 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q25</span>　過去、ご家族・ご親戚の方で矯正治療を受けた方がいらっしゃれば、お名前と続柄を教えて下さい</td>
      </tr>
      <tr>
        <td colspan="2">
          @if ( isset($interview->q25_kind) && $interview->q25_kind == 1 )
          {{ @$interview->q25_sq_1 }}
          {{ @$interview->q25_sq_2 }}
          {{ @$interview->q25_sq_3 }}
          @endif
        </td>
      </tr>

      <!-- Q26 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q26</span>　転勤・引越し・留学等のご予定はありますか？</td>
      </tr>
      <tr>
        <td colspan="2">
          @if ( isset($interview->q26_kind) && $interview->q26_kind == 1 )
          {{ @$interview->q26_sq }}
          @endif
        </td>
      </tr>

      <!-- Q27 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q27</span>　以下の項目のうち、気になるものを選択してください</td>
      </tr>
      <tr>
        <td colspan="2">
          @if ( !empty($interview->q27_1) )
          矯正装置が入っている期間、保定装置の期間など治療期間について気になる<br />
          @endif
          @if ( !empty($interview->q27_2) )
          治療費がどのくらいになるか気になる<br />
          @endif
          @if ( !empty($interview->q27_3) )
          仕事上、接客の機会が多いので、支障が無いか、気になる<br />
          @endif
          @if ( !empty($interview->q27_4) )
          スポーツをしている\<br />
          @endif
          @if ( !empty($interview->q27_5) )
          管楽器の演奏をすることがある<br />
          @endif
          @if ( !empty($interview->q27_6) )
          普段の生活で、(受験・仕事など)ストレスがかかることがある<br />
          @endif
        </td>
      </tr>

      <!-- Q28 -->
      <tr>
        <td colspan="2" class="col-title"><span class="span-q">Q28</span>　その他、矯正治療を進めていく上で、ご不安・ご希望の点があればお書きください</td>
      </tr>
      <tr>
        <td colspan="2">{!! nl2br(@$interview->q28) !!}</td>
      </tr>
    </tbody>
  </table>
  <div class="float-left margin-bottom">
    <div class="text-center">
      <input type="submit" name="button" onClick="history.back()" value="戻る" class="btn btn-sm btn-page mar-right">
    </div>
  </div>
</div>


@endsection