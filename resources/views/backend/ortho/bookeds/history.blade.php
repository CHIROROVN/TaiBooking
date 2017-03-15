@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3 class="margin-bottom">予約管理　＞　予約の一覧</h3>

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

    <div>
      <div class="form-inline">
          {!! Form::open(array('route' => 'ortho.bookeds.history', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
          <select title="医院" name="s_clinic_id" class="form-control">
            <option value="">医院</option>
            <?php $listClinic = $clinics; ?>
            @foreach($listClinic as $clinic_id => $clinic)
              @if ( $clinic->clinic_name == 'たい矯正歯科' )
              <option value="{{$clinic->clinic_id}}" selected="">{{ $clinic->clinic_name }}</option>
              <?php unset($listClinic[$clinic_id]) ?>
              @endif
            @endforeach
            @foreach ( $listClinic as $clinic)
            <option value="{{ $clinic->clinic_id }}" @if($s_clinic_id == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
            @endforeach
          </select>
          　
          <select name="s_booking_date" id="s_booking_date" class="form-control" style="margin-left: -19px;">
            <option value="">----</option>
            @foreach ( $dates as $date )
              @if ( $s_booking_date == $date )
              <option value="{{ $date }}" selected="">{{ formatDate($date, '/') }}({{ DayJp($date) }})</option>
              @else
              <option value="{{ $date }}">{{ formatDate($date, '/') }}({{ DayJp($date) }})</option>
              @endif
            @endforeach
          </select>

          <div style="display: inline;">
            <input name="s_p_name" id="s_p_id" type="text"  class="form-control form-control--small" value="{{ $s_p_name }}">
            <input name="s_p_id" type="hidden" id="s_p_id-id" value="{{ $s_p_id }}">
          </div>

          <input name="" value="検索" type="submit" class="btn btn-sm btn-page">
          </form>
      </div>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td  class="col-title" align="center">時間帯</td>
            <td  class="col-title" align="center">時間</td>
          <td  class="col-title"align="center">患者名</td>
            <td  class="col-title"align="center">ドクター</td>
            <td  class="col-title"align="center">衛生士</td>
            <td  class="col-title"align="center">装置</td>
            <td  class="col-title"align="center">処置内容-1</td>
            <td  class="col-title"align="center" style="min-width: 100px;">検査</td>
            <td  class="col-title"align="center" style="min-width: 100px;">保険診療</td>
            <td  class="col-title"align="center" style="min-width: 100px;">救急</td>
          <td class="col-title" align="center" style="min-width: 100px;">編集</td>
          <td class="col-title" align="center">次回予約</td>
        </tr>
        @if ( !count($bookeds) )
        <tr><td colspan="5" align="center">{{ trans('common.no_data_correspond') }}</td></tr>
        @else
          @foreach ( $bookeds as $booked )
            @if ( !empty($booked->patient_id) )
            <tr>
              <td>{{ $booked->booking_date }}</td>
                <td>{{ splitHourMin($booked->booking_start_time) }}</td>
              <td>{{ $booked->p_no }}　{{ $booked->p_name_f . ' ' . $booked->p_name_g }}</td>
                <td>
                    @foreach ( $doctors as $doctor )
                        @if ( $doctor->id == $booked->doctor_id )
                            {{ $doctor->u_name }}
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach ( $hys as $hy )
                        @if ( $hy->id == $booked->hygienist_id )
                            {{ $hy->u_name }}
                        @endif
                    @endforeach
                </td>
                <td>{{ $booked->equipment_name }}</td>
              <td>
                @if ( $booked->service_1_kind == 1 )
                {{ @$services[$booked->service_1] }}
                @elseif ( $booked->service_1_kind == 2 )
                {{ @$treatment1s[$booked->service_1] }}
                @endif

                @if ( !empty($booked->service_2) )
                  @if ( $booked->service_2_kind == 1 )
                    @if( !empty($services[$booked->service_2]) )
                      ,{{ @$services[$booked->service_2] }}
                    @endif
                  @elseif ( $booked->service_2_kind == 2 )
                    @if( !empty($services[$booked->service_2]) )
                      ,{{ @$treatment1s[$booked->service_2] }}
                    @endif
                  @endif
                @endif
              </td>
                <td>{{ $booked->inspection_name }}</td>
                <td>{{ $booked->insurance_name }}</td>
                <td><?php echo ($booked->emergency_flag == 1) ? '救急です' : 'ノーマル'; ?></td>
              <td align="center">
                <!-- regist -->
                @if ( isset($results[$booked->patient_id . '|' . $booked->clinic_id . '|' . $booked->facility_id]) )
                <input onclick="location.href='{{ route('ortho.bookeds.history.regist', [$booked->booking_id]) }}'" value="登録" type="button" class="btn btn-xs btn-page" disabled="">
                @else
                <input onclick="location.href='{{ route('ortho.bookeds.history.regist', [$booked->booking_id]) }}'" value="登録" type="button" class="btn btn-xs btn-page">
                @endif
                <!-- edit -->
                @if ( isset($results[$booked->patient_id . '|' . $booked->clinic_id . '|' . $booked->facility_id]) )
                <input onclick="location.href='{{ route('ortho.bookeds.history.edit', [ $booked->booking_id ]) }}'" value="編集" type="button" class="btn btn-xs btn-page">
                @else
                <input onclick="location.href='{{ route('ortho.bookeds.history.edit', [ $booked->booking_id ]) }}'" value="編集" type="button" class="btn btn-xs btn-page" disabled="">
                @endif
              </td>
              <td align="center">
                @if ( $booked->booking_date > $currentDay )
                {{ formatDate($booked->booking_date) }} {{ splitHourMin($booked->booking_start_time) }}～{{ toTime($booked->booking_start_time, $booked->booking_total_time) }}
                @else
                <input onclick="location.href='{{ route('ortho.bookings.booking_search', ['booking_id' => $booked->booking_id]) }}'" value="次回予約" type="button" class="btn btn-xs btn-page">
                @endif
              </td>
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        
      </div>
    </div>
  </div>    
</section>

@stop


@section('script')
  <script>
    // s_p_id
    $( "#s_p_id" ).autocomplete({
      minLength: 0,
      // source: pamphlets,
      source: function(request, response){
          var key = $('#s_p_id').val();
          $.ajax({
              url: "{{ route('ortho.patients.brothers.autocomplete.patient') }}",
              beforeSend: function(){
                  // console.log(response);
              },
              async:    true,
              data: { key: key },
              dataType: "json",
              method: "get",
              // success: response
              success: function(data) {
                // console.log(data);
                response(data);
              },
          });
      },
      focus: function( event, ui ) {
        $( "#s_p_id" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#s_p_id" ).val( ui.item.label );
        $( "#s_p_id-id" ).val( ui.item.value );
        // $( "#p_relation_id-description" ).html( ui.item.desc );
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
          //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
          .append( "<a>" + item.desc + "</a>" )
          .appendTo( ul );
    };
  </script>
@stop