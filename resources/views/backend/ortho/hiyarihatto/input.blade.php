<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>オーソネットワーク予約管理システム</title>
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link href="{{asset('public')}}/backend/ortho/common/css/import.css" rel="stylesheet">
<link href="{{asset('public')}}/backend/ortho/common/css/page.css" rel="stylesheet">
</head>
<body class="body-login">
  <!-- Header -->
    <header>
      <div class="container-fluid">
        <div class="row">
          <h1><img src="{{ asset('') }}public/backend/ortho/common/image/logo.png" /></h1>
        </div>
      </div>
    </header>
  <!-- End Header -->

  <!-- Content equiment list -->
  <section id="page">
    <div class="container">  
      <div class="content-page">
        <h3>ヒヤリハット報告フォーム</h3>
        {!! Form::open(array('route' => 'ortho.hiyarihatto.input', 'method'=>'post', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8')) !!}
        <ul class="hiyarihatto">
          <li>
            <h4>1. 発生した時間と場所（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-md-12">
                <input name="year" id="year" value="{{old('year')}}" class="form-control form-control--xs text" type="text" style="text-align: center;"> 年
                <input name="month" id="month" value="{{old('year')}}" class="form-control form-control--xs" style="text-align: center;" type="text"> 月
                <input name="day" id="day" value="{{old('day')}}" class="form-control form-control--xs" type="text" style="text-align: center;"> 日
                <select name="hour" id="hour" class="form-control form-control--xs" style="text-align: center;">
                  <option value="" style="text-align: center;">--</option>
                  @for($i=0; $i<=23; $i++)
                    <option value="{{convert2Digit($i)}}" style="text-align: center;" @if(old('hour')) selected="" @endif>{{convert2Digit($i)}}</option>
                  @endfor
                </select>
                 時頃 
                <input name="dateNow" id="dateNow" value="←今日の日付" type="button" class="btn btn-xs btn-page">
              </div>
                @if ($errors->first('year'))
                      <span class="error-input">※ {!! $errors->first('year') !!}</span>
                @endif
                @if ($errors->first('month'))
                    <span class="error-input">※ {!! $errors->first('month') !!}</span>
              @endif
              @if ($errors->first('day'))
                    <span class="error-input">※ {!! $errors->first('day') !!}</span>
              @endif
              @if ($errors->first('hour'))
                    <span class="error-input">※ {!! $errors->first('hour') !!}</span>
              @endif
              <div class="col-md-12 mar-top20">
                場所： <input name="place" value="{{old('place')}}" class="form-control form-control--sm" type="text">
              </div>
              @if ($errors->first('place'))
                  <span class="error-input">※ {!! $errors->first('place') !!}</span>
              @endif
            </div>
          </li>
          <li>
            <h4>2. 患者様の性別と年齢</h4>
            <div class="row margin-left-33">
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                    <label><input name="sex" value="男" type="radio" checked="" @if(old('sex') == '男') checked="" @endif >男</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                    <label><input name="sex" value="女" type="radio" @if(old('sex') == '女') checked="" @endif>女</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                    <label><input name="sex" value="不明" type="radio" @if(old('sex') == '不明') checked="" @endif>不明</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                年齢 <input name="age" value="{{old('age')}}" class="form-control form-control--xs" type="text" maxlength="3">  歳
                </div>
                @if ($errors->first('age'))
                    <span class="error-input">※ {!! $errors->first('age') !!}</span>
              @endif
              </div>
            </div>
          </li>
          <li>
            <h4>3. 今、記入しているあなたは、発見者ですか？当事者ですか？（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                    <label><input name="discoverer" value="発見者" type="radio" @if(old('discoverer') == '発見者') checked="" @endif > 発見者</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="radio">
                    <label><input name="discoverer" value="当事者" type="radio" @if(old('discoverer') == '当事者') checked="" @endif > 当事者</label>
                </div>
              </div>
            </div>
            @if ($errors->first('discoverer'))
                  <span class="error-input">※ {!! $errors->first('discoverer') !!}</span>
              @endif
          </li>
          <li>
            <h4>4. 当事者の職種（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="dentist" value="歯科医師" type="checkbox" @if(old('dentist') == '歯科医師') checked="" @endif >歯科医師</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="hygienist" value="歯科衛生士" type="checkbox" @if(old('hygienist') == '歯科衛生士') checked="" @endif >歯科衛生士</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="technician" value="歯科技工士" type="checkbox" @if(old('technician') == '歯科技工士') checked="" @endif >歯科技工士</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="nurse" value="看護師　" type="checkbox" @if(old('nurse') == '看護師　') checked="" @endif >看護師　</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="secretary" value="事務（受付）職員" type="checkbox" @if(old('secretary') == '事務（受付）職員') checked="" @endif >  事務（受付）職員</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-3 col-md-2">
                <div class="checkbox">
                    <label><input name="other_cb" id="other_cb" value="その他" type="checkbox" @if(old('other_cb') == 'その他') checked="" @endif >  その他</label>
                    <input name="other_input_job" id="other_input_job" value="{{old('other_input_job')}}" class="form-control form-control--xs" type="text">
                </div>
              </div>
              @if ($errors->first('dentist'))
                    <span class="error-input">※ {!! $errors->first('dentist') !!}</span>
              @endif
              @if ($errors->first('hygienist'))
                    <span class="error-input">※ {!! $errors->first('hygienist') !!}</span>
              @endif
              @if ($errors->first('technician'))
                    <span class="error-input">※ {!! $errors->first('technician') !!}</span>
              @endif
              @if ($errors->first('nurse'))
                    <span class="error-input">※ {!! $errors->first('nurse') !!}</span>
              @endif
              @if ($errors->first('secretary'))
                    <span class="error-input">※ {!! $errors->first('secretary') !!}</span>
              @endif
              @if ($errors->first('other_cb'))
                    <span class="error-input">※ {!! $errors->first('other_cb') !!}</span>
              @endif
               @if ($errors->first('other_input_job'))
                    <span class="error-input">※ {!! $errors->first('other_input_job') !!}</span>
              @endif
            </div>
          </li>
          <li>
            <h4>5. ヒヤリハットが発生した場面（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-md-8">
                <textarea name="scene" cols="80" rows="3" id="scene" class="form-control form-control-full">{{old('scene')}}</textarea>
              </div>
            </div>
            @if ($errors->first('scene'))
                    <span class="error-input">※ {!! $errors->first('scene') !!}</span>
              @endif
          </li>
          <li>
            <h4>6. ヒヤリハットの内容（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-md-8">
                <textarea name="contents" cols="80" rows="3" id="contents" class="form-control form-control-full">{{old('contents')}}</textarea>
              </div>
            </div>
              @if ($errors->first('contents'))
                    <span class="error-input">※ {!! $errors->first('contents') !!}</span>
              @endif
          </li>
          <li>
            <h4>7. 発生要因（必須）</h4>
            <ul class="mar-top20 margin-left-33">
              <!-- Line 1 -->
              <li>
                <div class="row col-md-12">
                  <div class="checkbox">
                    <label><input name="party" id="party" value="当事者自身" type="checkbox" @if(old('party') == '当事者自身') checked="" @endif> 当事者自身</label>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="confirm" class="ready71" value="確認不足" type="checkbox" @if(old('confirm') == '確認不足') checked="" @endif> 確認不足 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="observation" class="ready71" value="観察不足" type="checkbox" @if(old('observation') == '観察不足') checked="" @endif> 観察不足 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="judgment" class="ready71" value="判断ミス" type="checkbox" @if(old('judgment') == '判断ミス') checked="" @endif> 判断ミス</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="knowledge" class="ready71" value="知識不足" type="checkbox" @if(old('knowledge') == '知識不足') checked="" @endif> 知識不足</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="technology" class="ready71" value="技術不足" type="checkbox" @if(old('technology') == '技術不足') checked="" @endif> 技術不足</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="corners" class="ready71" value="手抜き" type="checkbox" @if(old('corners') == '手抜き') checked="" @endif> 手抜き</label>
                    </div>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-md-9">
                    <textarea name="occurrence" class="ready71" cols="80" rows="3" id="occurrence" class="form-control form-control-full">{{old('occurrence')}}</textarea>
                  </div>
                </div>
              </li>
              @if ($errors->first('party'))
                    <span class="error-input">※ {!! $errors->first('party') !!}</span>
              @endif
              @if ($errors->first('confirm'))
                    <span class="error-input">※ {!! $errors->first('confirm') !!}</span>
              @endif
              @if ($errors->first('observation'))
                    <span class="error-input">※ {!! $errors->first('observation') !!}</span>
              @endif
              @if ($errors->first('judgment'))
                    <span class="error-input">※ {!! $errors->first('judgment') !!}</span>
              @endif
              @if ($errors->first('knowledge'))
                    <span class="error-input">※ {!! $errors->first('knowledge') !!}</span>
              @endif
              @if ($errors->first('technology'))
                    <span class="error-input">※ {!! $errors->first('technology') !!}</span>
              @endif
              @if ($errors->first('corners'))
                    <span class="error-input">※ {!! $errors->first('corners') !!}</span>
              @endif
              @if ($errors->first('occurrence'))
                    <span class="error-input">※ {!! $errors->first('occurrence') !!}</span>
              @endif
              <!-- Line 2 -->
              <li>
                <div class="row col-md-12">
                  <div class="checkbox">
                    <label><input name="affect_env" id="affect_env" value="当事者に影響を及ぼした環境等" type="checkbox" @if(old('affect_env') == '当事者に影響を及ぼした環境等') checked="" @endif > 当事者に影響を及ぼした環境等</label>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="contact" class="ready72" value="報告連絡の不備" type="checkbox" @if(old('contact') == '報告連絡の不備') checked="" @endif > 報告連絡の不備 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="transmission" class="ready72" value="指示伝達の不備" type="checkbox" @if(old('transmission') == '指示伝達の不備') checked="" @endif >  指示伝達の不備　 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="manual" class="ready72" value="マニュアルの不備" type="checkbox" @if(old('manual') == 'マニュアルの不備') checked="" @endif > マニュアルの不備</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="cooperation" class="ready72" value="スタッフ間の連携不適切" type="checkbox" @if(old('cooperation') == 'スタッフ間の連携不適切') checked="" @endif >  スタッフ間の連携不適切</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="mistake" class="ready72" value="記録ミス" type="checkbox" @if(old('misreading') == '記録ミス') checked="" @endif> 記録ミス </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="misreading" class="ready72" value="読み間違い" type="checkbox" @if(old('misreading') == '読み間違い') checked="" @endif> 読み間違い</label>
                    </div>
                  </div>
                </div>

                <div class="row margin-left-33">
                  <div class="col-md-9">
                    <textarea name="affect_text" class="ready72" cols="80" rows="3" id="affect_text" class="form-control form-control-full">{{old('affect_text')}}</textarea>
                  </div>
                </div>
                  @if ($errors->first('affect_env'))
                      <span class="error-input">※ {!! $errors->first('affect_env') !!}</span>
                  @endif
                  @if ($errors->first('contact'))
                      <span class="error-input">※ {!! $errors->first('contact') !!}</span>
                  @endif
                  @if ($errors->first('transmission'))
                      <span class="error-input">※ {!! $errors->first('transmission') !!}</span>
                  @endif
                  @if ($errors->first('manual'))
                      <span class="error-input">※ {!! $errors->first('manual') !!}</span>
                  @endif
                  @if ($errors->first('cooperation'))
                      <span class="error-input">※ {!! $errors->first('cooperation') !!}</span>
                  @endif
                  @if ($errors->first('mistake'))
                      <span class="error-input">※ {!! $errors->first('mistake') !!}</span>
                  @endif
                  @if ($errors->first('misreading'))
                      <span class="error-input">※ {!! $errors->first('misreading') !!}</span>
                  @endif
                  @if ($errors->first('affect_text'))
                      <span class="error-input">※ {!! $errors->first('affect_text') !!}</span>
                  @endif

              </li>
              <!-- Line 3 -->
              <li>
                <div class="row col-md-12">
                  <div class="checkbox">
                    <label><input name="medical_device" id="medical_device" value="医療用具・機器・薬剤・設備等" type="checkbox" @if(old('medical_device') == '医療用具・機器・薬剤・設備等') checked="" @endif > 医療用具・機器・薬剤・設備等</label>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="defect" class="ready73" value="欠陥不良品" type="checkbox" @if(old('defect') == '欠陥不良品') checked="" @endif>  欠陥不良品 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="fault" class="ready73" value="故障" type="checkbox" @if(old('fault') == '故障') checked="" @endif>   故障 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="handle" class="ready73" value="扱いが難しい" type="checkbox" @if(old('handle') == '扱いが難しい') checked="" @endif>  扱いが難しい</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="placement" class="ready73" value="扱いが難しい" type="checkbox" @if(old('placement') == '扱いが難しい') checked="" @endif>  配置が悪い</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="quantity" class="ready73" value="数量不足" type="checkbox" @if(old('quantity') == '数量不足') checked="" @endif>  数量不足</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="inappropriate" class="ready73" value="管理不適切" type="checkbox" @if(old('inappropriate') == '管理不適切') checked="" @endif>  管理不適切 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="malfunction" class="ready73" value="機器誤作動" type="checkbox" @if(old('malfunction') == '機器誤作動') checked="" @endif>  機器誤作動</label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="medical_error" class="ready73" value="処方投薬ミス" type="checkbox" @if(old('medical_error') == '処方投薬ミス') checked="" @endif >  処方投薬ミス</label>
                    </div>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-md-9">
                    <textarea name="medical_text" class="ready73" cols="80" rows="3" id="medical_text" class="form-control form-control-full">{{old('medical_text')}}</textarea>
                  </div>
                </div>
                @if ($errors->first('medical_device'))
                    <span class="error-input">※ {!! $errors->first('medical_device') !!}</span>
                @endif
                @if ($errors->first('defect'))
                    <span class="error-input">※ {!! $errors->first('defect') !!}</span>
                @endif
                @if ($errors->first('malfunction'))
                    <span class="error-input">※ {!! $errors->first('malfunction') !!}</span>
                @endif
                @if ($errors->first('handle'))
                    <span class="error-input">※ {!! $errors->first('handle') !!}</span>
                @endif
                @if ($errors->first('placement'))
                    <span class="error-input">※ {!! $errors->first('placement') !!}</span>
                @endif
                @if ($errors->first('quantity'))
                    <span class="error-input">※ {!! $errors->first('quantity') !!}</span>
                @endif
                @if ($errors->first('inappropriate'))
                    <span class="error-input">※ {!! $errors->first('inappropriate') !!}</span>
                @endif
                @if ($errors->first('malfunction'))
                    <span class="error-input">※ {!! $errors->first('malfunction') !!}</span>
                @endif
                @if ($errors->first('medical_error'))
                    <span class="error-input">※ {!! $errors->first('medical_error') !!}</span>
                @endif
                @if ($errors->first('medical_text'))
                    <span class="error-input">※ {!! $errors->first('medical_text') !!}</span>
                @endif
              </li>
              <!-- Line 4 -->
              <li>
                <div class="row col-md-12">
                  <div class="checkbox">
                    <label><input name="education" id="education" value="教育・訓練や説明・対応" type="checkbox" @if(old('education') == '教育・訓練や説明・対応') checked="" @endif> 教育・訓練や説明・対応</label>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="edu_training" class="ready74" value="教育・練習不足" type="checkbox" @if(old('edu_training') == '教育・練習不足') checked="" @endif > 教育・練習不足　 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="explan_patient" class="ready74" value="患者様への説明不足" type="checkbox" @if(old('explan_patient') == '患者様への説明不足') checked="" @endif> 患者様への説明不足 </label>
                    </div>
                  </div>
                  <div class="col-xs-6 col-sm-4 col-md-3">
                    <div class="checkbox">
                      <label><input name="understand_patient" class="ready74" value="患者様の理解不十分" type="checkbox" @if(old('understand_patient') == '患者様の理解不十分') checked="" @endif> 患者様の理解不十分</label>
                    </div>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-md-9">
                    <textarea name="edu_text" class="ready74" cols="80" rows="3" id="edu_text" class="form-control form-control-full">{{old('edu_text')}}</textarea>
                  </div>
                </div>
                  @if ($errors->first('education'))
                    <span class="error-input">※ {!! $errors->first('education') !!}</span>
                  @endif
                  @if ($errors->first('edu_training'))
                    <span class="error-input">※ {!! $errors->first('edu_training') !!}</span>
                  @endif
                  @if ($errors->first('explan_patient'))
                    <span class="error-input">※ {!! $errors->first('explan_patient') !!}</span>
                  @endif
                  @if ($errors->first('understand_patient'))
                    <span class="error-input">※ {!! $errors->first('understand_patient') !!}</span>
                  @endif
                  @if ($errors->first('edu_text'))
                    <span class="error-input">※ {!! $errors->first('edu_text') !!}</span>
                  @endif
              </li>
              <!-- Line 5 -->
              <li>
                <div class="row col-md-12">
                  <div class="checkbox">
                    <label><input name="other_chk" id="other_chk" value="その他" type="checkbox" @if(old('other_chk') == 'その他') checked="" @endif> その他</label>
                  </div>
                </div>
                <div class="row margin-left-33">
                  <div class="col-md-9">
                    <textarea name="other" cols="80" rows="3" id="other" class="form-control form-control-full">{{old('other')}}</textarea>
                  </div>
                </div>
                  @if ($errors->first('other_chk'))
                    <span class="error-input">※ {!! $errors->first('other_chk') !!}</span>
                  @endif
                  @if ($errors->first('other'))
                    <span class="error-input">※ {!! $errors->first('other') !!}</span>
                  @endif
              </li>
            </ul>
          </li>
          <li>
            <h4>8. 影響について（必須）</h4>
            <div class="row margin-left-33">
              <div class="col-md-9">
                <textarea name="impact" cols="80" rows="3" id="impact" class="form-control form-control-full">{{old('impact')}}</textarea>
              </div>
            </div>
            <div class="row margin-left-33 mar-top20">
              <div class="col-xs-12 col-sm-4 col-md-3 radio">
                患者様への影響があったかどうか　→
              </div>
              <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="radio">
                  <label><input name="impact_affect" value="影響あり" type="radio" @if(old('impact_affect') == '影響あり') checked="" @endif>  影響あり</label>
                </div>
              </div>
              <div class="col-xs-6 col-sm-4 col-md-3">
                <div class="radio">
                  <label><input name="impact_affect" value="影響なし" type="radio" @if(old('impact_affect') == '影響なし') checked="" @endif>  影響なし</label>
                </div>
              </div>
            </div>
              @if ($errors->first('impact'))
                      <span class="error-input">※ {!! $errors->first('impact') !!}</span>
              @endif
              @if ($errors->first('impact_affect'))
                      <span class="error-input">※ {!! $errors->first('impact_affect') !!}</span>
              @endif
          </li>
          <li>
            <h4>9. 解決策の提案</h4>
            <div class="row margin-left-33">
              <div class="col-md-9">
                <textarea name="solution" cols="80" rows="3" id="solution" class="form-control form-control-full">{{old('solution')}}</textarea>
              </div>
            </div>
          </li>
          <li>
            <h4>10. 差し支えなければ、あなたのお名前を教えてください。より詳しいお話しを聞かせていただく場合に使用します。（あなたの許可なく、四者会議のメンバー外に名前を開示することはありません）。</h4>
            <div class="row margin-left-33">
              <div class="col-md-12">
                お名前： <input name="name" value="{{old('name')}}" class="form-control form-control--default" type="text">
              </div>
            </div>
          </li>
        </ul>
        <div class="row mar-top20 margin-bottom">
          <div class="col-md-12 text-center">
            <input type="submit" value="確認画面へ" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
        <div class="row mar-top20 margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('ortho.login')}}'" value="ログイン画面に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </section>
<script src="{{ asset('') }}public/backend/ortho/common/js/jquery-1.9.1.min.js"></script>
<script  type="text/javascript" charset="utf-8" async defer>
  $( document ).ready(function() {
     if(!$('#other_cb').is(':checked')){
      $('input#other_input_job').prop('disabled', true);
    }else{
      $('input#other_input_job').prop('disabled', false);
    }

    if(!$('#other_chk').is(':checked')){
      $('#other').prop('disabled', true);
    }else{
      $('#other').prop('disabled', false);
    }

  //7.1
    if(!$('#party').is(':checked')){
      $('.ready71').prop('disabled', true);
    }else{
      $('.ready71').prop('disabled', false);
    }

    //7.2
    if(!$('#affect_env').is(':checked')){
      $('.ready72').prop('disabled', true);
    }else{
      $('.ready72').prop('disabled', false);
    }

    //7.3
    if(!$('#medical_device').is(':checked')){
      $('.ready73').prop('disabled', true);
    }else{
      $('.ready73').prop('disabled', false);
    }

  //7.4
    if(!$('#education').is(':checked')){
      $('.ready74').prop('disabled', true);
    }else{
      $('.ready74').prop('disabled', false);
    }

  });

  $('#other_cb').click(function(event) {
    if(!$(this).is(':checked')){
      $('input#other_input_job').prop('disabled', true);
    }else{
      $('input#other_input_job').prop('disabled', false);
    }
  });

  $('#other_chk').click(function(event) {
    if(!$(this).is(':checked')){
      $('#other').prop('disabled', true);
    }else{
      $('#other').prop('disabled', false);
    }
  });

  $('#party').click(function(event) {
    if(!$(this).is(':checked')){
      $('.ready71').prop('disabled', true);
    }else{
      $('.ready71').prop('disabled', false);
    }
  });

  $('#affect_env').click(function(event) {
    if(!$(this).is(':checked')){
      $('.ready72').prop('disabled', true);
    }else{
      $('.ready72').prop('disabled', false);
    }
  });

  $('#medical_device').click(function(event) {
    if(!$(this).is(':checked')){
      $('.ready73').prop('disabled', true);
    }else{
      $('.ready73').prop('disabled', false);
    }
  });

  $('#education').click(function(event) {
    if(!$(this).is(':checked')){
      $('.ready74').prop('disabled', true);
    }else{
      $('.ready74').prop('disabled', false);
    }
  });

  $('#dateNow').click(function(event) {
    var dt = new Date();
    var year = dt.getFullYear();
    var month = format2Digit(dt.getMonth()+1);
    var day = format2Digit(dt.getDate());
    var hour = format2Digit(dt.getHours());

    $('#year').val(year);
    $('#month').val(month);
    $('#day').val(day);
    $('#hour option[value="' + hour + '"]').prop('selected',true);
  });

  function format2Digit(num)
  {
    if(num < 10) { return '0'+num }
    else return num;
  }
</script>
  <!-- End content equiment list -->
</body>
</html>