@extends('backend.ortho.ortho')

@section('content')
AAAAAAAAAAAAAAaa
     <!-- Content clinic service list -->
    <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>医院情報管理　＞　{{ $clinic->clinic_name }}　＞　業務自動枠の一覧</h3>
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
              <td align="center" class="col-title">業務名</td>
              <td align="center" class="col-title">設備と時間-1</td>
              <td align="center" class="col-title">設備と時間-2</td>
              <td align="center" class="col-title">設備と時間-3</td>
              <td align="center" class="col-title">設備と時間-4</td>
              <td align="center" class="col-title">設備と時間-5</td>
              <td align="center" class="col-title">編集</td>
            </tr>
            @if(!count($services))
              <tr><td colspan="7" style="text-align: center;">該当するデータがありません。</td></tr>
            @else
              @foreach($services as $service)
              <tr>
                <td>
                  {{$service->service_name}}
                </td>
                <td align="center">
                  @if ( isset($clinic_services['service_' . $service->service_id]) )
                    @if ( $clinic_services['service_' . $service->service_id]->service_facility_1 == -1 )
                    治療
                    @else
                    {{ @$facilities[$clinic_services['service_' . $service->service_id]->service_facility_1] }}
                    @endif
                    @if ( !empty($clinic_services['service_' . $service->service_id]->service_time_1) )
                    {{ $clinic_services['service_' . $service->service_id]->service_time_1 }}分
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if ( isset($clinic_services['service_' . $service->service_id]) )
                    @if ( $clinic_services['service_' . $service->service_id]->service_facility_2 == -1 )
                    治療
                    @else
                    {{ @$facilities[$clinic_services['service_' . $service->service_id]->service_facility_2] }}
                    @endif
                    @if ( !empty($clinic_services['service_' . $service->service_id]->service_time_2) )
                    {{ $clinic_services['service_' . $service->service_id]->service_time_2 }}分
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if ( isset($clinic_services['service_' . $service->service_id]) )
                    @if ( $clinic_services['service_' . $service->service_id]->service_facility_3 == -1 )
                    治療
                    @else
                    {{ @$facilities[$clinic_services['service_' . $service->service_id]->service_facility_3] }}
                    @endif
                    @if ( !empty($clinic_services['service_' . $service->service_id]->service_time_3) )
                    {{ $clinic_services['service_' . $service->service_id]->service_time_3 }}分
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if ( isset($clinic_services['service_' . $service->service_id]) )
                    @if ( $clinic_services['service_' . $service->service_id]->service_facility_4 == -1 )
                    治療
                    @else
                    {{ @$facilities[$clinic_services['service_' . $service->service_id]->service_facility_4] }}
                    @endif
                    @if ( !empty($clinic_services['service_' . $service->service_id]->service_time_4) )
                    {{ $clinic_services['service_' . $service->service_id]->service_time_4 }}分
                    @endif
                  @endif
                </td>
                <td align="center">
                  @if ( isset($clinic_services['service_' . $service->service_id]) )
                    @if ( $clinic_services['service_' . $service->service_id]->service_facility_5 == -1 )
                    治療
                    @else
                    {{ @$facilities[$clinic_services['service_' . $service->service_id]->service_facility_5] }}
                    @endif
                    @if ( !empty($clinic_services['service_' . $service->service_id]->service_time_5) )
                    {{ $clinic_services['service_' . $service->service_id]->service_time_5 }}分
                    @endif
                  @endif
                </td>
                <td align="center" text-center >
                  <?php
                    if ( isset($clinic_services['service_' . $service->service_id]) && $clinic_services['service_' . $service->service_id]->clinic_service_id ) {
                      $clinic_service_id = $clinic_services['service_' . $service->service_id]->clinic_service_id;
                    } else {
                      $clinic_service_id = 0;
                    }
                  ?>
                  <input type="button" onclick="location.href='{{route('ortho.clinics.services.template_edit', [ $clinic->clinic_id, $service->service_id, $clinic_service_id ])}}'" value="編集" class="btn btn-xs btn-page"/>
                </td>
              </tr>
              @endforeach
          @endif

          </tbody>
        </table>
        <div class="row margin-bottom" style="display: block; float: right; width: 100%;">
          <div class="col-md-12 text-center">
            <input type="button" onClick="location.href='{{route('ortho.clinics.index')}}'" value="医院一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>    
    </section>
    <!-- End content clinic service list -->
@endsection