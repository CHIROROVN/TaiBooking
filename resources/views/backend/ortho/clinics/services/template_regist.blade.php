@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic service regist -->
    <section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>医院情報管理　＞　{{ $clinic->clinic_name }}　＞　業務自動枠の一覧　＞　{{ $service->service_name }}　＞　使用設備と時間の新規登録</h3>
            <div class="table-responsive">
            {!! Form::open( ['id' => 'frmClinicServiceRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.clinics.services.template_edit', $clinic->clinic_id, $service->service_id, $clinic_service], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
              <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_1">使用する設備-1</label></td>
              <td>
                <input id="service_facility_1_chair_null" type="radio" value="" name="service_facility_1_chair" checked="">使用しない &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="service_facility_1_chair" id="service_facility_1_chair" value="-1" >
                治療（チェア）　　　
                <input type="radio" name="service_facility_1_chair" id="service_facility_1_other" value="1" @if(old('service_facility_1_chair') == '1') checked @endif >
                治療以外→
                <select name="service_facility_1" id="service_facility_1" class="form-control form-control--small sf1">
                  <option value="" selected="selected">▼選択</option>
                  @if($facilities)
                    @foreach($facilities as $key1 => $facility1)
                      <option value="{{$key1}}" @if(old('service_facility_1') == $key1) selected="selected" @endif>{{$facility1}}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->first('service_facility_1'))
                    <span class="error-input">※ {!! $errors->first('service_facility_1') !!}</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_1">時間-1</label></td>
              <td>
                <select name="service_time_1" id="service_time_1" class="form-control form-control--small">
                  <option value="" @if(old('service_time_1') == '') selected="selected" @endif>----</option>
                  <option value="15" @if(old('service_time_1') == '15') selected="selected" @endif>15分</option>
                  <option value="30" @if(old('service_time_1') == '30') selected="selected" @endif>30分</option>
                  <option value="45" @if(old('service_time_1') == '45') selected="selected" @endif>45分</option>
                  <option value="60" @if(old('service_time_1') == '60') selected="selected" @endif>60分</option>
                  <option value="75" @if(old('service_time_1') == '75') selected="selected" @endif>75分</option>
                  <option value="90" @if(old('service_time_1') == '90') selected="selected" @endif>90分</option>
                  <option value="105" @if(old('service_time_1') == '105') selected="selected" @endif>105分</option>
                  <option value="120" @if(old('service_time_1') == '120') selected="selected" @endif>120分</option>
                </select>
                @if ($errors->first('service_time_1'))
                    <span class="error-input">※ {!! $errors->first('service_time_1') !!}</span>
                @endif
              </td>
            </tr>
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_2">使用する設備-2</label></td>
              <td>
                <input id="service_facility_2_chair_null" type="radio" value="" name="service_facility_2_chair" checked="">使用しない &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="service_facility_2_chair" id="service_facility_2_chair" value="-1" >
                治療（チェア）　　　
                <input type="radio" name="service_facility_2_chair" id="service_facility_2_other" value="1" @if(old('service_facility_2_chair') == '1') checked @endif >
                治療以外→
                <select name="service_facility_2" id="service_facility_2" class="form-control form-control--small sf2">
                  <option value="" selected="selected">▼選択</option>
                  @if($facilities)
                    @foreach($facilities as $key2 => $facility2)
                      <option value="{{$key2}}" @if(old('service_facility_2') == $key2) selected="selected" @endif>{{$facility2}}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->first('service_facility_2'))
                    <span class="error-input">※ {!! $errors->first('service_facility_2') !!}</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_2">時間-2</label></td>
              <td>
                <select name="service_time_2" id="service_time_2" class="form-control form-control--small">
                  <option value="" @if(old('service_time_2') == '') selected="selected" @endif>----</option>
                  <option value="15" @if(old('service_time_2') == '15') selected="selected" @endif>15分</option>
                  <option value="30" @if(old('service_time_2') == '30') selected="selected" @endif>30分</option>
                  <option value="45" @if(old('service_time_2') == '45') selected="selected" @endif>45分</option>
                  <option value="60" @if(old('service_time_2') == '60') selected="selected" @endif>60分</option>
                  <option value="75" @if(old('service_time_2') == '75') selected="selected" @endif>75分</option>
                  <option value="90" @if(old('service_time_2') == '90') selected="selected" @endif>90分</option>
                  <option value="105" @if(old('service_time_2') == '105') selected="selected" @endif>105分</option>
                  <option value="120" @if(old('service_time_2') == '120') selected="selected" @endif>120分</option>
                </select>
              </td>
              @if ($errors->first('service_time_2'))
                    <span class="error-input">※ {!! $errors->first('service_time_2') !!}</span>
                @endif
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_3">使用する設備-3</label></td>
              <td>
                <input id="service_facility_3_chair_null" type="radio" value="" name="service_facility_3_chair" checked="">使用しない &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="service_facility_3_chair" id="service_facility_3_chair" value="-1" >
                治療（チェア）　　　
                <input type="radio" name="service_facility_3_chair" id="service_facility_3_other" value="1" @if(old('service_facility_3_chair') == '1') checked @endif >
                治療以外→
                <select name="service_facility_3" id="service_facility_3" class="form-control form-control--small sf3">
                  <option value="" selected="selected">▼選択</option>
                  @if($facilities)
                    @foreach($facilities as $key3 => $facility3)
                      <option value="{{$key3}}" @if(old('service_facility_3') == $key3) selected="selected" @endif>{{$facility3}}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->first('service_facility_3'))
                    <span class="error-input">※ {!! $errors->first('service_facility_3') !!}</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_3">時間-3</label></td>
              <td>
                <select name="service_time_3" id="service_time_3" class="form-control form-control--small">
                  <option value="" @if(old('service_time_3') == '') selected="selected" @endif>----</option>
                  <option value="15" @if(old('service_time_3') == '15') selected="selected" @endif>15分</option>
                  <option value="30" @if(old('service_time_3') == '30') selected="selected" @endif>30分</option>
                  <option value="45" @if(old('service_time_3') == '45') selected="selected" @endif>45分</option>
                  <option value="60" @if(old('service_time_3') == '60') selected="selected" @endif>60分</option>
                  <option value="75" @if(old('service_time_3') == '75') selected="selected" @endif>75分</option>
                  <option value="90" @if(old('service_time_3') == '90') selected="selected" @endif>90分</option>
                  <option value="105" @if(old('service_time_3') == '105') selected="selected" @endif>105分</option>
                  <option value="120" @if(old('service_time_3') == '120') selected="selected" @endif>120分</option>
                </select>
                @if ($errors->first('service_time_3'))
                    <span class="error-input">※ {!! $errors->first('service_time_3') !!}</span>
                @endif
              </td>
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_4">使用する設備-4</label></td>
              <td>
                <input id="service_facility_4_chair_null" type="radio" value="" name="service_facility_4_chair" checked="">使用しない &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="service_facility_4_chair" id="service_facility_4_chair" value="-1" >
                治療（チェア）　　　
                <input type="radio" name="service_facility_4_chair" id="service_facility_4_other" value="1" @if(old('service_facility_4_chair') == '1') checked @endif>
                治療以外→
                <select name="service_facility_4" id="service_facility_4" class="form-control form-control--small sf4">
                  <option value="" selected="selected">▼選択</option>
                  @if($facilities)
                    @foreach($facilities as $key4 => $facility4)
                      <option value="{{$key4}}" @if(old('service_facility_4') == $key4) selected="selected" @endif>{{$facility4}}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->first('service_facility_4'))
                    <span class="error-input">※ {!! $errors->first('service_facility_4') !!}</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_4">時間-4</label></td>
              <td>
                <select name="service_time_4" id="service_time_4" class="form-control form-control--small">
                  <option value="" @if(old('service_time_4') == '') selected="selected" @endif>----</option>
                  <option value="15" @if(old('service_time_4') == '15') selected="selected" @endif>15分</option>
                  <option value="30" @if(old('service_time_4') == '30') selected="selected" @endif>30分</option>
                  <option value="45" @if(old('service_time_4') == '45') selected="selected" @endif>45分</option>
                  <option value="60" @if(old('service_time_4') == '60') selected="selected" @endif>60分</option>
                  <option value="75" @if(old('service_time_4') == '75') selected="selected" @endif>75分</option>
                  <option value="90" @if(old('service_time_4') == '90') selected="selected" @endif>90分</option>
                  <option value="105" @if(old('service_time_4') == '105') selected="selected" @endif>105分</option>
                  <option value="120" @if(old('service_time_4') == '120') selected="selected" @endif>120分</option>
                </select>
                @if ($errors->first('service_time_4'))
                    <span class="error-input">※ {!! $errors->first('service_time_4') !!}</span>
                @endif
              </td>
            </tr
        </table>
        <br />
        <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="service_facility_5">使用する設備-5</label></td>
              <td>
                <input id="service_facility_5_chair_null" type="radio" value="" name="service_facility_5_chair" checked="">使用しない &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="service_facility_5_chair" id="service_facility_5_chair" value="-1" >
                治療（チェア）　　　
                <input type="radio" name="service_facility_5_chair" id="service_facility_5_other" value="1" @if(old('service_facility_5_chair') == '1') checked @endif >
                治療以外→
                <select name="service_facility_5" id="service_facility_5" class="form-control form-control--small sf5">
                  <option value="" selected="selected">▼選択</option>
                  @if($facilities)
                    @foreach($facilities as $key5 => $facility5)
                      <option value="{{$key5}}" @if(old('service_facility_5') == $key5) selected="selected" @endif>{{$facility5}}</option>
                    @endforeach
                  @endif
                </select>
                @if ($errors->first('service_facility_5'))
                    <span class="error-input">※ {!! $errors->first('service_facility_5') !!}</span>
                @endif
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_time_5">時間-5</label></td>
            <td>
            <select name="service_time_5" id="service_time_5" class="form-control form-control--small">
              <option value="" @if(old('service_time_5') == '') selected="selected" @endif>----</option>
              <option value="15" @if(old('service_time_5') == '15') selected="selected" @endif>15分</option>
              <option value="30" @if(old('service_time_5') == '30') selected="selected" @endif>30分</option>
              <option value="45" @if(old('service_time_5') == '45') selected="selected" @endif>45分</option>
              <option value="60" @if(old('service_time_5') == '60') selected="selected" @endif>60分</option>
              <option value="75" @if(old('service_time_5') == '75') selected="selected" @endif>75分</option>
              <option value="90" @if(old('service_time_5') == '90') selected="selected" @endif>90分</option>
              <option value="105" @if(old('service_time_5') == '105') selected="selected" @endif>105分</option>
              <option value="120" @if(old('service_time_5') == '120') selected="selected" @endif>120分</option>
            </select>
            @if ($errors->first('service_time_5'))
                    <span class="error-input">※ {!! $errors->first('service_time_5') !!}</span>
                @endif
          </td>
        </tr>
      </table>
              <br />
            </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="submit" name="button" id="button" value="登録する" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onClick="location.href='{{route('ortho.facilities.index', [ $clinic->clinic_id ])}}'" value="登録済み自動枠の構成一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </section>
  <!-- End content clinic service regist -->

  <script type="text/javascript">
    $('.sf1').click(function(event) {
      $("#service_facility_1_other").prop("checked", true); 
    });
    $('.sf2').click(function(event) {
      $("#service_facility_2_other").prop("checked", true); 
    });
    $('.sf3').click(function(event) {
      $("#service_facility_3_other").prop("checked", true); 
    });
    $('.sf4').click(function(event) {
      $("#service_facility_4_other").prop("checked", true); 
    });
    $('.sf5').click(function(event) {
      $("#service_facility_5_other").prop("checked", true); 
    });

    $('#service_facility_1_chair_null').click(function(event) {
      $("#service_time_1 option:selected").removeAttr("selected");
      $('#service_time_1 option[value=""]').attr('selected','selected');
    });
    $('#service_facility_2_chair_null').click(function(event) {
      $("#service_time_2 option:selected").removeAttr("selected");
      $('#service_time_2 option[value=""]').attr('selected','selected');
    });
    $('#service_facility_3_chair_null').click(function(event) {
      $("#service_time_3 option:selected").removeAttr("selected");
      $('#service_time_3 option[value=""]').attr('selected','selected');
    });
    $('#service_facility_4_chair_null').click(function(event) {
      $("#service_time_4 option:selected").removeAttr("selected");
      $('#service_time_4 option[value=""]').attr('selected','selected');
    });
    $('#service_facility_5_chair_null').click(function(event) {
      $("#service_time_5 option:selected").removeAttr("selected");
      $('#service_time_5 option[value=""]').attr('selected','selected');
    });

  </script>
@endsection