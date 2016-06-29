@extends('backend.ortho.ortho')

@section('content')
     <!-- Content clinic service list -->
    <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>医院情報管理　＞　たい矯正歯科　＞　業務自動枠の一覧</h3>
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
            @if(!count($clinic_services))
              <tr><td colspan="7" style="text-align: center;">該当するデータがありません。</td></tr>
            @else
            @foreach($clinic_services as $clinic_service)
              <tr>
                <td>{{@$services[$clinic_service->service_id]}}</td>
                <td align="center">{{@$facilities[$clinic_service->service_facility_1]}} {{$clinic_service->service_time_1}}分</td>
                <td align="center">{{@$facilities[$clinic_service->service_facility_2]}} {{$clinic_service->service_time_2}}分</td>
                <td align="center">{{@$facilities[$clinic_service->service_facility_3]}} {{$clinic_service->service_time_3}}分</td>
                <td align="center">{{@$facilities[$clinic_service->service_facility_4]}} {{$clinic_service->service_time_4}}分</td>
                <td align="center">{{@$facilities[$clinic_service->service_facility_5]}} {{$clinic_service->service_time_5}}分</td>
                <td align="center" text-center ><input type="button" onclick="location.href='{{route('ortho.clinics.services.template_edit', [$clinic_id, $clinic_service->service_id, $clinic_service->clinic_service_id])}}'" value="編集" class="btn btn-xs btn-page"/></td>
              </tr>
              @endforeach
            @endif

          </tbody>
        </table>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input type="button" onClick="location.href='{{route('ortho.clinics.index')}}'" value="医院一覧に戻る" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>    
    </section>
    <!-- End content clinic service list -->
@endsection