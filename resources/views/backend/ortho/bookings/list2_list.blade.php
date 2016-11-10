@extends('backend.ortho.ortho')

@section('content')

	<!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「無断キャンセル」リストの表示</h3>
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
      <table class="table table-bordered">
        <tr>
          <td class="col-title"><label for="textName">当初予約日</label></td>
          <td>
            {!! Form::open(array('route' => 'ortho.bookings.list2_list', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
            <select name="booking_date_year" id="booking_date_year" class="form-control form-control--small mar-right" style="text-align: center;">
              <option value="">----年</option>
              @foreach ( $years as $year )
              <option value="{{ $year }}" @if($booking_date_year == $year) selected="" @endif>{{ $year }}年</option>
              @endforeach
            </select>
         
            <select name="booking_date_month" id="booking_date_month" class="form-control form-control--small mar-right" style="text-align: center;">
              <option value="">--月</option>
              @for ( $i = 1; $i <= 12; $i++ )
              <?php $i = ($i < 10) ? ('0' . $i) : $i; ?>
              <option value="{{ $i }}" @if($booking_date_month == $i) selected="" @endif>{{ $i }}月</option>
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
              <td class="col-title" align="center" style="min-width:135px;">最終処置内容-1</td>
              <td class="col-title" align="center" style="min-width:50px;">備考</td>
              <td class="col-title" align="center" style="min-width:120px;">予約の登録</td>
            </tr>
            @if ( !empty($list2s) && count($list2s) > 0 )
            @foreach ( $list2s as $list2 )
            <tr>
              <td>{{ $list2->clinic_name }}</td>
              <td>{{ formatDate($list2->result_date, '/') }}</td>
              <td>{{ formatDate($list2->booking_date, '/') }}</td>
              <?php  //splitHourMin($list2->booking_start_time)}}～{{toTime($list2->booking_start_time, $list2->booking_total_time) ?>
              <td>{{ $list2->p_no }}</td>
              <td>{{ $list2->p_name_f }} {{ $list2->p_name_g }}</td>
              <td>{{ $list2->p_tel }}</td>
              <td>
                <!-- service 1 -->
                @if ( $list2->service_1_kind == 1 )
                  {{ @$services[$list2->service_1] }}
                @elseif ( $list2->service_1_kind == 2 )
                  {{ @$treatment1s[$list2->service_1] }}
                @endif
                <!-- service 2 -->
                @if ( $list2->service_2_kind == 1 )
                  @if(!empty($services[$list2->service_1]) || !empty($treatment1s[$list2->service_1]))、@endif {{ @$services[$list2->service_2] }}
                @elseif ( $list2->service_2_kind == 2 )
                  @if(!empty($services[$list2->service_1]) || !empty($treatment1s[$list2->service_1]))、@endif {{ @$treatment1s[$list2->service_2] }}
                @endif
              </td>
              <td>{{ $list2->result_memo }}</td>
              <td align="center"><input onclick="location.href='{{ route('ortho.bookings.list2_search',$list2->booking_id) }}'" value="予約の登録" type="button" class="btn btn-xs btn-page"/></td>
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
  <script src="{{ asset('') }}public/backend/ortho/common/js/jquery.min.js"></script>
  <script type="text/javascript">
    var date = new Date();
    var m    = date.getMonth()+1;
    $("#booking_date_year").change(function() {
      if($(this).val() == ''){
        $('#booking_date_month option[value=""]').prop('selected',true);
      }else{
        $('#booking_date_month option[value="'+m+'"]').prop('selected',true);
      }
    });

  </script>
  <!-- End content list1 list -->
@endsection