@extends('backend.ortho.ortho')

@section('content')

{!! Form::open( ['id' => 'frmBookingRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking.regist', $booking_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
<section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>予約管理　＞　予約の新規登録</h3>
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
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="textName">患者名</label></td>
              <td>
                <?php //$pt = showPatient($booking->patient_id);?>
                <input type="hidden" name="p_id" id="p_id" value="{{ old('p_id') }}">
                <input type="text" name="patient" id="patient" class="input-text-mid form-control" style="width: 250px; display: inline;" value="{{ old('patient') }}"> &nbsp;
                <input type="button" name="1stBK" id="button" value="新患です" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.bookings.booking.1st.regist',$booking->booking_id)}}'">
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textNameRead">予約日時</label></td>
              <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}
              </td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{$booking->clinic_name}}</td>
            </tr>
            <!-- <tr>
              <td class="col-title"><label for="facility_id">チェアー</label></td>
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

            <tr>
              <td class="col-title"><label for="service_1">業務内容-1 <span class="note_required">※</span></label></td>
              <td>
                @if ( $booking->service_1_kind == 1 )
                {{ @$services[$booking->service_1] }}
                @else
                <select name="service_1" id="service_1" class="form-control">
                  <option value="-1">▼選択</option>
                  @if(count($treatment1s) > 0)
                    @foreach($treatment1s as $treatment12)
                    <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk22" @if(old('service_1') == $treatment12->treatment_id) selected="" @elseif($booking->service_1 == $treatment12->treatment_id) selected="" @endif>{{$treatment12->treatment_name}}</option>
                    @endforeach
                  @endif
                </select>
                @endif
                <span class="error-input">@if ($errors->first('service_1')) {!! $errors->first('service_1') !!} @endif</span>
              </td>
            </tr>

            <!-- <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="業務名">
                      @if(count($services) > 0)
                        @foreach($services as $key21 => $service21)
                          <option value="{{$key21}}_sk21" @if($booking->service_2 == $key21) selected @endif >{{$service21}}</option>
                        @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="治療内容">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $treatment12)
                            <option value="{{$treatment12->treatment_id}}#{{$treatment12->treatment_time}}_sk22" @if($booking->service_2 == $treatment12->treatment_id) selected @endif >{{$treatment12->treatment_name}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr> -->
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

            <tr>
              <td class="col-title"><label for="ckEmergency">救急</label></td>
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
                  @if ( old('booking_status') == 1 )
                  <label><input name="booking_status" value="1" type="radio" checked >「TEL待ち」です</label>
                  @elseif ( $booking->booking_status == 1 )
                  <label><input name="booking_status" value="1" type="radio" checked >「TEL待ち」です</label>
                  @else
                  <label><input name="booking_status" value="1" type="radio" >「TEL待ち」です</label>
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
                  <label>
                    @if ( old('booking_status') == 3)
                    <input name="booking_status" id="recalling" value="3" type="radio" checked >「リコール」です→
                    @elseif ( $booking->booking_status == 3 )
                    <input name="booking_status" id="recalling" value="3" type="radio" checked >「リコール」です→
                    @else
                    <input name="booking_status" id="recalling" value="3" type="radio" >「リコール」です→
                    @endif

                    <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                      <option value="">▼選択</option>

                      @if ( dateAddMonth($booking->booking_date, 01, 'Ym') == old('booking_recall_ym') )
                      <option value="{{dateAddMonth($booking->booking_date, 01, 'Ym')}}" selected="" >1ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 01, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 01, 'Ym')}}" selected="" >1ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 01, 'Ym')}}" >1ヶ月後</option>
                      @endif
                      
                      @if ( dateAddMonth($booking->booking_date, 02, 'Ym') == old('booking_recall_ym') )
                      <option value="{{dateAddMonth($booking->booking_date, 02, 'Ym')}}" selected >2ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 02, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 02, 'Ym')}}" selected >2ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 02, 'Ym')}}" >2ヶ月後</option>
                      @endif
                      
                      @if ( dateAddMonth($booking->booking_date, 03, 'Ym') == old('booking_recall_ym'))
                      <option value="{{dateAddMonth($booking->booking_date, 03, 'Ym')}}" selected >3ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 03, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 03, 'Ym')}}" selected >3ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 03, 'Ym')}}" >3ヶ月後</option>
                      @endif
                      
                      @if ( dateAddMonth($booking->booking_date, 04, 'Ym') == old('booking_recall_ym') )
                      <option value="{{dateAddMonth($booking->booking_date, 04, 'Ym')}}" selected >4ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 04, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 04, 'Ym')}}" selected >4ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 04, 'Ym')}}" >4ヶ月後</option>
                      @endif

                      @if ( dateAddMonth($booking->booking_date, 05, 'Ym') == old('booking_recall_ym') )
                      <option value="{{dateAddMonth($booking->booking_date, 05, 'Ym')}}" selected >5ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 05, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 05, 'Ym')}}" selected >5ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 05, 'Ym')}}" >5ヶ月後</option>
                      @endif
                      
                      @if ( dateAddMonth($booking->booking_date, 06, 'Ym') == old('booking_recall_ym') )
                      <option value="{{dateAddMonth($booking->booking_date, 06, 'Ym')}}" selected >6ヶ月後</option>
                      @elseif ( dateAddMonth($booking->booking_date, 06, 'Ym') == $booking->booking_recall_ym )
                      <option value="{{dateAddMonth($booking->booking_date, 06, 'Ym')}}" selected >6ヶ月後</option>
                      @else
                      <option value="{{dateAddMonth($booking->booking_date, 06, 'Ym')}}" >6ヶ月後</option>
                      @endif
                      
                    </select>
                  </label>
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
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="登録する" type="submit" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
{!! Form::close() !!}

@stop

@section('script')
  <script type="text/javascript">
    $('#booking_recall_ym').click(function() {
      $('#recalling').attr("checked", "checked");
    });
  </script>

  <script>
    $(document).ready(function(){
      $( "#patient" ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#patient').val();
            $.ajax({
                url: "{{ route('ortho.patients.autocomplete.patient') }}",
                beforeSend: function(){
                },
                method: "GET",
                data: { key: key },
                dataType: "json",
                success: function(data) {
                  response(data);
                },
            });
        },
        focus: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          return true;
        },
        select: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          $( "#p_id" ).val( ui.item.value );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
    });
  </script>
@stop