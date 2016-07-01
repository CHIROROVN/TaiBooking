@extends('backend.ortho.ortho')

@section('content')
    <script type="text/javascript" src="{{ asset('ortho') }}/common/js/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('ortho') }}/common/js/jquery.mask.min.js"></script>

    <section id="page">
      <div class="container content-page">
        <h3>医院情報管理　＞　登録済み医院の一覧</h3>

        <div class="row">
          <div class="col-md-12 table-responsive">
            <table class="table table-bordered">
              <tr>
                <td class="col-title"><label for="keyword">絞り込み</label></td>
                <td>
                  {!! Form::open(array('url' => 'ortho/clinics', 'method' => 'post')) !!}
                  <input type="text" name="keyword" value="{{ $keyword }}" id="keyword" class="form-control mar-right" style="display:inline"/>
                  <input type="submit" name="search" value="表示" class="btn btn-sm btn-page">
                  {!! Form::close() !!}
                </td>
              </tr>
            </table>
          </div>
        </div>

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

        <div class="row">
          <div class="col-md-12 text-right">
            <a href="{{ asset('ortho/clinics/regist') }}" class="btn btn-sm btn-page">医院の新規登録</a>
          </div>
        </div>
        
        <table class="table table-bordered table-striped ">
          <tbody>
            <tr>
              <td align="center" class="col-title"align="center">医院名</td>
              <td align="center" class="col-title">連絡先</td>
              <td align="center" class="col-title">処置</td>
              <td align="center" class="col-title">X-ray</td>
              <td align="center" class="col-title">SP</td>
              <td align="center" class="col-title">TBI</td>
              <td align="center" class="col-title">出張</td>
              <td align="center" class="col-title">設備管理</td>
              <td align="center" class="col-title">業務枠管理</td>
              <td align="center" class="col-title">予約雛形管理</td>
              <td align="center" class="col-title">編集</td>
            </tr>
            @if(empty($clinics) || count($clinics) < 1)
            <tr>
              <td colspan="11" align="center">{{ trans('common.no_data_correspond') }}</td>
            </tr>
            @else
              @foreach($clinics as $clinic)
              <tr>
                <td>{{ $clinic->clinic_name }}</td>
                <td>〒{{ $clinic->clinic_zip3 }}-{{ $clinic->clinic_zip4 }}　{{ $clinic->clinic_address1 }}　　{{ $clinic->clinic_address2 }}<br />
                    院長：{{ $clinic->clinic_ownername }}　<br />
                    TEL：<span class="tel">{{ $clinic->clinic_tel }}</span>.<span class="tel">{{ $clinic->clinic_tel_ip }}</span>　　FAX：<span class="tel">{{ $clinic->clinic_fax }}</span> <br />
                    E-mail：{{ $clinic->clinic_email }}</td>
                <td align="center">
                  @if($clinic->clinic_status1 == 1)
                    ○
                  @else
                    ×
                  @endif
                </td>
                <td align="center">
                  @if($clinic->clinic_status2 == 1)
                    ○
                  @else
                    ×
                  @endif
                </td>
                <td align="center">
                  @if($clinic->clinic_status3 == 1)
                    ○
                  @else
                    ×
                  @endif
                </td>
                <td align="center">
                  @if($clinic->clinic_status4 == 1)
                    ○
                  @else
                    ×
                  @endif
                </td>
                <td align="center">
                  @if($clinic->clinic_status5 == 1)
                    ○
                  @else
                    ×
                  @endif
                </td>
                <td><input type="button" onClick="location.href='{{route('ortho.facilities.index', $clinic->clinic_id)}}'" value="「設備」管理" class="btn btn-xs btn-page"/></td>
                <td><input type="button" onClick="location.href='{{route('ortho.clinics.services.index',$clinic->clinic_id)}}'" value="「業務枠」管理" class="btn btn-xs btn-page"/></td>
                <td><input type="button" onClick="location.href='{{route('ortho.clinics.booking.templates.index', $clinic->clinic_id)}}'" value="「予約雛形」管理" class="btn btn-xs btn-page"/></td>
                <td>
                  <a href="{{ asset('ortho/clinics/edit/' . $clinic->clinic_id) }}" class="btn btn-xs btn-page">編集</a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        <div class="row margin-bottom" style="display: block; float: right;">
          <div class="col-md-12 text-center">
            {!! $clinics->render(new App\Pagination\SimplePagination($clinics))  !!}
          </div>
        </div>
    </div>    
    </section>

    <script>
      $(document).ready(function($){
        $('.tel').mask('000-000-0000');
      });
    </script>
@endsection