@extends('backend.ortho.ortho')

@section('content')
{!! Form::open(array('route' => ['ortho.bookings.booking.1st.regist',$booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　新患予約の新規登録</h3>
        <div class="msg-alert-action margin-top-15">
              @if ($message = Session::get('success'))
                <div class="alert alert-success  alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
                </div>
              @elseif($message = Session::get('danger'))
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
                </div>
              @endif
            </div>
        <div class="table-responsive">
          <table class="table table-bordered">

            <!-- p_name -->
            <tr>
              <td class="col-title"><label for="p_name">患者名</label></td>
              <td><input type="text" name="p_name" id="p_name" class="form-control" value="{{ old('p_name') }}" />
                @if ($errors->first('p_name'))
                    <span class="error-input">※ {!! $errors->first('p_name') !!}</span>
                @endif
              </td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_kana">患者名よみ</label></td>
              <td><input type="text" name="p_name_kana" id="p_name_kana" class="form-control" value="{{ old('p_name_kana') }}" />
                @if ($errors->first('p_name_kana'))
                    <span class="error-input">※ {!! $errors->first('p_name_kana') !!}</span>
                @endif
              </td>
            </tr>

            <!-- p_sex -->
            <tr>
              <td class="col-title">性別</td>
              <td>
                <div class="row">
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="1" @if(old('p_sex') == 1) checked="" @endif /> 男
                  </div>
                  <div class="col-xs-4 col-sm-2 col-md-1">
                    <input type="radio" name="p_sex" value="2" @if(old('p_sex') == 2) checked="" @endif /> 女
                  </div>
                </div>
                @if ($errors->first('p_sex'))
                    <span class="error-input">※ {!! $errors->first('p_sex') !!}</span>
                @endif
              </td>
            </tr>

            <!-- p_tel -->
            <tr>
              <td class="col-title"><label for="p_tel">電話番号</label></td>
              <td><input type="text" name="p_tel" id="p_tel" class="form-control" value="{{ old('p_tel') }}" /></td>
            </tr>

            <!-- if check -> insert to table "t_1st" -->
            <tr>
              <td class="col-title"><label for="insert_to_tbl_first">問診票の入力</label></td>
              <td>
                <div class="checkbox">
                  <label><input type="checkbox" name="insert_to_tbl_first" id="insert_to_tbl_first" value="1" @if(old('insert_to_tbl_first') == 1) checked="" @endif />初診者一覧にも自動登録（＝問診票の新規登録）</label>
                </div>
              </td>
            </tr>

            <!-- booking_date -->
            <tr>
              <td class="col-title"><label for="cbReservation">予約日時</label></td>
              <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}
              </td>
            </tr>

            <!-- clinic_id -->
            <tr>
              <td class="col-title">医院</td>
              <td>{{$booking->clinic_name}}</td>
            </tr>

            <!-- facility_id -->
            <!-- <tr>
              <td class="col-title"><label for="facility_id">設備</label></td>
              <td><select name="facility_id" id="facility_id" class="form-control">
                <option value="">▼選択</option>
                  @if(count($facilities) > 0)
                  @foreach($facilities as $key => $facility)
                    <option value="{{$key}}" @if($booking->facility_id == $key) selected @endif>{{$facility}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr> -->

            <!-- doctor_id -->
            <tr>
              <td class="col-title"><label for="doctor_id">ドクター</label></td>
              <td><select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">▼選択</option>
                @if(count($doctors) > 0)
                  @foreach($doctors as $doctor)
                    <option value="{{$doctor->id}}" @if($booking->doctor_id == $doctor->id) selected @endif>{{$doctor->u_name}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr>

            <!-- hygienist_id -->
            <tr>
              <td class="col-title"><label for="hygienist_id">衛生士</label></td>
              <td><select name="hygienist_id" id="hygienist_id" class="form-control">
                <option value="">▼選択</option>
                @if(count($hygienists) > 0)
                  @foreach($hygienists as $hygienist)
                    <option value="{{$hygienist->id}}" @if($booking->hygienist_id == $hygienist->id) selected @endif>{{$hygienist->u_name}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr>

            <!-- equipment_id -->
            <tr>
              <td class="col-title"><label for="equipment_id">装置</label></td>
              <td>
                <select name="equipment_id" id="equipment_id" class="form-control">
                  <option value="">▼選択</option>
                  @if(count($equipments) > 0)
                  @foreach($equipments as $key => $equipment)
                    <option value="{{$key}}" @if($booking->equipment_id == $key) selected @endif>{{$equipment}}</option>
                  @endforeach
                @endif
                </select>
              </td>
            </tr>

              <!-- service_1 -->
            <tr>
              <td class="col-title"><label for="service_1">業務内容-1</label></td>
              <td>
                @if ( $booking->service_1_kind == 1 )
                {{ @$services[$booking->service_1] }}
                @else
                <select name="service_1" id="service_1" class="form-control">
                  <option value="-1">▼選択</option>
                    @if(count($treatment1s) > 0)
                      @foreach($treatment1s as $key12 => $treatment12)
                        <option value="{{$key12}}#sk12" @if($booking->service_1 == $key12) selected @endif>{{$treatment12}}</option>
                      @endforeach
                    @endif
                </select>
                @endif
              </td>
            </tr>

            <!-- service_2 -->
            <!-- <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      @if(count($services) > 0)
                        @foreach($services as $key21 => $service21)
                        <option value="{{$key21}}#sk21" @if($booking->service_2 == $key21) selected @endif >{{$service21}}</option>
                      @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="治療内容">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $key22 => $treatment22)
                            <option value="{{$key22}}#sk22" @if($booking->service_2 == $key22) selected @endif>{{$treatment22}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr> -->

            <!-- inspection_id -->
            <tr>
              <td class="col-title"><label for="inspection_id">検査</label></td>
             <td>
                <select name="inspection_id" id="inspection_id" class="form-control">
                  <option>▼選択</option>
                    @if(count($inspections) > 0)
                    @foreach($inspections as $key => $inspection)
                      <option value="{{$key}}" @if($booking->inspection_id == $key) selected @endif>{{$inspection}}</option>
                    @endforeach
                  @endif
                </select>
              </td>
            </tr>

            <!-- insurance_id -->
            <tr>
              <td class="col-title"><label for="insurance_id">保険診療</label></td>
              <td>
                <select name="insurance_id" id="insurance_id" class="form-control">
                  <option value="">▼選択</option>
                    @if(count($insurances) > 0)
                    @foreach($insurances as $key => $insurance)
                      <option value="{{$key}}" @if($booking->insurance_id == $key) selected @endif>{{$insurance}}</option>
                    @endforeach
                  @endif
                </select>
              </td>
            </tr>

              <!-- emergency_flag -->
            <tr>
              <td class="col-title"><label for="emergency_flag">救急</label></td>
              <td>
                <div class="checkbox">
                  <label> <input name="emergency_flag" type="checkbox" id="emergency_flag"@if($booking->emergency_flag == 1) checked @endif>救急です</label>
                </div>
              </td>
            </tr>
            </tr>

              <!-- booking_status -->
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>
                <div class="radio">
                  <label><input name="booking_status" value="1" type="radio" @if($booking->booking_status == 1) checked @endif>通常</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="2" type="radio" @if($booking->booking_status == 2) checked @endif>「TEL待ち」です</label>
                </div>
                <div class="radio">
                  <label>
                    <input name="booking_status" value="3" id="recalling" type="radio" @if($booking->booking_status == 3) checked @endif>「リコール」です→
                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                    <?php $year =  date('Y', strtotime($booking->booking_date))?>
                      <option value="" selected>▼選択</option>
                      <option value="{{$year}}01" @if($year.'01' == $booking->booking_recall_ym) selected @endif>1ヶ月後</option>
                      <option value="{{$year}}02" @if($year.'02' == $booking->booking_recall_ym) selected @endif>2ヶ月後</option>
                      <option value="{{$year}}03" @if($year.'03' == $booking->booking_recall_ym) selected @endif>3ヶ月後</option>
                      <option value="{{$year}}04" @if($year.'04' == $booking->booking_recall_ym) selected @endif>4ヶ月後</option>
                      <option value="{{$year}}05" @if($year.'05' == $booking->booking_recall_ym) selected @endif>5ヶ月後</option>
                      <option value="{{$year}}06" @if($year.'06' == $booking->booking_recall_ym) selected @endif>6ヶ月後</option>
                    </select>
                  </label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="4" type="radio" @if($booking->booking_status == 4) checked @endif>未作成技工物TEL待ち</label>
                </div>
                <div class="radio">
                  <label><input name="booking_status" value="5" type="radio" @if($booking->booking_status == 5) checked @endif>作成済み技工物キャンセル</label>
                </div>
              </td>
            </tr>

            <!-- booking_memo -->
            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area">{{@$booking->booking_memo}}</textarea></td>
            </tr>
          </table>
        </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="btnSave" value="登録する" class="btn btn-sm btn-page">
    </div>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="history.back()" value="前の画面に戻る" class="btn btn-sm btn-page mar-right">
      </div>
    </div>
  </div>
</section>
</form>
<script type="text/javascript">
  $('#booking_recall_ym').click(function() {
    $('#recalling').attr("checked", "checked");
  });
</script>
@endsection