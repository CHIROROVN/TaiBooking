@extends('backend.ortho.ortho')

@section('content')
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>患者管理　＞　来院履歴の一覧</h3>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-title">患者名</td>
              <td><span class="mar-right">{{ $patient->p_name_f }} {{ $patient->p_name_g }}</span> <input onclick="location.href='{{ route('ortho.patients.detail', [ $patient->p_id ]) }}'" value="詳細表示" type="button"class="btn btn-xs btn-page"></td>
            </tr>
            <tr>
              <td class="col-title">担当</td>
              <td>{{ $patient->u_name }}</td>
            </tr>
            <tr>
              <td class="col-title">医院関連メモ</td>
              <td>{{ $patient->p_clinic_memo }}</td>
            </tr>
            <tr>
              <td class="col-title">個人情報メモ</td>
              <td>{{ $patient->p_personal_memo }}</td>
            </tr>
          </tbody>
        </table>

        <hr noshade>

        <table class="table table-bordered">
          <tr class="col-title">
            <td>来院日時</td>
            <td>医院</td>
            <td>Dr</td>
            <td>衛生士</td>
            <td>実施業務-1</td>
            <td>実施業務-2</td>
          </tr>
          @foreach ( $results as $result )
          <tr>
            <td>{{ formatDateJp($result->result_date) }}　{{ splitHourMin($result->result_start_time) }}～{{ toTime($result->result_start_time, $result->result_total_time) }}</td>
            <td>{{ $result->clinic_name }}</td>
            <td><?php echo (isset($doctors[$result->doctor_id])) ? $doctors[$result->doctor_id]->u_name : ''; ?></td>
            <td><?php echo (isset($hygienists[$result->hygienist_id])) ? $hygienists[$result->hygienist_id]->u_name : ''; ?></td>
            <td>
              @if ( $result->service_1_kind == 1 )
              {{ @$services[$result->service_1] }}
              @elseif ( $result->service_1_kind == 2 )
              {{ @$treatment1s[$result->service_1] }}
              @endif
            </td>
            <td>
              @if ( $result->service_2_kind == 1 )
              {{ @$services[$result->service_2] }}
              @elseif ( $result->service_2_kind == 2 )
              {{ @$treatment1s[$result->service_2] }}
              @endif
            </td>
          </tr>
          @endforeach
        </table>

      </div>
      </div>
      <div class="margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
@endsection