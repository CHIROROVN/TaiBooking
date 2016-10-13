@extends('backend.ortho.ortho')

@section('content')

{!! Form::open( ['id' => 'frmBookingRecallEdit', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.bookings.booking_recall_edit', $id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
<section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>各種リスト表示　＞　「リコール月」の更新</h3>
          <table class="table table-bordered">
            <tr>
                <td class="col-title"><label for="textName">医院</label></td>
                <td>
                    <select name="clinic_id" id="clinic_id" class="form-control" style="width: 250px !important;">
                      <option value="">▼選択</option>
                      @if(count($clinics) > 0)
                        <?php $listClinic = $clinics; ?>
                        @foreach($listClinic as $clinic_id => $clinic)
                          @if ( $clinic == 'たい矯正歯科' )
                          <option value="{{$clinic_id}}" @if($recall->clinic_id == $clinic_id) selected="" @endif>{{$clinic}}</option>
                          <?php unset($listClinic[$clinic_id]) ?>
                          @endif
                        @endforeach
                        @foreach($listClinic as $clinic_id => $clinic)
                        <option value="{{$clinic_id}}" @if($recall->clinic_id == $clinic_id) selected="" @endif>{{$clinic}}</option>
                        @endforeach
                      @endif
                    </select>
                    <span class="error-input">@if ($errors->first('clinic_id')) ※{!! $errors->first('clinic_id') !!} @endif</span>
                </td>
            </tr>

            <tr>
              <td class="col-title"><label>患者名 <span class="note_required">※</span></label></td>
              <td>
                <input id="p_id" name="p_id" value="{{$recall->patient_id}}" type="hidden">
                <input id="patient" class="input-text-mid form-control ui-autocomplete-input" name="patient" style="width: 250px; display: inline;" value="{{$recall->p_no}} {{$recall->p_name_f}} {{$recall->p_name_g}}({{ $recall->p_name_f_kana}}{{ $recall->p_name_g_kana}})" autocomplete="off" type="text">
                <span class="error-input">@if ($errors->first('patient')) ※{!! $errors->first('patient') !!} @endif</span>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="inspection_id">電話番号</label></td>
              <td>
              <input name="p_tel" id="p_tel" class="input-text-mid form-control" value="@if(!empty(old('p_tel'))){{old('p_tel')}}@else{{$recall->p_tel}}@endif" type="text">
              <span class="error-input">@if ($errors->first('p_tel')) ※{!! $errors->first('p_tel') !!} @endif</span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="insurance_id">リコール月 <span class="note_required">※</span></label></td>
              <td>
                <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs" style="width: 90px !important;">
                      <option value="" @if(old('booking_recall_ym') == '') selected="" @endif>▼選択</option>

                      <option value="{{dateAddMonth(date_now(), 01, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 01, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 01, 'Ym')) selected="" @endif >1ヶ月後</option>

                      <option value="{{dateAddMonth(date_now(), 02, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 02, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 02, 'Ym')) selected=""@endif >2ヶ月後</option>

                      <option value="{{dateAddMonth(date_now(), 03, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 03, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 03, 'Ym')) selected="" @endif >3ヶ月後</option>

                      <option value="{{dateAddMonth(date_now(), 04, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 04, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 04, 'Ym')) selected="" @endif >4ヶ月後</option>

                      <option value="{{dateAddMonth(date_now(), 05, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 05, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 05, 'Ym')) selected="" @endif >5ヶ月後</option>

                      <option value="{{dateAddMonth(date_now(), 06, 'Ym')}}" @if(old('booking_recall_ym') == dateAddMonth(date_now(), 06, 'Ym')) selected="" @elseif($recall->booking_recall_ym == dateAddMonth(date_now(), 06, 'Ym')) selected="" @endif >6ヶ月後</option>
                    </select>
                <span class="error-input">@if ($errors->first('booking_recall_ym')) ※{!! $errors->first('booking_recall_ym') !!} @endif</span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="booking_memo">備考</label></td>
              <td>
               <textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control form-control-area">@if(!empty(old('booking_memo'))){{old('booking_memo')}}@else{{$recall->booking_memo}}@endif</textarea>
               <span class="error-input">@if ($errors->first('booking_memo')) ※{!! $errors->first('booking_memo') !!} @endif</span>
              </td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="btnSubmit" id="btnSubmit" value="更新する" type="submit" class="btn btn-sm btn-page">
            <input value="リセット" onclick="resetForm()" type="button" class="btn btn-sm btn-page">
        </div>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="btnList" id="btnList" value="前の画面に戻る" type="button" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.bookings.booking_recall')}}'">
          </div>
        </div>
      </div>
    </section>
{!! Form::close() !!}
@section('script')
<script>
    function resetForm() {
    document.getElementById("frmBookingRecall").reset();
}
</script>
<script type="text/javascript">
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
@endsection