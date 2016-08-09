@extends('backend.ortho.ortho')

@section('content')
	<!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「リコールリスト」の表示</h3>
      <table class="table table-bordered">
        <tr>
          <td class="col-title"><label for="textName">当初予約日</label></td>
          <td>
            {!! Form::open(array('route' => 'ortho.bookings.list3_list', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
            <select name="booking_recall_yy" id="booking_recall_yy" class="form-control form-control--small mar-right">
              <option value="">----年</option>
              @foreach ( $years as $year )
              <option value="{{ $year }}" @if($booking_recall_yy == $year) selected="" @endif>{{ $year }}年</option>
              @endforeach
            </select>
         
            <select name="booking_recall_mm" id="booking_recall_mm" class="form-control form-control--small mar-right">
              <option value="">--月</option>
              @for ( $i = 1; $i <= 12; $i++ )
              <?php $i = ($i < 10) ? ('0' . $i) : $i; ?>
              <option value="{{ $i }}" @if($booking_recall_mm == $i) selected="" @endif>{{ $i }}月</option>
              @endfor
            </select>
            <input name="" id="button" value="表示" type="submit" class="btn btn-sm btn-page">
            </form>
          </td>
        </tr>
      </table>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <td class="col-title" align="center">医院名</td>
              <td class="col-title" align="center">最終来院日</td>
              <td class="col-title" align="center">当初予約日時</td>
              <td class="col-title" align="center">カルテNo</td>
              <td class="col-title" align="center">患者名</td>
              <td class="col-title" align="center">電話番号</td>
              <td class="col-title" align="center" style="min-width:135px;">最終処置内容-1-2</td>
              <td class="col-title" align="center" style="min-width:50px;">備考</td>
              <td class="col-title" align="center" style="min-width:120px;">予約情報の編集</td>
            </tr>
            @if ( !empty($list3s) && count($list3s) > 0 )
            @foreach ( $list3s as $list3 )
            <tr>
              <td>{{ $list3->clinic_name }}</td>
              <td>{{ formatDate($list3->result_date, '/') }}</td>
              <td>{{ formatDate($list3->booking_date, '/') }} {{splitHourMin($list3->booking_start_time)}}～{{toTime($list3->booking_start_time, $list3->booking_total_time)}}</td>
              <td>{{ $list3->p_no }}</td>
              <td>{{ $list3->p_name }}</td>
              <td>{{ $list3->p_tel }}</td>
              <td>
                <!-- service 1 -->
                @if ( $list3->service_1_kind == 1 )
                  {{ @$services[$list3->service_1] }}
                @elseif ( $list3->service_1_kind == 2 )
                  {{ @$treatment1s[$list3->service_1] }}
                @endif
                <!-- service 2 -->
                @if ( $list3->service_2_kind == 1 )
                  @if(!empty($services[$list3->service_1]) || !empty($treatment1s[$list3->service_1]))、@endif {{ @$services[$list3->service_2] }}
                @elseif ( $list3->service_2_kind == 2 )
                  @if(!empty($services[$list3->service_1]) || !empty($treatment1s[$list3->service_1]))、@endif {{ @$treatment1s[$list3->service_2] }}
                @endif
              </td>
              <td>{{ $list3->result_memo }}</td>
              <td align="center"><input onclick="location.href='{{ route('ortho.bookings.booking.edit', [ $list3->booking_id ]) }}'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="9" style="text-align: center;">該当するデータがありません。</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>    
  </section>
  <!-- End content list1 list -->
@endsection