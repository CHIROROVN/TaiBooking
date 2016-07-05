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

                    $factility_id_current = 0;
                    if ( $arr_templates[$facility->facility_id][$time]->facility_id == $facility->facility_id ) {
                      $factility_id_current = $facility->facility_id;
                    }
                  ?>
                  <!-- green -->
                  @if ( $arr_templates[$facility->facility_id][$time]->clinic_service_id > 0
                      && $hour_template == $hour
                      && $minute_template >= $minute
                   )
                  <td align="center" class="col-green" id="td-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                    <span data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" style="display: block; width: 100%; min-height: 20px;">&nbsp;<!-- <img src="{{ asset('') }}public/backend/ortho/common/image/icon-shift-set.png" /> --><!-- {{ $arr_templates[$facility->facility_id][$time]->mbt_name }} --></span>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                          </div>
                          <div class="modal-body">
                            <!-- child table -->
                            <table class="table table-bordered" style="margin-top: 20px;">
                              <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                                <td align="left">業務の選択</td>
                                <td align="left">
                                  <select name="clinic_service_id" id="clinic_service_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    <option value="0">Close</option>
                                    <option value="-1">治療</option>
                                    @foreach ( $services as $service )
                                    <option value="{{ $service->service_id }}" @if ( $factility_id_current == $service->service_id ) selected @endif>{{ $service->service_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">チェアの選択</td>
                                <td align="left">
                                  <select name="facility_id" id="facility_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    @foreach ( $facilitys as $item )
                                    <option value="{{ $item->facility_id }}" @if ( $factility_id_current == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  @if ( $factility_id_current != 0 )
                                  <button type="" class="btn btn-sm btn-page btn-save" data-facility="{{ $facility->facility_id }}" data-time-hour="{{ $hour }}" data-time-minute="{{ $minute }}" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" data-time-hour-minute="{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @else
                                  <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @endif
                                </td>
                              </tr>
                            </table>
                            <!-- end child table -->
                          </div>
                          <!-- <div class="modal-footer">
                            <a href="{{ route('ortho.facilities.delete', [$clinic->clinic_id, $facility->facility_id]) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                            <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <!-- /Modal -->
                  </td>
                  <!-- blue -->
                  @elseif ( $arr_templates[$facility->facility_id][$time]->clinic_service_id == -1) )
                  <td align="center" class="col-blue" id="td-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                    <span data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" style="display: block; width: 100%; min-height: 20px;"><!-- {{ $arr_templates[$facility->facility_id][$time]->mbt_name }} --></span>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                          </div>
                          <div class="modal-body">
                            <!-- child table -->
                            <table class="table table-bordered" style="margin-top: 20px;">
                              <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                                <td align="left">業務の選択</td>
                                <td align="left">
                                  <select name="clinic_service_id" id="clinic_service_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    <option value="0">Close</option>
                                    <option value="-1">治療</option>
                                    @foreach ( $services as $service )
                                    <option value="{{ $service->service_id }}" @if ( $factility_id_current == $service->service_id ) selected @endif>{{ $service->service_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">チェアの選択</td>
                                <td align="left">
                                  <select name="facility_id" id="facility_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    @foreach ( $facilitys as $item )
                                    <option value="{{ $item->facility_id }}" @if ( $factility_id_current == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  @if ( $factility_id_current != 0 )
                                  <button type="" class="btn btn-sm btn-page btn-save" data-facility="{{ $facility->facility_id }}" data-time-hour="{{ $hour }}" data-time-minute="{{ $minute }}" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" data-time-hour-minute="{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @else
                                  <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @endif
                                </td>
                              </tr>
                            </table>
                            <!-- end child table -->
                          </div>
                          <!-- <div class="modal-footer">
                            <a href="{{ route('ortho.facilities.delete', [$clinic->clinic_id, $facility->facility_id]) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                            <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                          </div> -->
                        </div>
                      </div>
                    </div>
                    <!-- /Modal -->
                  </td>
                  <!-- brown -->
                  @else
                  <td align="center" class="col-brown" id="td-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                    <span data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" style="display: block; width: 100%; min-height: 20px;"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></span>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" role="dialog">
                      <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                          </div>
                          <div class="modal-body">
                            <!-- child table -->
                            <table class="table table-bordered" style="margin-top: 20px;">
                              <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                                <td align="left">業務の選択</td>
                                <td align="left">
                                  <select name="clinic_service_id" id="clinic_service_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    <option value="0">Close</option>
                                    <option value="-1">治療</option>
                                    @foreach ( $services as $service )
                                    <option value="{{ $service->service_id }}" @if ( $factility_id_current == $service->service_id ) selected @endif>{{ $service->service_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td align="left">チェアの選択</td>
                                <td align="left">
                                  <select name="facility_id" id="facility_id-{{ $factility_id_current }}-{{ $hour.$minute }}">
                                    @foreach ( $facilitys as $item )
                                    <option value="{{ $item->facility_id }}" @if ( $factility_id_current == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                    @endforeach
                                  </select>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  @if ( $factility_id_current != 0 )
                                  <button type="" class="btn btn-sm btn-page btn-save" data-facility="{{ $facility->facility_id }}" data-time-hour="{{ $hour }}" data-time-minute="{{ $minute }}" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" data-time-hour-minute="{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @else
                                  <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                  @endif
                                </td>
                              </tr>
                            </table>
                            <!-- end child table -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- /Modal -->
                  </td>
                  @endif
                <!-- brown -->
                @else
                <td align="center" class="col-brown" id="td-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                  <span data-toggle="modal" data-target="#myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" style="display: block; width: 100%; min-height: 20px;"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></span>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal-{{ $facility->facility_id }}-{{ $hour.$minute }}" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                        </div>
                        <div class="modal-body">
                          <!-- child table -->
                          <table class="table table-bordered" style="margin-top: 20px;">
                            <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                              <td align="left">業務の選択</td>
                              <td align="left">
                                <select name="clinic_service_id" id="clinic_service_id-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                                  <option value="0">Close</option>
                                  <option value="-1">治療</option>
                                  @foreach ( $services as $service )
                                  <option value="{{ $service->service_id }}">{{ $service->service_name }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td align="left">チェアの選択</td>
                              <td align="left">
                                <select name="facility_id" id="facility_id-{{ $facility->facility_id }}-{{ $hour.$minute }}">
                                  @foreach ( $facilitys as $item )
                                  <option value="{{ $item->facility_id }}" @if ( $facility->facility_id == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                @if ( $facility->facility_id != 0 )
                                <button type="" class="btn btn-sm btn-page btn-save" data-facility="{{ $facility->facility_id }}" data-time-hour="{{ $hour }}" data-time-minute="{{ $minute }}" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" data-time-hour-minute="{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                @else
                                <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $facility->facility_id }}-{{ $hour.$minute }}" id="btn-save-{{ $facility->facility_id }}-{{ $hour.$minute }}">保存する{{ $facility->facility_id }}</button>
                                @endif
                              </td>
                            </tr>
                          </table>
                          <!-- end child table -->
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

  <script>
    $(document).ready(function(){
      $(".btn-save").click(function(event){
        event.preventDefault();

        var data_id = $(this).attr('data-id');
        var data_facility_id = $(this).attr('data-facility');
        var data_time_hour = $(this).attr('data-time-hour');
        var data_time_minute = $(this).attr('data-time-minute');
        var data_time_hour_minute = $(this).attr('data-time-hour-minute');
        var td_obj = $('#td-' + data_id);
        var select_clinic_service_id = $('#clinic_service_id-' + data_id);
        var select_facility_id = $('#facility_id-' + data_id);

        // value from child table
        var clinic_service_id_new = select_clinic_service_id.val();
        var facility_id_new = select_facility_id.val();

        // set color td
        // green
        var td_current_cls = td_obj.attr('class');
        if ( clinic_service_id_new > 0 ) {
          setGreen(td_obj, td_current_cls);
        }
        // blue
        if ( clinic_service_id_new < 0 ) {
          setBlue(td_obj, td_current_cls);
        }
        // brown
        if ( clinic_service_id_new == 0 ) {
          setBrow(td_obj, td_current_cls);
        }

        // set positon td
        if ( facility_id_new != data_facility_id ) {
          var new_td_obj = $('#td-' + facility_id_new + '-' + data_time_hour_minute);
          // td_obj.removeClass(td_current_cls);
          // td_obj.addClass('col-brown');
          // td_obj.find('span').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
          setBrow(td_obj, td_current_cls);

          td_current_cls = new_td_obj.attr('class');
          // green
          if ( clinic_service_id_new > 0 ) {
            setGreen(new_td_obj, td_current_cls);
          }
          // blue
          if ( clinic_service_id_new < 0 ) {
            setBlue(new_td_obj, td_current_cls);
          }
          // brown
          if ( clinic_service_id_new == 0 ) {
            setBrow(new_td_obj, td_current_cls);
          }
        }


        console.log('#myModal-' + data_id);
        console.log(clinic_service_id_new);
        console.log(facility_id_new);
        $('#myModal-' + data_id).modal('hide');

      });

      function setGreen(td_obj, td_current_cls) {
        td_obj.removeClass(td_current_cls);
        td_obj.addClass('col-green');
        td_obj.find('span').html(' ');
        td_obj.find('span').append('   ');
      }
      function setBlue(td_obj, td_current_cls) {
        td_obj.removeClass(td_current_cls);
        td_obj.addClass('col-blue');
        td_obj.find('span').html('');
        td_obj.find('span').append('   ');
      }
      function setBrow(td_obj, td_current_cls) {
        td_obj.removeClass(td_current_cls);
        td_obj.addClass('col-brown');
        td_obj.find('span').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
      }
    });
  </script>

@endsection