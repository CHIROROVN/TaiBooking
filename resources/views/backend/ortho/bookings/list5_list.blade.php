@extends('backend.ortho.ortho')

@section('content')
	<!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「作成済み技工物キャンセル」の表示</h3>
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
            @if ( !empty($list5s) && count($list5s) > 0 )
              @foreach ( $list5s as $list5 )
              <tr>
                <td>{{ $list5->clinic_name }}</td>
                <td>{{ formatDate($list5->result_date, '/') }}</td>
                <td>{{ formatDate($list5->booking_date, '/') }}</td>
                <td>{{ $list5->p_no }}</td>
                <td>{{ $list5->p_name_f }} {{ $list5->p_name_g }}</td>
                <td>{{ $list5->p_tel }}</td>
                <td>
                  <!-- service 1 -->
                  @if ( $list5->service_1_kind == 1 )
                    {{ @$services[$list5->service_1] }}
                  @elseif ( $list5->service_1_kind == 2 )
                    {{ @$treatment1s[$list5->service_1] }}
                  @endif
                  <!-- service 2 -->
                  @if ( $list5->service_2_kind == 1 )
                    @if(!empty($services[$list5->service_1]) || !empty($treatment1s[$list5->service_1]))、@endif {{ @$services[$list5->service_2] }}
                  @elseif ( $list5->service_2_kind == 2 )
                    @if(!empty($services[$list5->service_1]) || !empty($treatment1s[$list5->service_1]))、@endif {{ @$treatment1s[$list5->service_2] }}
                  @endif
                </td>
                <td>{{ $list5->result_memo }}</td>
                <td align="center"><input onclick="location.href='{{ route('ortho.bookings.booking.edit', [ $list5->booking_id ]) }}'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
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