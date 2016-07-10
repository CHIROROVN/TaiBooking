@extends('backend.ortho.ortho')
@section('content')
{!! Form::open( ['id' => 'frmBookingSearch', 'class' => 'form-horizontal','method' => 'post', 'route' => 'ortho.bookings.booking_search', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
	 <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約日時の変更</h3>
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="textName">医院</label></td>
                  <td>
                    <select name="clinic_id" id="clinic_id" class="form-control">
                      <option value="" selected="selected">▼選択</option>
                      @if(count($clinics) > 0)
                      	@foreach($clinics as $clinic_id => $clinic)
                      	<option value="{{$clinic_id}}">{{$clinic}}</option>
                      	@endforeach
                      @endif
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">担当ドクター</td>
                  <td>
                    <div class="row">
	                    @if(count($doctors) > 0)
	                    	@foreach($doctors as $doctor)
		                    	<div class="col-xs-4 col-sm-4 col-md-4">
		                        <div class="checkbox">
		                          <label><input name="doctor_id[]" value="{{$doctor->id}}" type="checkbox"> {{$doctor->u_name}}</label>
		                        </div>
		                      </div>
	                    	@endforeach
	                    @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">衛生士</td>
                  <td>
                    <div class="row">
                       @if(count($hygienists) > 0)
	                    	@foreach($hygienists as $hygienist)
		                    	<div class="col-xs-4 col-sm-4 col-md-4">
		                        <div class="checkbox">
		                          <label><input name="hygienist_id[]" value="{{$hygienist->id}}" type="checkbox"> {{$hygienist->u_name}}</label>
		                        </div>
		                      </div>
	                    	@endforeach
	                    @endif
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">曜日</td>
                  <td>
                    <div class="row">
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Sun" type="checkbox">日</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Mon" type="checkbox">月</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Tue" type="checkbox">火</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Wed" type="checkbox">水</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Thu" type="checkbox">木</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Fri" type="checkbox">金</label>
                        </div>
                      </div>
                      <div class="col-xs-3 col-sm-2 col-md-1">
                        <div class="checkbox">
                          <label><input name="booking_date[]" value="Sat" type="checkbox">土</label>
                        </div>
                      </div>
                    </div>
                  </td>
                </tr>
                <tr>
                    <td class=col-title>何週間後</td>
                    <td>
                      <div class="row">
                      	<div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="one_week" value=""checked />指定なし</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="one_week" value="one_week" />1週間後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="one_month" value="one_month" />1ヵ月後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="two_month" value="two_month"  />2ヵ月後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="week_later" value="week_specified" />週指定</label>
                          </div>
                        </div>
                        <div class="col-md-2">
                        <select name="week_later_option" id="week_later_option">
                            	<option value="one_week">1週間後</option>
                            	<option value="two_week">2週間後</option>
                            	<option value="three_week">3週間後</option>
                            	<option value="four_week">4週間後</option>
                            	<option value="five_week">5週間後</option>
                            </select>
                        </div>
                        <div class="col-xs-1 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_later" id="date_picker" value="date_picker"  />日付指定</label>
                          </div>
                        </div>
                        <div class="col-xs-1 col-sm-2 col-md-1">
	                          <div class="input-group date" data-provide="datepicker">
							    <input type="text" name="date_picker_option" id="date_picker_option" class="form-control datepicker">
							    <div class="input-group-addon">
						        <span class="glyphicon glyphicon-th"></span>
							  </div>
							</div>
                        </div>
                     </div>
                    </td>
                </tr>
                <tr>
                  <td class="col-title">業務</td>
                  <td>
                    <select name="clinic_service_name" id="clinic_service_name" class="form-control">
                      <option value="" selected="selected">指定なし</option>
                      <optgroup label="Services">
	                      @if(count($services) > 0)
	                        @foreach($services as $key11 => $service11)
	                        <option value="{{$key11}}_sk11" >{{$service11}}</option>
	                      @endforeach
	                      @endif
	                  </optgroup>
	                  <optgroup label="Treatments">
	                        @if(count($treatment1s) > 0)
	                          @foreach($treatment1s as $key12 => $treatment12)
	                            <option value="{{$key12}}_sk12" >{{$treatment12}}</option>
	                          @endforeach
	                        @endif
	                  </optgroup>
                    </select>
                  </td>
                </tr>
              </table>
          </div>

          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              
              <input name="BookingCalendar" id="BookingCalendar" onclick="location.href='{{route('ortho.bookings.booking.result.calendar')}}'" value="検索開始（カレンダー表示）" type="button" class="btn btn-sm btn-page mar-right">

              <input name="BookingList" id="BookingList" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">

              <input name="Reset" id="button" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
{!! Form::close() !!}
<script type="text/javascript">
	$('.datepicker').datepicker({
	    format: 'yyyy-mm-dd',
        locale: 'ja'
});
</script>

<script type="text/javascript">
	$('#date_picker_option').click(function() {
		$('#date_picker').attr("checked", "checked");
	});
	$('#week_later_option').click(function() {
		$('#week_later').attr("checked", "checked");
	});
</script>

@endsection