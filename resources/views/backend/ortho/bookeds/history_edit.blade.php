@extends('backend.ortho.ortho')

@section('content')
  {!! Form::open(array('route' => ['ortho.bookeds.history.edit', $booked->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>予約管理　＞　予約の一覧　＞　来院履歴の編集</h3>
        <table class="table table-bordered">

          <!-- result_date -->
          <tr>
            <td class="col-title" colspan="2"><label for="result_date">日付</label></td>
            <td>
              <select name="result_date" id="result_date" class="form-control form-control--medium">
                <option value="">----</option>
                @foreach ( $dates as $date )
                  @if ( old('result_date') )
                  <option value="{{ $date }}" @if(old('result_date') == $date) selected="" @endif>{{ formatDate($date, '/') }}({{ DayJp($date) }}日)</option>
                  @elseif ( !empty($result->result_date) )
                  <option value="{{ $date }}" @if($result->result_date == $date) selected="" @endif>{{ formatDate($date, '/') }}({{ DayJp($date) }})</option>
                  @else
                  <option value="{{ $date }}" @if($currentDay == $date) selected="" @endif>{{ formatDate($date, '/') }}({{ DayJp($date) }})</option>
                  @endif
                @endforeach
              </select>
              <span class="error-input">@if ($errors->first('result_date')) ※{!! $errors->first('result_date') !!} @endif</span>
            </td>
          </tr>

          <!-- result_start_time -->
          <tr>
            <td class="col-title" colspan="2">時間</td>
            <td>
              <select name="result_start_time_hh" id="result_start_time_hh" class="form-control form-control--small">
                @for ( $i = 6; $i <= 23; $i++ )
                <?php $i = ($i < 10) ? '0' . $i : $i; ?>
                  @if ( old('result_start_time_hh') )
                  <option value="{{ $i }}" @if(old('result_start_time_hh') == $i) selected="" @endif>{{ $i }}時</option>
                  @else
                  <option value="{{ $i }}" @if(splitHourMinArray(@$result->result_start_time)['hh'] == $i) selected="" @endif>{{ $i }}時</option>
                  @endif
                @endfor
              </select>
                <select name="result_start_time_mm" id="result_start_time_mm" class="form-control form-control--small">
                  @if ( old('result_start_time_mm') )
                  <option value="00" @if(old('result_start_time_mm') == '00') selected="" @endif>00分</option>
                  <option value="15" @if(old('result_start_time_mm') == '15') selected="" @endif>15分</option>
                  <option value="30" @if(old('result_start_time_mm') == '30') selected="" @endif>30分</option>
                  <option value="45" @if(old('result_start_time_mm') == '45') selected="" @endif>45分</option>
                  @else
                  <option value="00" @if(splitHourMinArray(@$result->result_start_time)['mm'] == '00') selected="" @endif>00分</option>
                  <option value="15" @if(splitHourMinArray(@$result->result_start_time)['mm'] == '15') selected="" @endif>15分</option>
                  <option value="30" @if(splitHourMinArray(@$result->result_start_time)['mm'] == '30') selected="" @endif>30分</option>
                  <option value="45" @if(splitHourMinArray(@$result->result_start_time)['mm'] == '45') selected="" @endif>45分</option>
                  @endif
              </select>
              ～
              <!-- result_total_time -->
              <?php
              $hh_mm = toTime(@$result->result_start_time, @$result->result_total_time);
              $hh_mm = explode(':', $hh_mm);
              $hh = $hh_mm[0];
              $mm = $hh_mm[1];
              ?>
              <select name="result_total_time_hh" id="result_total_time_hh" class="form-control form-control--small">
                @for ( $i = 6; $i <= 23; $i++ )
                <?php $i = ($i < 10) ? '0' . $i : $i; ?>
                  @if ( old('result_total_time_hh') )
                  <option value="{{ $i }}" @if(old('result_total_time_hh') == $i) selected="" @endif>{{ $i }}時</option>
                  @else
                  <option value="{{ $i }}" @if($hh == $i) selected="" @endif>{{ $i }}時</option>
                  @endif
                @endfor
              </select>
              <select name="result_total_time_mm" id="result_total_time_mm" class="form-control form-control--small">
                @if ( old('result_total_time_mm') )
                <option value="00" @if(old('result_total_time_mm') == '00') selected="" @endif>00分</option>
                <option value="15" @if(old('result_total_time_mm') == '15') selected="" @endif>15分</option>
                <option value="30" @if(old('result_total_time_mm') == '30') selected="" @endif>30分</option>
                <option value="45" @if(old('result_total_time_mm') == '45') selected="" @endif>45分</option>
                @else
                <option value="00" @if($mm == '00') selected="" @endif>00分</option>
                <option value="15" @if($mm == '15') selected="" @endif>15分</option>
                <option value="30" @if($mm == '30') selected="" @endif>30分</option>
                <option value="45" @if($mm == '45') selected="" @endif>45分</option>
                @endif
              </select>
              <span class="error-input">@if ($errors->first('result_start_time')) ※{!! $errors->first('result_start_time') !!} @endif</span>
            </td>
          </tr>

          <!-- clinic_id -->
          <tr>
            <td class="col-title" colspan="2"><label for="clinic_id">医院 <span class="note_required">※</span></label></td>
            <td>
              <select name="clinic_id" id="clinic_id" class="form-control">
                <option value="">▼選択</option>
                <?php $listClinic = $clinics; ?>
                @foreach ( $listClinic as $key => $clinic )
                  @if ( $clinic->clinic_name == 'たい矯正歯科' )
                    @if ( old('clinic_id') )
                    <option value="{{ $clinic->clinic_id }}" @if(old('clinic_id') == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                    @else
                    <option value="{{ $clinic->clinic_id }}" @if(@$result->clinic_id == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                    @endif
                  <?php unset($listClinic[$key]) ?>
                  @endif
                @endforeach
                @foreach ( $listClinic as $clinic )
                  @if ( old('clinic_id') )
                  <option value="{{ $clinic->clinic_id }}" @if(old('clinic_id') == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                  @else
                  <option value="{{ $clinic->clinic_id }}" @if(@$result->clinic_id == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="error-input">@if ($errors->first('clinic_id')) ※{!! $errors->first('clinic_id') !!} @endif</span>
            </td>
          </tr>

          <!-- doctor_id -->
          <tr>
            <td class="col-title" colspan="2"><label for="doctor_id">ドクター <span class="note_required">※</span></label></td>
            <td>
              <select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">▼選択</option>
                @foreach ( $doctors as $doctor )
                  @if ( old('doctor_id') )
                  <option value="{{ $doctor->id }}" @if(old('doctor_id') == $doctor->id) selected="" @endif>{{ $doctor->u_name }}</option>
                  @else
                  <option value="{{ $doctor->id }}" @if(@$result->doctor_id == $doctor->id) selected="" @endif>{{ $doctor->u_name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="error-input">@if ($errors->first('doctor_id')) ※{!! $errors->first('doctor_id') !!} @endif</span>
            </td>
          </tr>

            <!-- hygienist_id -->
          <tr>
            <td class="col-title" colspan="2"><label for="hygienist_id">衛生士</label></td>
            <td>
              <select name="hygienist_id" id="hygienist_id" class="form-control">
                <option value="">▼選択</option>
                @foreach ( $hygienists as $hygienist )
                  @if ( old('hygienist_id') )
                  <option value="{{ $hygienist->id }}" @if(old('hygienist_id') == $hygienist->id) selected="" @endif>{{ $hygienist->u_name }}</option>
                  @else
                  <option value="{{ $hygienist->id }}" @if(@$result->hygienist_id == $hygienist->id) selected="" @endif>{{ $hygienist->u_name }}</option>
                  @endif
                @endforeach
              </select>
            </td>
          </tr>

          <!-- service_1 -->
          <tr>
            <td class="col-title" colspan="2"><label for="service_1">実施業務-1 <span class="note_required">※</span></label></td>
            <td>
              <select name="service_1" id="service_1" class="form-control">
                <option value="">▼選択</option>
                <optgroup label="業務名">
                @if(count($services) > 0)
                  @foreach($services as $service)
                    @if ( old('service_1') )
                    <option value="1|{{ $service->service_id }}" @if(old('service_1') == $service->service_id) selected="" @endif>{{ $service->service_name }}</option>
                    @else
                      @if ( @$result->service_1_kind == 1 )
                      <option value="1|{{ $service->service_id }}" @if(@$result->service_1 == $service->service_id) selected="" @endif>{{ $service->service_name }}</option>
                      @else
                      <option value="1|{{ $service->service_id }}">{{ $service->service_name }}</option>
                      @endif
                    @endif
                @endforeach
                @endif
                </optgroup>
                <optgroup label="治療内容">
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    @if ( old('service_1') )
                    <option value="2|{{ $key }}" @if(old('service_1') == $key) selected="" @endif>{{ $treatment1 }}</option>
                    @else
                      @if ( @$result->service_1_kind == 2 )
                      <option value="2|{{ $key }}" @if(@$result->service_1 == $key) selected="" @endif>{{ $treatment1 }}</option>
                      @else
                      <option value="2|{{ $key }}">{{ $treatment1 }}</option>
                      @endif
                    @endif
                  @endforeach
                @endif
                </optgroup>
              </select>
              <span class="error-input">@if ($errors->first('service_1')) ※{!! $errors->first('service_1') !!} @endif</span>
            </td>
          </tr>

          <!-- service_2 -->
          <tr>
            <td class="col-title" colspan="2"><label for="service_2">実施業務-2</label></td>
            <td>
              <select name="service_2" id="service_2" class="form-control">
                <option value="">▼選択</option>
                <optgroup label="業務名">
                @if(count($services) > 0)
                  @foreach($services as $service)
                    @if ( @$result->service_2_kind == 1 )
                    <option value="1|{{ $service->service_id }}" @if($result->service_2 == $service->service_id) selected @endif >{{ $service->service_name }}</option>
                    @else
                    <option value="1|{{ $service->service_id }}">{{ $service->service_name }}</option>
                    @endif
                @endforeach
                @endif
                </optgroup>
                <optgroup label="治療内容">
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    @if ( @$result->service_2_kind == 2 )
                    <option value="2|{{ $key }}" @if($result->service_2 == $key) selected @endif>{{ $treatment1 }}</option>
                    @else
                    <option value="2|{{ $key }}">{{ $treatment1 }}</option>
                    @endif
                  @endforeach
                @endif
                </optgroup>
              </select>
            </td>
          </tr>

          <!-- result_memo -->
          <tr>
            <td class="col-title" colspan="2"><label for="result_memo">メモ</label></td>
            <td>
              @if ( old('result_memo') )
              <textarea name="result_memo" class="" rows="3">{{ old('result_memo') }}</textarea>
              @else
              <textarea name="result_memo" class="" rows="3">{{ @$result->result_memo }}</textarea>
              @endif
            </td>
          </tr>

          <!-- result_next -->
          <tr>
            <td class="col-title" rowspan="3">次回予約のために<br>
              ※Drの指示による</td>
            <td class="col-title"><label for="result_next">日時候補</label></td>
            <td>
              <div class="form-inline">
                @if ( old('result_next') )
                <input type="text" name="result_next" id="result_next" class="form-control" value="{{ old('result_next') }}">
                @else
                <input type="text" name="result_next" id="result_next" class="form-control" value="{{ @$result->result_next }}">
                @endif
              </div>
            </td>
          </tr>

          <!-- next_service_1 -->
          <tr>
            <td class="col-title"><label for="cbTreatContent1">予定業務-1 </label></td>
            <td>
              <select name="next_service_1" id="next_service_1" class="form-control">
                <option value="">▼選択</option>
                <optgroup label="業務名">
                @if(count($services) > 0)
                  @foreach($services as $service)
                  @if ( old('next_service_1') )
                  <option value="1|{{ $service->service_id }}" @if(old('next_service_1') == $service->service_id) selected="" @endif >{{ $service->service_name }}</option>
                  @else
                    @if ( @$result->next_service_1_kind == 1 )
                    <option value="1|{{ $service->service_id }}" @if($result->next_service_1 == $service->service_id) selected="" @endif >{{ $service->service_name }}</option>
                    @else
                    <option value="1|{{ $service->service_id }}">{{ $service->service_name }}</option>
                    @endif
                  @endif
                @endforeach
                @endif
                </optgroup>
                <optgroup label="治療内容">
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    @if ( old('next_service_1') )
                    <option value="2|{{ $key }}" @if(old('next_service_1') == $key) selected="" @endif>{{ $treatment1 }}</option>
                    @else
                      @if ( @$result->next_service_1_kind == 2 )
                      <option value="2|{{ $key }}" @if($result->next_service_1 == $key) selected="" @endif>{{ $treatment1 }}</option>
                      @else
                      <option value="2|{{ $key }}">{{ $treatment1 }}</option>
                      @endif
                    @endif
                  @endforeach
                @endif
                </optgroup>
              </select>
            </td>
          </tr>

          <!-- next_service_2 -->
          <tr>
            <td class="col-title"><label for="next_service_2">予定業務-2</label></td>
            <td>
              <select name="next_service_2" id="next_service_2" class="form-control">
                <option value="">▼選択</option>
                <optgroup label="業務名">
                @if(count($services) > 0)
                  @foreach($services as $service)
                    @if ( old('next_service_2') )
                    <option value="1|{{ $service->service_id }}" @if(old('next_service_2') == $service->service_id) selected="" @endif >{{ $service->service_name }}</option>
                    @else
                      @if ( @$result->next_service_2_kind == 1 )
                      <option value="1|{{ $service->service_id }}" @if($result->next_service_2 == $service->service_id) selected="" @endif >{{ $service->service_name }}</option>
                      @else
                      <option value="1|{{ $service->service_id }}">{{ $service->service_name }}</option>
                      @endif
                    @endif
                @endforeach
                @endif
                </optgroup>
                <optgroup label="治療内容">
                @if(count($treatment1s) > 0)
                  @foreach($treatment1s as $key => $treatment1)
                    @if ( old('next_service_2') )
                    <option value="2|{{ $key }}" @if(old('next_service_2') == $key) selected="" @endif>{{ $treatment1 }}</option>
                    @else
                      @if ( @$result->next_service_2_kind == 2 )
                      <option value="2|{{ $key }}" @if($result->next_service_2 == $key) selected="" @endif>{{ $treatment1 }}</option>
                      @else
                      <option value="2|{{ $key }}">{{ $treatment1 }}</option>
                      @endif
                    @endif
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
          <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page">
      </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='{{ route('ortho.bookeds.history') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  {!! Form::close() !!}
@endsection