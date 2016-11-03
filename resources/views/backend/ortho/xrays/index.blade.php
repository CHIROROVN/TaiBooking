@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　検索結果の一覧</h3>

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

    <table class="table table-bordered table-striped">
      <tbody>
        <tr>
          <td class="col-title" align="center">撮影日</td>
          <td class="col-title" align="center">カルテNo</td>
          <td class="col-title" align="center">患者名</td>
          <td class="col-title" align="center">患者名ふりがな</td>
          <td class="col-title" align="center">性別</td>
          <td class="col-title" align="center">生年月日</td>
          <td class="col-title" align="center" style="min-width: 150px;">放射線照射録の表示</td>
        </tr>
        @if( empty($xrays) || count($xrays) == 0)
          <tr>
            <td colspan="7">
              <h3 align="center" style="padding-bottom: 0;">{{ trans('common.no_data_correspond') }}</h3>
            </td>
          </tr>
        @else
          @foreach ( $xrays as $xray )
          <tr>
            <td>
              @if ( !empty($xray->xray_date) )
              [X] {{ $xray->xray_date }}
              @endif
              @if ( !empty($xray->ct_date) )
              <br>[CT] {{ $xray->ct_date }}
              @endif
            </td>
            <td>{{ $xray->p_no }}</td>
            <td>{{ $xray->p_name_f }} {{ $xray->p_name_g }}</td>
            <td>{{ $xray->p_name_f_kana }} {{ $xray->p_name_g_kana }}</td>
            <td><?php echo ($xray->p_sex == 1) ? '男' : '女'; ?></td>
            <td>
              @if ( !empty($xray->p_birthday) && $xray->p_birthday != '0000-00-00' )
              {{ date('Y/m/d', strtotime($xray->p_birthday)) }}
              @endif
            </td>
            <td align="center">
              <input onclick="location.href='{{ route('ortho.xrays.detail', [$xray->p_patient_id]) }}'" value="放射線照射録の表示" type="button" class="btn btn-xs btn-page"/>
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.xrays.search', [
          's_p_name'                => $s_p_name,
          's_p_id'                  => $s_p_id,
          's_p_birthday_year_from'  => $s_p_birthday_year_from,
          's_p_birthday_month_from' => $s_p_birthday_month_from,
          's_p_birthday_day_from'   => $s_p_birthday_day_from,
          's_p_birthday_year_to'    => $s_p_birthday_year_to,
          's_p_birthday_month_to'   => $s_p_birthday_month_to,
          's_p_birthday_day_to'     => $s_p_birthday_day_to,
          's_p_sex_men'             => $s_p_sex_men,
          's_p_sex_women'           => $s_p_sex_women,
          's_xray_date_year_from'   => $s_xray_date_year_from,
          's_xray_date_month_from'  => $s_xray_date_month_from,
          's_xray_date_day_from'    => $s_xray_date_day_from,
          's_xray_date_year_to'     => $s_xray_date_year_to,
          's_xray_date_month_to'    => $s_xray_date_month_to,
          's_xray_date_day_to'      => $s_xray_date_day_to,
        ]) }}'" value="条件を変えて再検索" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
@endsection

