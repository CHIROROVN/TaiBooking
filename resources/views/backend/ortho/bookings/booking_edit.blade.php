@extends('backend.ortho.ortho')

@section('content')

<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　登録済み予約の編集</h3>
      <table class="table table-bordered">

        <tr>
          <td class="col-title">患者名</td>
          <td>{{ $booking->p_no }} {{ $booking->p_name }}</td>
        </tr>
        <tr>
          <td class="col-title">予約日時</td>
          <td>
            {{ date('Y', strtotime($booking->booking_date)) }}年{{ date('m', strtotime($booking->booking_date)) }}月{{ date('d', strtotime($booking->booking_date)) }}日（日）　
            {{ $booking->booking_start_time }}:00～{{ $booking->booking_start_time }}:{{ $booking->booking_total_time }}
            </td>
        </tr>
        <tr>
          <td class="col-title">医院</td>
          <td>{{ $booking->clinic_name }}</td>
        </tr>
        <tr>
          <td class="col-title">チェアー</td>
          <td>{{ $booking->facility_name }}</td>
        </tr>
        <tr>
          <td class="col-title">ドクター</td>
          <td>
            @foreach ( $doctors as $doctor )
              @if ( $doctor->id == $booking->doctor_id )
              {{ $doctor->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">衛生士</td>
          <td>
            @foreach ( $hys as $hy )
              @if ( $hy->id == $booking->hygienist_id )
              {{ $hy->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">装置</td>
          <td>{{ $booking->equipment_name }}</td>
        </tr>
        <tr>
          <td class="col-title">処置内容-1</td>
          <td>
            @if ( !empty($booking->service_1) && $booking->service_1_kind == 1 )
              <!-- clinic service -->
              @foreach ( $clinic_services as $clinic_service )
                @if ( $booking->service_1 == $clinic_service->clinic_service_id )
                {{ $clinic_service->service_name }}
                @endif
              @endforeach
            @elseif ( !empty($booking->service_1) && ($booking->service_1_kind == 2 || $booking->service_1_kind == 3) )
              <!-- treatment -->
              @foreach ( $treatment1s as $treatment1 )
                @if ( $booking->service_1 == $treatment1->treatment_id )
                {{ $treatment1->treatment_name }}
                @endif
              @endforeach
            @endif
          </td>
        </tr>
        <tr>
          <td class="col-title">処置内容-2</td>
          <td>
            @if ( !empty($booking->service_2) && $booking->service_2_kind == 1 )
              <!-- clinic service -->
              @foreach ( $clinic_services as $clinic_service )
                @if ( $booking->service_2 == $clinic_service->clinic_service_id )
                {{ $clinic_service->service_name }}
                @endif
              @endforeach
            @elseif ( !empty($booking->service_2) && ($booking->service_2_kind == 2 || $booking->service_2_kind == 3) )
              <!-- treatment -->
              @foreach ( $treatment1s as $treatment1 )
                @if ( $booking->service_2 == $treatment1->treatment_id )
                {{ $treatment1->treatment_name }}
                @endif
              @endforeach
            @endif
          </td>
        </tr>
        <tr>
          <td class="col-title">検査</td>
          <td>{{ $booking->inspection_name }}</td>
        </tr>
        <tr>
          <td class="col-title">保険診療</td>
          <td>{{ $booking->insurance_name }}</td>
        </tr>
        <tr>
          <td class="col-title">救急</td>
          <td><?php echo ($booking->emergency_flag == 1) ? '救急です' : 'ノーマル'; ?></td>
        </tr>

        <!-- booking_status -->
        <tr>
          <td class="col-title">予約ステータス</td>
          <td>
            <div class="radio">
              <label><input name="booking_status" value="1" type="radio" @if($booking->booking_status == 1) checked="" @endif>通常</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="2" type="radio" @if($booking->booking_status == 2) checked="" @endif>「TEL待ち」です</label>
            </div>
            <div class="radio">
              <label>
                <input name="booking_status" value="3" type="radio" @if($booking->booking_status == 3) checked="" @endif>「リコール」です→
                <select name="booking_recall_ym" id="booking_recall_ym" class="form-control form-control--xs">
                  <option value="0">▼選択</option>
                  <option value="01">1ヶ月後</option>
                  <option value="02">2ヶ月後</option>
                  <option value="03">3ヶ月後</option>
                  <option value="04">4ヶ月後</option>
                  <option value="05">5ヶ月後</option>
                  <option value="06">6ヶ月後</option>
                </select>
              </label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="4" type="radio" @if($booking->booking_status == 4) checked="" @endif>未作成技工物TEL待ち</label>
            </div>
            <div class="radio">
              <label><input name="booking_status" value="5" type="radio" @if($booking->booking_status == 5) checked="" @endif>作成済み技工物キャンセル</label>
            </div>
          </td>
        </tr>

        <tr>
          <td class="col-title"><label for="booking_memo">備考</label></td>
          <td><textarea name="booking_memo" cols="60" rows="3" id="booking_memo" class="form-control">{{ $booking->booking_memo }}</textarea></td>
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
        <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>

@endsection