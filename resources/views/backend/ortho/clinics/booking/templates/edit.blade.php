@extends('backend.ortho.ortho')

@section('content')
	 <!-- Content clinic booking template edit -->
  {!! Form::open(array('route' => ['ortho.clinics.booking.templates.edit', $clinic->clinic_id, $booking_template->mbt_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content">
        <h3>医院情報管理　＞　{{ $clinic->clinic_name }}　＞　予約雛形の編集</h3>

        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="mbt_name">雛形名</label></td>
            <td>
              @if ( old('mbt_name') )
              <input name="mbt_name" id="mbt_name" value="{{ old('mbt_name') }}" type="text" class="form-control form-control--default">
              @else
              <input name="mbt_name" id="mbt_name" value="{{ $booking_template->mbt_name }}" type="text" class="form-control form-control--default">
              @endif
              <span class="error-input">@if ($errors->first('mbt_name')) {!! $errors->first('mbt_name') !!} @endif</span>
              <!-- <input type="button" class="btn btn-sm btn-page no-border" name="button" value="保存する"> -->
            </td>
          </tr>
        </table>

        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center">{{ $facility->facility_name }}</td>
              @endforeach
            </tr>

            <!-- check "brown", "green", "blue" color -->
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0]; // printf( "%02d", $tmp_arr[0] );
              $minute = $tmp_arr[1]; //printf( "%02d", $tmp_arr[1] );
            ?>
            <tr>
              <td align="center">{{ $time }}～</td>
              @foreach ( $facilitys as $facility )
                @if ( isset($arr_templates[$facility->facility_id][$time]) )
                  <?php
                    $hour_template = substr($arr_templates[$facility->facility_id][$time]->template_time , 0, 2);
                    $minute_template = substr($arr_templates[$facility->facility_id][$time]->template_time , 2, 2);
                    // echo $hout_template.'-'.$minute_template;
                  ?>
                  @if ( $arr_templates[$facility->facility_id][$time]->clinic_service_id > 0
                      && $hour_template == $hour
                      && $minute_template >= $minute
                   )
                  <td align="center" class="col-green">
                    <img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" />{{ $arr_templates[$facility->facility_id][$time]->mbt_name }}
                  </td>
                  @elseif ( $arr_templates[$facility->facility_id][$time]->clinic_service_id == -1) )
                  <td align="center" class="col-blue">
                    {{ $arr_templates[$facility->facility_id][$time]->mbt_name }}
                  </td>
                  @endif
                @else
                <td align="center" class="col-brown">
                  <img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" />
                  <!-- Modal -->
                  <div class="modal fade" id="myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                        </div>
                        <div class="modal-body">
                          <p>{{trans('common.modal_content_delete')}}</p>
                        </div>
                        <div class="modal-footer">
                          <a href="{{ route('ortho.facilities.delete', [$clinic->clinic_id, $facility->facility_id]) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                          <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /Modal -->
                </td>
                @endif
              @endforeach
            </tr>
            @endforeach
            
          </table>
        </div>
      </div>

      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page mar-right">
        </div>
      </div>

      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='clinic_list.html'" value="医院一覧に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  </form>
  <!-- End content clinic booking template edit -->
@endsection