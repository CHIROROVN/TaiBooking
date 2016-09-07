<!doctype html>
<html lang="ja">
<head>
<meta charset="utf-8">

<link href="{{asset('public')}}/backend/ortho/common/css/import.css" rel="stylesheet">
</head>
<body>
<?php $hiyar = (object) $hiyar; ?>
  <!-- Content equiment list -->
  <section id="page">
    <div class="container">  
      <div class="content-page">
        <ul class="hiyarihatto">
          <li>
            <h4>1. 発生した時間と場所</h4>
            <p>{{$hiyar->year}}年 {{$hiyar->month}}月 {{$hiyar->day}}日　 {{$hiyar->hour}}時頃<br />場所： {{$hiyar->place}}</p>
          </li>
          <li>
            <h4>2. 患者様の性別と年齢</h4>
            <p>{{$hiyar->sex}}　@if(!empty($hiyar->age))／　年齢 {{$hiyar->age}}歳 @endif</p>
          </li>
          <li>
            <h4>3. 今、記入しているあなたは、発見者ですか？当事者ですか？</h4>
            <p>{{$hiyar->discoverer}}</p>
          </li>
          <li>
            <h4>4. 当事者の職種</h4>
            <p>{{$hiyar->dentist}}</p>
            <p>{{$hiyar->hygienist}}</p>
            <p>{{$hiyar->technician}}</p>
            <p>{{$hiyar->nurse}}</p>
            <p>{{$hiyar->secretary}}</p>
            <p>{{$hiyar->dentist}}</p>
            <p>{{$hiyar->other_input_job}}</p>
          </li>
          <li>
            <h4>5. ヒヤリハットが発生した場面</h4>
            <p>{{$hiyar->scene}}</p>
          </li>
          <li>
            <h4>6. ヒヤリハットの内容</h4>
            <p>{{$hiyar->contents}}</p>
          </li>
          <li>
            <h4>7. 発生要因</h4>
            <p><strong>{{$hiyar->party}}</strong></p>
            <div class="space-line">
                {{$hiyar->confirm}}
                @if($hiyar->observation){{', '.$hiyar->observation}}@endif 
                @if($hiyar->judgment){{', '.$hiyar->judgment}}@endif 
                @if($hiyar->knowledge){{', '.$hiyar->knowledge}}@endif 
                @if($hiyar->technology){{', '.$hiyar->technology}}@endif 
                @if($hiyar->corners){{', '.$hiyar->corners}}@endif
            </div>
            <div class="space-line"><?php echo nl2br($hiyar->occurrence)?></div>


            <p><trong>{{$hiyar->affect_env}}</trong></p>
            <div class="space-line">
              {{$hiyar->contact}}
              @if($hiyar->transmission){{', '.$hiyar->transmission}}@endif
              @if($hiyar->manual){{', '.$hiyar->manual}}@endif
              @if($hiyar->mistake){{', '.$hiyar->mistake}}@endif
              @if($hiyar->misreading){{', '.$hiyar->misreading}}@endif
            </div>
            <div class="space-line"><?php echo nl2br($hiyar->affect_text)?></div></p>

            <p><strong>{{$hiyar->medical_device}}</strong></p>
            <div class="space-line">
              {{$hiyar->defect}}
              @if($hiyar->fault){{', '.$hiyar->fault}}@endif
              @if($hiyar->handle){{', '.$hiyar->handle}}@endif
              @if($hiyar->placement){{', '.$hiyar->placement}}@endif
              @if($hiyar->quantity){{', '.$hiyar->quantity}}@endif
              @if($hiyar->inappropriate){{', '.$hiyar->inappropriate}}@endif
              @if($hiyar->malfunction){{', '.$hiyar->malfunction}}@endif
              @if($hiyar->medical_error){{', '.$hiyar->medical_error}}@endif
            </div>
            <div class="space-line"><?php echo nl2br($hiyar->medical_text)?></div>

            <p><strong>{{$hiyar->education}}</strong></p>
            <div class="space-line">
              {{$hiyar->edu_training}}
              @if($hiyar->explan_patient){{', '.$hiyar->explan_patient}}@endif
              @if($hiyar->understand_patient){{', '.$hiyar->understand_patient}}@endif</p>
            </div>
            <div class="space-line"><?php echo nl2br($hiyar->edu_text)?></div>

            <p><strong>{{$hiyar->other_chk}}</strong></p>
            <div class="space-line"><?php echo nl2br($hiyar->other)?></div>
          </li>
          <li>
            <h4>8. 影響について</h4>
            <p><?php echo nl2br($hiyar->impact)?><br />患者様への影響があったかどうか　→　 {{$hiyar->impact_affect}}</p>
          </li>
          <li>
            <h4>9. 解決策の提案</h4>
            <p><?php echo nl2br($hiyar->solution)?></p>
          </li>
          <li>
            <h4>10. 差し支えなければ、あなたのお名前を教えてください。より詳しいお話しを聞かせていただく場合に使用します。（あなたの許可なく、四者会議のメンバー外に名前を開示することはありません）。</h4>
            <p>お名前： {{$hiyar->name}}</p>
          </li>
        </ul>
      </div>
    </div>
  </section>
  <!-- End content equiment list -->
</body>
</html>