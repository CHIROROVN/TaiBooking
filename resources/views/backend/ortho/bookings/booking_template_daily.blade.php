@extends('backend.ortho.ortho')

@section('content')

  <style>
    .td-content {
      /*display: table-cell;*/
      cursor: pointer;
      width: 100%;
      min-height: 27px;
      padding-top: 5px;
    }
  </style>
	 <!-- Content clinic booking template edit -->
  
  <section id="page">
    <div class="container">
      <div class="row content">
        <h3>予約雛形の適用と個別開閉　＞　{{ @$clinic->clinic_name }}</h3>



        <div class="fillter">
          <div class="col-md-12 page-left">
            {!! Form::open(array('route' => 'ortho.bookings.template.daily', 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
            <input type="hidden" name="date" value="{{ $date }}">
            <input type="hidden" name="clinic_id" value="{{ @$clinic->clinic_id }}">

            <select name="mbt_id" id="mbt_id" class="form-control form-control--small">
              <option value="">▼選択</option>
              @foreach ( $booking_templates as $key => $value )
              <option value="{{ $key }}" @if($s_mbt_id == $key) selected="" @endif>{{ $value }}</option>
              @endforeach
            </select>
            <input type="submit" class="btn btn-sm btn-page no-border" name="button" value="適用">
            </form>
          </div>
        </div>

        <div class="" align="center">
          <div class="col-md-12 page-left">
            <?php
            $prevDate = strtotime ( '-1 day' , strtotime ( $date ) ) ;
            $prevDate = date ( 'Y-m-d' , $prevDate );
            $nextDate = strtotime ( '+1 day' , strtotime ( $date ) ) ;
            $nextDate = date ( 'Y-m-d' , $nextDate );
            ?>
            {!! Form::open(array('route' => ['ortho.bookings.template.daily'], 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
            <input type="hidden" name="clinic_id" value="{{ @$clinic->clinic_id }}">
            <input type="hidden" name="s_mbt_id" value="{{ @$s_mbt_id }}">
            <button type="submit" class="btn btn-sm btn-page no-border" name="date" value="{{ $prevDate }}"><< 前日</button>
            &nbsp;&nbsp;&nbsp;&nbsp;{{ formatDateJp($date) }}&nbsp;&nbsp;&nbsp;&nbsp;
            <button type="submit" class="btn btn-sm btn-page no-border" name="date" value="{{ $nextDate }}">翌日 >></button>
          </div>
          </form>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center" width="10%">時間</td>
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
                <?php
                  $common_id = $facility->facility_id . '-' . $hour.$minute;
                  $facility_id = $facility->facility_id;
                  $color = 'brown';
                  $service_id = 0;
                  $fullValue = null;
                  $text = '';

                  if ( isset($arr_templates[$facility_id][$time]) ) {
                    $hour_template = substr($arr_templates[$facility->facility_id][$time]->template_time , 0, 2);
                    $minute_template = substr($arr_templates[$facility->facility_id][$time]->template_time , 2, 2);

                    if ( $arr_templates[$facility_id][$time]->clinic_service_id > 0
                          && $hour_template == $hour
                          && $minute_template == $minute ) {
                      $color = 'green';
                      if ( isset($services[$arr_templates[$facility_id][$time]->clinic_service_id]) ) {
                        $text = $services[$arr_templates[$facility_id][$time]->clinic_service_id]->service_name;
                      }
                    } elseif ( $arr_templates[$facility_id][$time]->clinic_service_id == -1
                                && $hour_template == $hour
                                && $minute_template == $minute ) {
                      $color = 'blue';
                      $text = '治療';
                    }
                    
                    $service_id = $arr_templates[$facility_id][$time]->clinic_service_id;
                    if ( $color === 'brown' ) {
                      $service_id = 0;
                    }

                    $fullValue = $facility_id . '|' . $service_id . '|' . $hour_template.$minute_template;
                    if ( $color === 'brown' ) {
                      $fullValue = null;
                    }
                  }
                ?>

                <!-- close -->
                <td align="center" class="col-{{ $color }}" id="td-{{ $common_id }}">
                  <div class="td-content" data-id="{{ $common_id }}" data-service-id="{{ $service_id }}" data-facility-id="{{ $facility_id }}" data-full-time="{{ $hour.$minute }}" data-hour="{{ $hour }}" data-minute="{{ $minute }}" data-toggle="modal" data-target="#myModal-{{ $common_id }}">
                    @if ( $color === 'brown' )
                    <img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />
                    @endif

                    <!-- input -->
                    <span>{{ $text }}</span>
                    @if ( $color === 'brown' )
                    <input type="hidden" class="input" name="" value="{{ $fullValue }}">
                    @else
                    <input type="hidden" class="input" name="facility_service_time[]" value="{{ $fullValue }}">
                    @endif
                  </div>
                  <!-- Modal -->
                  <div class="modal fade" id="myModal-{{ $common_id }}" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">{{trans('common.modal_header_popup_edit_clinic_booking_template')}}</h4>
                        </div>
                        <div class="modal-body">
                          <!-- child table -->
                          <table class="table table-bordered" style="margin-top: 20px;">
                            <tr style="font-weight: normal; border-bottom: 1px solid grey;">
                              <td align="left">業務の選択</td>
                              <td align="left">
                                <select name="" id="clinic_service_id-{{ $common_id }}">
                                  <option value="0">Close</option>
                                  <option value="-1">治療</option>
                                  @foreach ( $services as $service )
                                  <option value="{{ $service->clinic_service_id }}">{{ $service->service_name }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td align="left">チェアの選択</td>
                              <td align="left">
                                <select name="" id="facility_id-{{ $common_id }}">
                                  @foreach ( $facilitys as $item )
                                  <option value="{{ $item->facility_id }}" @if ( $facility->facility_id == $item->facility_id ) selected @endif>{{ $item->facility_name }}</option>
                                  @endforeach
                                </select>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2">
                                <button type="" class="btn btn-sm btn-page btn-save" data-id="{{ $common_id }}" data-full-time="{{ $hour.$minute }}" id="btn-save-{{ $common_id }}">{{ trans('common.modal_btn_ok') }}</button>
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
                <!-- end close -->
              @endforeach
            </tr>
            @endforeach
            
          </table>
        </div>
      </div>

      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='{{ route('ortho.bookings.template.set') }}'" value="月カレンダーに戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  <!-- End content clinic booking template edit -->

  <script>
    $(document).ready(function(){
      var facilityIdOld = 0;
      var serviceIdOld = 0;
      var tdObjOld = '';


      $('.td-content').click(function(event) {
        facilityIdOld = $(this).attr('data-facility-id');
        serviceIdOld = $(this).attr('data-service-id');

        var dataId = $(this).attr('data-id');
        tdObjOld = $('#td-' + dataId);
        console.log(serviceIdOld);

        // ser selected for select option
        $('#clinic_service_id-' + dataId + ' option').each(function() {
          if ( $(this).val() == serviceIdOld ) {
            $(this).prop("selected", true);
          }
        });
      });


      $(".btn-save").click(function(event){
        event.preventDefault();

        var data_id = $(this).attr('data-id');
        var dataFullTime = $(this).attr('data-full-time');

        // new value
        var serviceIdNew = $('#clinic_service_id-' + data_id).val();
        var serviceTextNew = $('#clinic_service_id-' + data_id).find('option:selected').text();
        var facilityIdNew = $('#facility_id-' + data_id).val();
        var fullValue = facilityIdNew + '|' + serviceIdNew + '|' + dataFullTime;

        // set color td
        var tdObjNew = $('#td-' + facilityIdNew + '-' + dataFullTime);
        console.log(fullValue);

        // green
        if ( serviceIdNew > 0 ) {
          setClear(tdObjOld, 0, '');
          setGreen(tdObjNew, serviceIdNew, fullValue, serviceTextNew);
        }
        // blue
        if ( serviceIdNew < 0 ) {
          setClear(tdObjOld, 0, '');
          setBlue(tdObjNew, serviceIdNew, fullValue, serviceTextNew);
        }
        // brown
        if ( serviceIdNew == 0 ) {
          setClear(tdObjOld, 0, '');
          setBrow(tdObjNew, 0, '');
        }


        console.log(serviceIdNew);
        $('#myModal-' + data_id).modal('hide');
      });

      function setGreen(objNew, serviceIdNew, value, text) {
        tdNewCls = objNew.attr('class');
        objNew.removeClass(tdNewCls);
        objNew.addClass('col-green');
        objNew.find('.td-content').html(' ');
        objNew.find('.td-content').append('');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // set value for hidden iput
        objNew.find('.td-content').html(text);
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
      }

      function setBlue(objNew, serviceIdNew, value, text) {
        tdNewCls = objNew.attr('class');
        objNew.removeClass(tdNewCls);
        objNew.addClass('col-blue');
        objNew.find('.td-content').html('');
        objNew.find('.td-content').append('');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // set value for hidden iput
        objNew.find('.td-content').html(text);
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
      }

      function setBrow(objNew, serviceIdNew, value) {
        tdNewCls = objNew.attr('class');
        if ( tdNewCls != 'col-brown' ) {
          objNew.removeClass(tdNewCls);
          objNew.addClass('col-brown');
          objNew.find('.td-content').html('');
          objNew.find('.td-content').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        // set value for hidden iput
        objNew.find('.td-content').append('<input type="hidden" class="input" name="facility_service_time[]" value="' + value + '">');
        }
      }

      function setClear(objNew, serviceIdNew, value) {
        tdNewCls = objNew.attr('class');
        if ( tdNewCls != 'col-brown' ) {
          objNew.removeClass(tdNewCls);
          objNew.addClass('col-brown');
          objNew.find('.td-content').html('');
          objNew.find('.td-content').append('<img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" />');
        // set service id
        objNew.find('.td-content').attr('data-service-id', serviceIdNew);
        objNew.find('.td-content > .input').val(value);
        objNew.find('.td-content > .input').attr('name', '');
        }
      }
    });
  </script>

@endsection