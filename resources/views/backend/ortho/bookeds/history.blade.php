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
            <option value="">----日</option>
            @foreach ( $dates as $date )
            <option value="{{ $date }}" @if($s_booking_date == $date) selected="" @endif>{{ formatDate($date, '/') }}({{ DayJp($date) }}日)</option>
            @endforeach
          </select>

          <input name="" value="検索" type="submit" class="btn btn-sm btn-page">
          </form>
      </div>
    </div>

    <table class="table table-bordered table-striped treatment2-list">
      <tbody>
        <tr>
          <td  class="col-title" align="center">時間帯</td>
          <td  class="col-title"align="center">患者名</td>
          <td class="col-title" align="center">本日の内容</td>
          <td class="col-title" align="center">編集</td>
          <td class="col-title" align="center">次回予約</td>
        </tr>
        @if ( !count($bookeds) )
        <tr><td colspan="5" align="center">{{ trans('common.no_data_correspond') }}</td></tr>
        @else
          @foreach ( $bookeds as $booked )
          <tr>
            <td>{{ splitHourMin($booked->booking_start_time) }}～{{ toTime($booked->booking_start_time, $booked->booking_total_time) }}</td>
            <td>{{ $booked->p_no }}　{{ $booked->p_name }}@if(!empty($booked->p_name_kana))（{{ $booked->p_name_kana }}）@endif</td>
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
            <td align="center">
              <!-- regist -->
              @if ( isset($results[$booked->patient_id]) )
              <input onclick="location.href='{{ route('ortho.bookeds.history.regist', [$booked->booking_id]) }}'" value="登録" type="button" class="btn btn-xs btn-page" disabled="">
              @else
              <input onclick="location.href='{{ route('ortho.bookeds.history.regist', [$booked->booking_id]) }}'" value="登録" type="button" class="btn btn-xs btn-page">
              @endif
              <!-- edit -->
              @if ( isset($results[$booked->patient_id]) )
              <input onclick="location.href='{{ route('ortho.bookeds.history.edit', [ $booked->booking_id ]) }}'" value="編集" type="button" class="btn btn-xs btn-page">
              @else
              <input onclick="location.href='{{ route('ortho.bookeds.history.edit', [ $booked->booking_id ]) }}'" value="編集" type="button" class="btn btn-xs btn-page" disabled="">
              @endif
            </td>
            <td align="center">
              @if ( $booked->booking_date > $currentDay )
              {{ formatDate($booked->booking_date) }} {{ splitHourMin($booked->booking_start_time) }}～{{ toTime($booked->booking_start_time, $booked->booking_total_time) }}
              @else
              <input onclick="location.href='{{ route('ortho.bookings.booking_search') }}'" value="次回予約" type="button" class="btn btn-xs btn-page">
              @endif
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        {!! $bookeds->appends(['s_clinic_id' => $s_clinic_id, 's_booking_date' => $s_booking_date, ])->render(new App\Pagination\SimplePagination($bookeds)) !!}
      </div>
    </div>
  </div>    
</section>
@endsection