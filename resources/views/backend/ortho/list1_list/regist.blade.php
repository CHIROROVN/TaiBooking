@extends('backend.ortho.ortho')

@section('content')
    {!! Form::open(array('route' => 'ortho.list1_list.regist', 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>各種リスト表示　＞　「TEL待ちリスト」の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">

                  <!-- clinic_id -->
                  <tr>
                    <td class="col-title"><label for="clinic_id">医院名 <span class="note_required">※</span></label></td>
                    <td>
                      <select name="clinic_id" id="clinic_id" class="form-control form-control--medium">
                        <option value="">▼選択</option>
                        @foreach($clinics as $clinic)
                          @if ( old('clinic_id') == $clinic->clinic_id )
                          <option value="{{$clinic->clinic_id}}" selected >{{$clinic->clinic_name}}</option>
                          @else
                          <option value="{{$clinic->clinic_id}}" >{{$clinic->clinic_name}}</option>
                          @endif
                        @endforeach
                      </select>
                      <span class="error-input">@if ($errors->first('clinic_id')) ※{!! $errors->first('clinic_id') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- patient_id -->
                  <tr>
                    <td class="col-title"><label for="p_id">患者名 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="hidden" name="p_id" id="p_id" value="{{ old('p_id') }}">
                      <input type="text" name="patient" id="patient" class="input-text-mid form-control" style="width: 250px; display: inline;" value="{{ old('patient') }}">
                      <span class="error-input">@if ($errors->first('p_id')) ※{!! $errors->first('p_id') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- doctor_id -->
                  <tr>
                    <td class="col-title"><label for="doctor_id">担当ドクター <span class="note_required">※</span></label></td>
                    <td>
                      <select name="doctor_id" id="doctor_id" class="form-control form-control--medium">
                        <option value="">▼選択</option>
                        @foreach($doctors as $doctor)
                          @if ( old('doctor_id') == $doctor->id )
                          <option value="{{$doctor->id}}" selected >{{$doctor->u_name}}</option>
                          @else
                          <option value="{{$doctor->id}}" >{{$doctor->u_name}}</option>
                          @endif
                        @endforeach
                      </select>
                      <span class="error-input">@if ($errors->first('doctor_id')) ※{!! $errors->first('doctor_id') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- service_1 -->
                  <tr>
                    <td class="col-title"><label for="service_1">業務内容-1 <span class="note_required">※</span></label></td>
                    <td>
                      <select name="service_1" id="service_1" class="form-control form-control--medium">
                        <option value="">▼選択</option>
                        <optgroup label="業務名">
                          @if(count($services) > 0)
                            @foreach($services as $key21 => $service21)
                              <option value="{{$key21}}_service" @if(old('service_1') == $key21.'_service') selected="" @endif>{{$service21}}</option>
                            @endforeach
                          @endif
                        </optgroup>
                        <optgroup label="治療内容">
                          @if(count($treatment1s) > 0)
                            @foreach($treatment1s as $treatment12)
                              <option value="{{$treatment12->treatment_id}}_{{$treatment12->treatment_time}}_treatment" @if(old('service_1') == $treatment12->treatment_id.'_'.$treatment12->treatment_time.'_treatment') selected="" @endif >{{$treatment12->treatment_name}}</option>
                            @endforeach
                          @endif
                        </optgroup>
                      </select>
                      <span class="error-input">@if ($errors->first('service_1')) ※{!! $errors->first('service_1') !!} @endif</span>
                    </td>
                  </tr>

                  <!-- free_text -->
                  <tr>
                    <td class="col-title"><label for="free_text">備考</label></td>
                    <td>
                      <textarea name="booking_memo" id="booking_memo" cols="30" rows="10" class="form-control form-control-full">{{ old('booking_memo') }}</textarea>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ route('ortho.list1_list.index') }}" class="btn btn-sm btn-page mar-right">登録済み地域一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@stop

@section('script')
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