@extends('backend.ortho.ortho')

@section('content')
	<!-- content list1 list -->
    <section id="page">
      <div class="container content-page">
        <h3>各種リスト表示　＞　「TEL待ちリスト」の表示</h3>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <td class="col-title" align="center">医院名</td>
                <td class="col-title" align="center">最終来院日</td>
                <td class="col-title" align="center">カルテNo</td>
                <td class="col-title" align="center">患者名</td>
                <td class="col-title" align="center">電話番号</td>
                <td class="col-title" align="center">業務内容-1-2</td>
                <td class="col-title" align="center">備考</td>
                <td class="col-title" align="center" style="min-width:120px">予約情報の編集</td>
              </tr>
              @if(!count($list1))
              	<tr><td colspan="8" style="text-align: center;">該当するデータがありません。</td></tr>
              @else
	              @foreach($list1 as $l1)
	              	<tr>
		                <td>{{$l1->clinic_name}}</td>
		                <td>{{formatDate($l1->booking_date)}}</td>
		                <td>{{$l1->p_no}}</td>
		                <td>{{$l1->p_name_f}} {{ $l1->p_name_g }}</td>
		                <td>{{$l1->p_tel}}</td>
                    <td>
                      <!-- service 1 -->
                      @if ( $l1->service_1_kind == 1 )
                        {{ @$services[$l1->service_1] }}
                      @elseif ( $l1->service_1_kind == 2 )
                        {{ @$treatment1s[$l1->service_1] }}
                      @endif
                      <!-- service 2 -->
                      @if ( $l1->service_2_kind == 1 )
                         @if(!empty($services[$l1->service_1]) || !empty($treatment1s[$l1->service_1]))、@endif {{ @$services[$l1->service_2] }}
                      @elseif ( $l1->service_2_kind == 2 )
                        @if(!empty($services[$l1->service_1]) || !empty($treatment1s[$l1->service_1]))、@endif {{ @$treatment1s[$l1->service_2] }}
                      @endif
                    </td>
		                <td>{{$l1->booking_memo}}</td>
		                <td align="center"><input onclick="location.href='{{route('ortho.bookings.booking.edit', $l1->booking_id)}}'" value="予約情報の編集" type="button" class="btn btn-xs btn-page"/></td>
		              </tr>
	              @endforeach
              @endif
            </tbody>
          </table>
        </div>
      </div>    
    </section>
  <!-- End content list1 list -->
@endsection