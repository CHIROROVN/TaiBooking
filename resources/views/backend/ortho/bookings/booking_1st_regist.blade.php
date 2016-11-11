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
              <td class="col-title"><label for="p_name_f">患者名</label></td>
              <td><input type="text" name="p_name_f" id="p_name_f" class="form-control form-control--medium" value="{{ old('p_name_f') }}" />
                @if ($errors->first('p_name_f'))
                    <span class="error-input">※ {!! $errors->first('p_name_f') !!}</span>
                @endif
                <input type="text" name="p_name_g" id="p_name_g" class="form-control form-control--medium" value="{{ old('p_name_g') }}" />
                @if ($errors->first('p_name_g'))
                    <span class="error-input">※ {!! $errors->first('p_name_g') !!}</span>
                @endif
              </td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_f_kana">患者名よみ</label></td>
              <td><input type="text" name="p_name_f_kana" id="p_name_f_kana" class="form-control form-control--medium" value="{{ old('p_name_f_kana') }}" />
                @if ($errors->first('p_name_f_kana'))
                    <span class="error-input">※ {!! $errors->first('p_name_f_kana') !!}</span>
                @endif
                <input type="text" name="p_name_g_kana" id="p_name_g_kana" class="form-control form-control--medium" value="{{ old('p_name_g_kana') }}" />
                @if ($errors->first('p_name_g_kana'))
                    <span class="error-input">※ {!! $errors->first('p_name_g_kana') !!}</span>
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
                    @if ( old('doctor_id') == $doctor->id )
                    <option value="{{$doctor->id}}" selected >{{$doctor->u_name}}</option>
                    @elseif ( $booking->doctor_id == $doctor->id )
                    <option value="{{$doctor->id}}" selected >{{$doctor->u_name}}</option>
                    @else
                    <option value="{{$doctor->id}}" >{{$doctor->u_name}}</option>
                    @endif
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
                    @if ( old('hygienist_id') == $hygienist->id )
                    <option value="{{$hygienist->id}}" selected >{{$hygienist->u_name}}</option>
                    @elseif ( $booking->hygienist_id == $hygienist->id )
                    <option value="{{$hygienist->id}}" selected >{{$hygienist->u_name}}</option>
                    @else
                    <option value="{{$hygienist->id}}" >{{$hygienist->u_name}}</option>
                    @endif
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
                      @if ( old('equipment_id') == $key )
                      <option value="{{$key}}" selected >{{$equipment}}</option>
                      @elseif ( $booking->equipment_id == $key )
                      <option value="{{$key}}" selected >{{$equipment}}</option>
                      @else
                      <option value="{{$key}}" >{{$equipment}}</option>
                      @endif
                    @endforeach
                  @endif
                </select>
              </td>
            </tr>

              <!-- service_1 -->
            <tr>
              <td class="col-title"><label for="service_1">業務内容-1 <span class="note_required">※</span></label></td>
              <td>
                @if ( $booking->service_1_kind == 1 )
                {{ @$services[$booking->service_1] }}
                @else
                <select name="service_1" id="service_1" class="form-control">
                  <option value="-1">▼選択</option>
                    @if(count($treatment1s) > 0)
                      @foreach($treatment1s as $key12 => $treatment12)
                        <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk22" @if($booking->service_1 == $treatment12->treatment_id) selected @endif>{{$treatment12->treatment_name}}</option>
                      @endforeach
                    @endif
                </select>
                @endif
                <span class="error-input">@if ($errors->first('service_1')) {!! $errors->first('service_1') !!} @endif</span>
              </td>
            </tr>

            <!-- inspection_id -->
            <tr>
              <td class="col-title"><label for="inspection_id">検査</label></td>
             <td>
                <select name="inspection_id" id="inspection_id" class="form-control">
                  <option>▼選択</option>
                  @if(count($inspections) > 0)
                    @foreach($inspections as $key => $inspection)
                      @if ( old('inspection_id') == $key )
                      <option value="{{$key}}" selected >{{$inspection}}</option>
                      @elseif ( $booking->inspection_id == $key )
                      <option value="{{$key}}" selected >{{$inspection}}</option>
                      @else
                      <option value="{{$key}}" >{{$inspection}}</option>
                      @endif
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
                      @if ( old('insurance_id') == $key )
                      <option value="{{$key}}" selected >{{$insurance}}</option>
                      @elseif($booking->insurance_id == $key)
                      <option value="{{$key}}" selected >{{$insurance}}</option>
                      @else
                      <option value="{{$key}}" >{{$insurance}}</option>
                      @endif
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
                  @if( old('emergency_flag') == 1 )
                  <label> <input name="emergency_flag" value="1" type="checkbox" id="emergency_flag" checked >救急です</label>
                  @elseif ( $booking->emergency_flag == 1 )
                  <label> <input name="emergency_flag" value="1" type="checkbox" id="emergency_flag" checked >救急です</label>
                  @else
                  <label> <input name="emergency_flag" value="1" type="checkbox" id="emergency_flag" >救急です</label>
                  @endif
                </div>
              </td>
            </tr>
            </tr>

              <!-- booking_status -->
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>
                <div class="radio">
                  @if ( empty(old('booking_status')) )
                  <label><input name="booking_status" value="" type="radio" checked >通常</label>
                  @elseif ( empty($booking->booking_status) )
                  <label><input name="booking_status" value="" type="radio" checked >通常</label>
                  @else
                  <label><input name="booking_status" value="" type="radio" >通常</label>
                  @endif
                </div>
                <div class="radio">
                  @if ( old('booking_status') == 2 )
                  <label><input name="booking_status" value="2" type="radio" checked >無断キャンセル</label>
                  @elseif ( $booking->booking_status == 2 )
                  <label><input name="booking_status" value="2" type="radio" checked >無断キャンセル</label>
                  @else
                  <label><input name="booking_status" value="2" type="radio" >無断キャンセル</label>
                  @endif
                </div>
                <div class="radio">
                  @if ( old('booking_status') == 4 )
                  <label><input name="booking_status" value="4" type="radio" checked >未作成技工物TEL待ち</label>
                  @elseif ( $booking->booking_status == 4 )
                  <label><input name="booking_status" value="4" type="radio" checked >未作成技工物TEL待ち</label>
                  @else
                  <label><input name="booking_status" value="4" type="radio" >未作成技工物TEL待ち</label>
                  @endif
                </div>
                <div class="radio">
                  @if ( old('booking_status') == 5 )
                  <label><input name="booking_status" value="5" type="radio" checked >作成済み技工物キャンセル</label>
                  @elseif ( $booking->booking_status == 5 )
                  <label><input name="booking_status" value="5" type="radio" checked >作成済み技工物キャンセル</label>
                  @else
                  <label><input name="booking_status" value="5" type="radio" >作成済み技工物キャンセル</label>
                  @endif
                </div>
              </td>
            </tr>

            <!-- booking_memo -->
            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td>
                @if ( old('booking_memo') )
                <textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area">{{ old('booking_memo') }}</textarea>
                @elseif ( $booking->booking_memo )
                <textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area">{{ @$booking->booking_memo }}</textarea>
                @else
                <textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area"></textarea>
                @endif
              </td>
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

@stop


@section('script')
  <script type="text/javascript">
    $('#booking_recall_ym').click(function() {
      $('#recalling').attr("checked", "checked");
    });
  </script>
@stop