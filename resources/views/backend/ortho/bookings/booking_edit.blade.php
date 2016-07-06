@extends('backend.ortho.ortho')

@section('content')
<?php //echo "<pre>"; print_r($booking) ?>
{!! Form::open(array('route' => ['ortho.bookings.booking.edit', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>予約管理　＞　登録済み予約の編集</h3>
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="textName">患者名</label></td>
              <td>{{$booking->p_no}} {{$booking->p_name}}</td>
            </tr>
            <tr>
              <td class="col-title"><label for="textNameRead">予約日時</label></td>
              <td>{{formatDateJp($booking->booking_date)}} ({{DayJp($booking->booking_date)}})　{{splitHourMin($booking->booking_start_time)}}～{{toTime($booking->booking_start_time, $booking->booking_total_time)}}
              <input type="submit" name="button3" id="button" value="予約日時の変更" class="btn btn-sm btn-page" onclick="location.href='booking_change.html'"></td>
            </tr>
            <tr>
              <td class="col-title">医院</td>
              <td>{{$booking->clinic_name}}</td>
            </tr>
            <tr>
              <td class="col-title"><label for="cbChair">チェアー</label></td>
              <td><select name="facility_id" id="facility_id" class="form-control">
                <option value="">▼選択</option>
                  @if(count($facilities) > 0)
                  @foreach($facilities as $key => $facility)
                    <option value="{{$key}}" @if($booking->facility_id == $key) selected @endif>{{$facility}}</option>
                  @endforeach
                @endif
              </select>
              </td>
            </tr>
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
            <tr>
              <td class="col-title"><label for="service_1">業務内容-1</label></td>
              <td>
                <select name="service_1" id="service_1" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="Services">
                      @if(count($services) > 0)
                        @foreach($services as $key11 => $service11)
                        <option value="{{$key11}}" @if($booking->service_1 == $key11) selected @endif >{{$service11}}</option>
                      @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="Treatments">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $key12 => $treatment12)
                            <option value="{{$key11}}" @if($booking->service_1 == $key12) selected @endif>{{$treatment12}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="service_2">業務内容-2</label></td>
              <td>
                <select name="service_2" id="service_2" class="form-control">
                  <option value="">▼選択</option>
                  <optgroup label="Services">
                      @if(count($services) > 0)
                        @foreach($services as $key21 => $service21)
                        <option value="{{$key21}}" @if($booking->service_2 == $key21) selected @endif >{{$service21}}</option>
                      @endforeach
                      @endif
                  </optgroup>
                  <optgroup label="Treatments">
                        @if(count($treatment1s) > 0)
                          @foreach($treatment1s as $key22 => $treatment22)
                            <option value="{{$key}}" @if($booking->service_2 == $key22) selected @endif>{{$treatment22}}</option>
                          @endforeach
                        @endif
                  </optgroup>
                </select>
              </td>
            </tr>
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
            <tr>
              <td class="col-title"><label for="ckEmergency">救急</label></td>
              <td>
                <div class="checkbox">
                  <label><input name="checkbox" value="checkbox" type="checkbox" id="ckEmergency">救急です</label>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-title">予約ステータス</td>
              <td>
                <div class="radio">
                  <label><input name="radio" value="radio" type="radio">通常</label>
                </div>
                <div class="radio">
                  <label><input name="radio" value="radio" type="radio">「TEL待ち」です</label>
                </div>
                <div class="radio">
                  <label>
                    <input name="radio" value="radio" type="radio">「リコール」です→
                    <select name="select9" id="select9" class="form-control form-control--xs">
                      <option selected="selected">▼選択</option>
                      <option>1ヶ月後</option>
                      <option>2ヶ月後</option>
                      <option>3ヶ月後</option>
                      <option>4ヶ月後</option>
                      <option>5ヶ月後</option>
                      <option>6ヶ月後</option>
                    </select>
                  </label>
                </div>
                <div class="radio">
                  <label><input name="radio" value="radio" type="radio">未作成技工物TEL待ち</label>
                </div>
                <div class="radio">
                  <label><input name="radio" value="radio" type="radio">作成済み技工物キャンセル</label>
                </div>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="textRemarks">備考</label></td>
              <td><textarea name="txtRemarks" cols="60" rows="3" id="textRemarks" class="form-control"></textarea></td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page">
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

@endsection