@extends('backend.ortho.ortho')

@section('content')
<!-- Content xray_3dct_regist -->
  <section id="page">
  {!! Form::open( ['id' => 'frmX3dctRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.xrays.x3dct.edit', $patient->p_id, $ct->ct_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
    <div class="container">
      <div class="row content-page">
        <h3>放射線照射録管理　＞　3D-CTの入力</h3>

        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="col-title">名前</td>
              <td>{{ $patient->p_no }}　{{ $patient->p_name_f }}　{{ $patient->p_name_g }}（{{ $patient->p_name_f_kana }} {{ $patient->p_name_g_kana }}）</td>
              <td class="col-title">担当</td>
              <td>
                @foreach ( $users as $user )
                  @if ( $user->id == $patient->p_dr )
                  {{ $user->u_name }}
                  @endif
                @endforeach
              </td>
            </tr>
            <tr>
              <td class="col-title">生年月日</td>
              <td>{{ date('Y', strtotime($patient->p_birthday)) }}年{{ date('m', strtotime($patient->p_birthday)) }}月{{ date('d', strtotime($patient->p_birthday)) }}日</td>
              <td class="col-title">性別</td>
              <td><?php echo ($patient->p_sex == 1) ? '男' : '女'; ?></td>
            </tr>
          </tbody>
        </table>

        <table class="table table-bordered">

          <!-- ct_date -->
          <tr>
            <td class="col-title">撮影日 <span class="note_required">※</span></td>
            <td>
              <select style="text-align: center;" name="year" id="year" class="form-control form-control--small">
                <option value="">----年</option>
                <option value="{{$prevYear}}" @if($prevYear == $ct_year) selected="" @endif>{{$prevYear}}年</option>
                <option value="{{$currYear}}" @if($currYear == $ct_year) selected="" @endif>{{$currYear}}年</option>
                <option value="{{$nextYear}}" @if($nextYear == $ct_year) selected="" @endif>{{$nextYear}}年</option>
              </select>
              <select style="text-align: center;" name="month" id="month" class="form-control form-control--small">
                <option value="">--月</option>
                @for ( $i = 1; $i <= 12; $i++ )
                <option value="{{ $i }}" @if($ct_month == $i) selected="" @endif>{{ $i }}月</option>
                @endfor
              </select>
              <select style="text-align: center;" name="day" id="day" class="form-control form-control--small">
                <option value="">--日</option>
                @for ( $i = 1; $i <= $number_day; $i++ )
                <option value="{{ $i }}" @if($ct_day == $i) selected="" @endif>{{ $i }}日</option>
                @endfor
              </select>
              <img src="{{asset('public/backend/ortho/common/image/dummy-calendar.png')}}" height="23" width="27">
              <span class="error-input">@if ($errors->first('ct_date')) ※{!! $errors->first('ct_date') !!} @endif</span>
            </td>
          </tr>

          <!-- u_id -->
          <tr>
            <td class="col-title">撮影者</td>
            <td>
              <select name="u_id" class="form-control form-control--small">
                <option value="0">----</option>
                @foreach ( $users as $user )
                  @if ( old('u_id') )
                  <option value="{{ $user->id }}" @if(old('u_id') == $user->id) selected="" @endif>{{ $user->u_name }}</option>
                  @else
                  <option value="{{ $user->id }}" @if($ct->u_id == $user->id) selected="" @endif>{{ $user->u_name }}</option>
                  @endif
                @endforeach
              </select>
              <span class="error-input">@if ($errors->first('u_id')) {!! $errors->first('u_id') !!} @endif</span>
            </td>
          </tr>

          <tr>
            <td class="col-title">区分</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_cat_1') )
                    <label><input name="ct_cat_1" type="checkbox" value="1" @if(old('ct_cat_1') == 1) checked="" @endif>1回目</label>
                    @else
                    <label><input name="ct_cat_1" type="checkbox" value="1" @if($ct->ct_cat_1 == 1) checked="" @endif>1回目</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_cat_2') )
                    <label><input name="ct_cat_2" type="checkbox" value="1" @if(old('ct_cat_2') == 1) checked="" @endif>2回目</label>
                    @else
                    <label><input name="ct_cat_2" type="checkbox" value="1" @if($ct->ct_cat_2 == 1) checked="" @endif>2回目</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_cat_3') )
                    <label><input name="ct_cat_3"  type="checkbox" value="1" @if(old('ct_cat_3') == 1) checked="" @endif>3回目</label>
                    @else
                    <label><input name="ct_cat_3"  type="checkbox" value="1" @if($ct->ct_cat_3 == 1) checked="" @endif>3回目</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_cat_4') )
                    <label><input name="ct_cat_4" type="checkbox" value="1" @if(old('ct_cat_4') == 1) checked="" @endif>Ope前</label>
                    @else
                    <label><input name="ct_cat_4" type="checkbox" value="1" @if($ct->ct_cat_4 == 1) checked="" @endif>Ope前</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_cat_5') )
                    <label><input name="ct_cat_5" type="checkbox" value="1" @if(old('ct_cat_5') == 1) checked="" @endif>Ope後</label>
                    @else
                    <label><input name="ct_cat_5" type="checkbox" value="1" @if($ct->ct_cat_5 == 1) checked="" @endif>Ope後</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_cat_6') )
                    <label><input name="ct_cat_6" type="checkbox" value="1" @if(old('ct_cat_6') == 1) checked="" @endif>インプラント</label>
                    @else
                    <label><input name="ct_cat_6" type="checkbox" value="1" @if($ct->ct_cat_6 == 1) checked="" @endif>インプラント</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_cat_7') )
                    <label><input name="ct_cat_7" type="checkbox" value="1" @if(old('ct_cat_7') == 1) checked="" @endif>その他</label>
                    @else
                    <label><input name="ct_cat_7" type="checkbox" value="1" @if($ct->ct_cat_7 == 1) checked="" @endif>その他</label>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <!-- ct_mode -->
          <tr>
            <td class="col-title">モード</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_mode_1') )
                    <label><input name="ct_mode_1" type="checkbox" value="1" @if(old('ct_mode_1') == 1) checked="" @endif>I</label>
                    @else
                    <label><input name="ct_mode_1" type="checkbox" value="1" @if($ct->ct_mode_1 == 1) checked="" @endif>I</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_mode_2') )
                    <label><input name="ct_mode_2" type="checkbox" value="1" @if(old('ct_mode_2') == 1) checked="" @endif>P</label>
                    @else
                    <label><input name="ct_mode_2" type="checkbox" value="1" @if($ct->ct_mode_2 == 1) checked="" @endif>P</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_mode_3') )
                    <label><input name="ct_mode_3" type="checkbox" value="1" @if(old('ct_mode_3') == 1) checked="" @endif>F</label>
                    @else
                    <label><input name="ct_mode_3" type="checkbox" value="1" @if($ct->ct_mode_3 == 1) checked="" @endif>F</label>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-title">撮影条件</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_condition_1') )
                    <label><input name="ct_condition_1" type="checkbox" value="1" @if(old('ct_condition_1') == 1) checked="" @endif>100kv 10mA</label>
                    @else
                    <label><input name="ct_condition_1" type="checkbox" value="1" @if($ct->ct_condition_1 == 1) checked="" @endif>100kv 10mA</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_condition_3') )
                    <label><input name="ct_condition_3" type="checkbox" value="1" @if(old('ct_condition_3') == 1) checked="" @endif>120kv 5mA</label>
                    @else
                    <label><input name="ct_condition_3" type="checkbox" value="1" @if($ct->ct_condition_3 == 1) checked="" @endif>120kv 5mA</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_condition_2') )
                    <label><input name="ct_condition_2" type="checkbox" value="1" @if(old('ct_condition_2') == 1) checked="" @endif>100kv 15mA</label>
                    @else
                    <label><input name="ct_condition_2" type="checkbox" value="1" @if($ct->ct_condition_2 == 1) checked="" @endif>100kv 15mA</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_condition_4') )
                    <label><input name="ct_condition_4" type="checkbox" value="1" @if(old('ct_condition_4') == 1) checked="" @endif>120kv 10mA</label>
                    @else
                    <label><input name="ct_condition_4" type="checkbox" value="1" @if($ct->ct_condition_4 == 1) checked="" @endif>120kv 10mA</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_condition_5') )
                    <label><input name="ct_condition_5" type="checkbox" value="1" @if(old('ct_condition_5') == 1) checked="" @endif>120kv 15mA</label>
                    @else
                    <label><input name="ct_condition_5" type="checkbox" value="1" @if($ct->ct_condition_5 == 1) checked="" @endif>120kv 15mA</label>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>

          <tr>
            <td class="col-title">備考1</td>
            <td>
              <div class="row">
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_memo_1') )
                    <label><input name="ct_memo_1" type="checkbox" value="1" @if(old('ct_memo_1') == 1) checked="" @endif>CD-R</label>
                    @else
                    <label><input name="ct_memo_1" type="checkbox" value="1" @if($ct->ct_memo_1 == 1) checked="" @endif>CD-R</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_memo_5') )
                    <label><input name="ct_memo_5" type="checkbox" value="1" @if(old('ct_memo_5') == 1) checked="" @endif>2回撮影</label>
                    @else
                    <label><input name="ct_memo_5" type="checkbox" value="1" @if($ct->ct_memo_5 == 1) checked="" @endif>2回撮影</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_memo_2') )
                    <label><input name="ct_memo_2" type="checkbox" value="1" @if(old('ct_memo_2') == 1) checked="" @endif>Dr.S</label>
                    @else
                    <label><input name="ct_memo_2" type="checkbox" value="1" @if($ct->ct_memo_2 == 1) checked="" @endif>Dr.S</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_memo_6') )
                    <label><input name="ct_memo_6" type="checkbox" value="1" @if(old('ct_memo_6') == 1) checked="" @endif>再治療</label>
                    @else
                    <label><input name="ct_memo_6" type="checkbox" value="1" @if($ct->ct_memo_6 == 1) checked="" @endif>再治療</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_memo_3') )
                    <label><input name="ct_memo_3" type="checkbox" value="1" @if(old('ct_memo_3') == 1) checked="" @endif>口蓋裂</label>
                    @else
                    <label><input name="ct_memo_3" type="checkbox" value="1" @if($ct->ct_memo_3 == 1) checked="" @endif>口蓋裂</label>
                    @endif
                  </div>
                  <div class="checkbox">
                    @if ( old('ct_memo_7') )
                    <label><input name="ct_memo_7" type="checkbox" value="1" @if(old('ct_memo_7') == 1) checked="" @endif>転院</label>
                    @else
                    <label><input name="ct_memo_7" type="checkbox" value="1" @if($ct->ct_memo_7 == 1) checked="" @endif>転院</label>
                    @endif
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="checkbox">
                    @if ( old('ct_memo_4') )
                    <label><input name="ct_memo_4" type="checkbox" value="1" @if(old('ct_memo_4') == 1) checked="" @endif>過剰歯</label>
                    @else
                    <label><input name="ct_memo_4" type="checkbox" value="1" @if($ct->ct_memo_4 == 1) checked="" @endif>過剰歯</label>
                    @endif
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">備考2</td>
            <td>
              @if ( old('ct_memo') )
              <textarea name="ct_memo" cols="60" rows="3" class="form-control">{{ old('ct_memo') }}</textarea>
              @else
              <textarea name="ct_memo" cols="60" rows="3" class="form-control">{{ $ct->ct_memo }}</textarea>
              @endif
            </td>
          </tr>
        </table>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <!-- save -->
          <input name="btnSave" id="btnSave" value="登録する" type="submit" class="btn btn-sm btn-page">
          <!-- delete -->
          <input type="button" value="削除" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal-{{ $ct->ct_id }}"/>
          <!-- Modal -->
          <div class="modal fade" id="myModal-{{ $ct->ct_id }}" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                </div>
                <div class="modal-body">
                  <p>{{ trans('common.modal_content_delete') }}</p>
                </div>
                <div class="modal-footer">
                  <a href="{{ route('ortho.xrays.x3dct.delete', [ $patient->p_id, $ct->ct_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end Modal -->
        </div>
      </div>
    </div>
    {!! Form::close() !!}
  </section>
  <!-- End content xray_3dct_regist --> 

@stop


@section('script')
  <script type="text/javascript">
    $('#year').change(function() {
      var curr_year = $(this).val();
      var optionMonth = "<option value=''>--月</option>";
      var ct_month = '<?php
                      if ( empty($ct->ct_date) ) {
                        echo '';
                      } else {
                        echo date('m', strtotime($ct->ct_date));
                      }
                    ?>';

        for(m=1; m<=12; m++){
          if ( m == ct_month ) {
            optionMonth += "<option value="+num2digit(m)+" selected>" + num2digit(m) + '月' + "</option>";
          } else {
            optionMonth += "<option value="+num2digit(m)+">" + num2digit(m) + '月' + "</option>";
          }
        }
        $('#month').html(optionMonth);
        var now_month = (new Date).getMonth() + 1;
        $('#month option:eq(' + now_month + ')').prop('selected', true);

        var curr_month = $('#month option:selected').val();
        var getDays = getDaysInMonth(curr_year, curr_month);
        var optionYDay = "<option value=''>--日</option>";
            for(y = 1; y <= getDays; y++){
                optionYDay += "<option value="+num2digit(y)+">" + num2digit(y) + '日' + "</option>";
            }
        $('#day').html(optionYDay);
        $('#day option:eq(' + (new Date).getDate() + ')').prop('selected', true);

        if(curr_year == ''){
          $('#month').html("<option value=''>--月</option>");
          $('#day option:eq(' + '' + ')').prop('selected', true);
          $('#day').html("<option value=''>--日</option>");
        }
     });

    $('#month').change(function() {
      var year = $('#year option:selected').val();
      var month = num2digit($(this).val());
      var getDays = getDaysInMonth(year, month);
      var optionDay = "<option value=''>--日</option>";
      var ct_day = '<?php
                      if ( empty($ct->ct_date) ) {
                        echo '';
                      } else {
                        echo date('d', strtotime($ct->ct_date));
                      }
                    ?>';
      for(d = 1; d <= getDays; d++){
        if ( d == ct_day ) {
          optionDay += "<option value="+num2digit(d)+" selected>" + num2digit(d) + '日' + "</option>";
        } else {
          optionDay += "<option value="+num2digit(d)+">" + num2digit(d) + '日' + "</option>";
        }
      }
      $('#day').html(optionDay);
      if(month == '0'){
        $('#day').html("<option value=''>--日</option>");
      }
      $('#day option:eq(' + (new Date).getDate() + ')').prop('selected', true);
    });

    function getDaysInMonth(year,month) {
      return new Date(year, month, 0).getDate();
    }

    function num2digit(n){
      return n > 9 ? "" + n: "0" + n;
    }
  </script> 
@stop