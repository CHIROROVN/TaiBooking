@extends('backend.ortho.ortho')

@section('content')
	<!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「未作成技工物TEL待ち」の表示</h3>
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
            @if ( !empty($list4s) && count($list4s) > 0 )
              @foreach ( $list4s as $list4 )
              <tr>
                <td>{{ $list4->clinic_name }}</td>
                <td>{{ formatDate($list4->result_date, '/') }}</td>
                <td>{{ formatDate($list4->booking_date, '/') }} {{splitHourMin($list4->booking_start_time)}}～{{toTime($list4->booking_start_time, $list4->booking_total_time)}}</td>
                <td>{{ $list4->p_no }}</td>
                <td>{{ $list4->p_name_f }} {{ $list4->p_name_g }}</td>
                <td>{{ $list4->p_tel }}</td>
                <td>
                  <!-- service 1 -->
                  @if ( $list4->service_1_kind == 1 )
                    {{ @$services[$list4->service_1] }}
                  @elseif ( $list4->service_1_kind == 2 )
                    {{ @$treatment1s[$list4->service_1] }}
                  @endif
                  <!-- service 2 -->
                  @if ( $list4->service_2_kind == 1 )
                    @if(!empty($services[$list4->service_1]) || !empty($treatment1s[$list4->service_1]))、@endif {{ @$services[$list4->service_2] }}
                  @elseif ( $list4->service_2_kind == 2 )
                    @if(!empty($services[$list4->service_1]) || !empty($treatment1s[$list4->service_1]))、@endif {{ @$treatment1s[$list4->service_2] }}
                  @endif
                </td>
                <td>{{ $list4->result_memo }}</td>
                <td align="center"><input onclick="location.href='{{ route('ortho.bookings.booking.edit', [ $list4->booking_id ]) }}'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
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