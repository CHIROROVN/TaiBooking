@extends('backend.ortho.ortho')


@section('script')
  <script>
    function getVal(val) {
      var month = '';
      var old_day = "<?php echo (old('xray_date_day')) ? old('xray_date_day') : date('d', strtotime($xray->xray_date)); ?>";
      $('#day').find('option').remove();

      if ( $.isNumeric( val ) ) {
        month = val;
      } else {
        month = val.value;
      }

      $.ajax({
        method: "GET",
        url: "{{ route('ortho.xrays.get.day') }}",
        dataType: "json",
        data: { month: month }
      }).done(function( msg ) {
        // set value for select option month
        $('#day').append('<option value="0">--日</option>');
        $.each( msg, function( key, value ) {
          if ( old_day == value ) {
            $('#day').append('<option value="' + value + '" selected>' + value + '日</option>');
          } else {
            $('#day').append('<option value="' + value + '">' + value + '日</option>');
          }
        });
      });
    }
  </script>
@stop


@section('content')
{!! Form::open(array('route' => ['ortho.xrays.edit', $patient->p_id, $xray->xray_id], 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>放射線照射録管理　＞　レントゲンの入力</h3>
      
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title">名前</td>
            <td>{{ $patient->p_no }}　{{ $patient->p_name_f }}　{{ $patient->p_name_g }}（{{ $patient->p_name_g_kana }} {{ $patient->p_name_f_kana }}）</td>
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

        <!-- xray_date -->
        <?php
        $year_now = date('Y');
        $year_next = $year_now + 1;
        $year_prev = $year_now - 1;
        ?>
        <tr>
          <td class="col-title">撮影日 <span class="note_required">※</span></td>
          <td>
            <select name="xray_date_year" class="form-control form-control--small">
              <option value="0">----年</option>
              @if ( old('xray_date_year') )
              <option value="{{ $year_prev }}" @if(old('xray_date_year') == $year_prev) selected="" @endif>{{ $year_prev }}年</option>
              <option value="{{ $year_now }}" @if(old('xray_date_year') == $year_now) selected="" @endif>{{ $year_now }}年</option>
              <option value="{{ $year_next }}" @if(old('xray_date_year') == $year_next) selected="" @endif>{{ $year_next }}年</option>
              @else
              <option value="{{ $year_prev }}" @if(date('Y', strtotime($xray->xray_date)) == $year_prev) selected="" @endif>{{ $year_prev }}年</option>
              <option value="{{ $year_now }}" @if(date('Y', strtotime($xray->xray_date)) == $year_now) selected="" @endif>{{ $year_now }}年</option>
              <option value="{{ $year_next }}" @if(date('Y', strtotime($xray->xray_date)) == $year_next) selected="" @endif>{{ $year_next }}年</option>
              @endif
            </select>
            <select name="xray_date_month" class="form-control form-control--small" id="month" onchange="getVal(this);">
              <option value="0">--月</option>
              @for ( $i = 1; $i <= 12; $i++ )
                @if ( old('xray_date_month') )
                <option value="{{ $i }}" @if(old('xray_date_month') == $i) selected="" @endif>{{ $i }}月</option>
                @else
                <option value="{{ $i }}" @if(date('m', strtotime($xray->xray_date)) == $i) selected="" @endif>{{ $i }}月</option>
                @endif
              @endfor
            </select>
            <select name="xray_date_day" class="form-control form-control--small" id="day">
              <option value="0">--日</option>
            </select>
            <img src="{{ asset('') }}public/backend/ortho/common/image/dummy-calendar.png" height="23" width="27">
            <span class="error-input">@if ($errors->first('xray_date')) ※{!! $errors->first('xray_date') !!} @endif</span>
          </td>
        </tr>

        <!-- xray_place (clinic_name, clinic_id) -->
        <tr>
          <td class="col-title">撮影場所 <span class="note_required">※</span></td>
          <td>
            <select name="xray_place" class="form-control form-control--small">
              <option value="0">----</option>
              @foreach ( $clinics as $clinic )
                @if ( old('xray_place') )
                <option value="{{ $clinic->clinic_id }}" @if(old('xray_place') == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                @else
                <option value="{{ $clinic->clinic_id }}" @if($xray->xray_place == $clinic->clinic_id) selected="" @endif>{{ $clinic->clinic_name }}</option>
                @endif
              @endforeach
            </select>
            <span class="error-input">@if ($errors->first('xray_place')) ※{!! $errors->first('xray_place') !!} @endif</span>
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
                <option value="{{ $user->id }}" @if($xray->u_id == $user->id) selected="" @endif>{{ $user->u_name }}</option>
                @endif
              @endforeach
            </select>
            <span class="error-input">@if ($errors->first('u_id')) {!! $errors->first('u_id') !!} @endif</span>
          </td>
        </tr>

        <!-- xray_cat -->
        <tr>
          <td class="col-title">区分</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  @if( old('xray_cat_1') )
                  <label><input name="xray_cat_1" type="checkbox" value="1" @if(old('xray_cat_1') == 1) checked="" @endif>A_stage</label>
                  @else
                  <label><input name="xray_cat_1" type="checkbox" value="1" @if($xray->xray_cat_1 == 1) checked="" @endif>A_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_5') )
                  <label><input name="xray_cat_5" type="checkbox" value="1" @if(old('xray_cat_5') == 1) checked="" @endif>C_stage</label>
                  @else
                  <label><input name="xray_cat_5" type="checkbox" value="1" @if($xray->xray_cat_5 == 1) checked="" @endif>C_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if( old('xray_cat_9') )
                  <label><input name="xray_cat_9"  type="checkbox" value="1" @if(old('xray_cat_9') == 1) checked="" @endif>10G_stage</label>
                  @else
                  <label><input name="xray_cat_9"  type="checkbox" value="1" @if($xray->xray_cat_9 == 1) checked="" @endif>10G_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_13') )
                  <label><input name="xray_cat_13"  type="checkbox" value="1" @if(old('xray_cat_13') == 1) checked="" @endif>デンタル</label>
                  @else
                  <label><input name="xray_cat_13"  type="checkbox" value="1" @if($xray->xray_cat_13 == 1) checked="" @endif>デンタル</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_cat_2') )
                  <label><input name="xray_cat_2" type="checkbox" value="1" @if(old('xray_cat_2') == 1) checked="" @endif>A_stage F</label>
                  @else
                  <label><input name="xray_cat_2" type="checkbox" value="1" @if($xray->xray_cat_2 == 1) checked="" @endif>A_stage F</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_6') )
                  <label><input name="xray_cat_6" type="checkbox" value="1" @if(old('xray_cat_6') == 1) checked="" @endif>D_stage</label>
                  @else
                  <label><input name="xray_cat_6" type="checkbox" value="1" @if($xray->xray_cat_6 == 1) checked="" @endif>D_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_10') )
                  <label><input name="xray_cat_10" type="checkbox" value="1" @if(old('xray_cat_10') == 1) checked="" @endif>Ope前</label>
                  @else
                  <label><input name="xray_cat_10" type="checkbox" value="1" @if($xray->xray_cat_10 == 1) checked="" @endif>Ope前</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_14') )
                  <label><input name="xray_cat_14" type="checkbox" value="1" @if(old('xray_cat_14') == 1) checked="" @endif>オクルーザル</label>
                  @else
                  <label><input name="xray_cat_14" type="checkbox" value="1" @if($xray->xray_cat_14 == 1) checked="" @endif>オクルーザル</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_cat_3') )
                  <label><input name="xray_cat_3" type="checkbox" value="1" @if(old('xray_cat_3') == 1) checked="" @endif>B_stage</label>
                  @else
                  <label><input name="xray_cat_3" type="checkbox" value="1" @if($xray->xray_cat_3 == 1) checked="" @endif>B_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_7') )
                  <label><input name="xray_cat_7" type="checkbox" value="1" @if(old('xray_cat_7') == 1) checked="" @endif>G_stage</label>
                  @else
                  <label><input name="xray_cat_7" type="checkbox" value="1" @if($xray->xray_cat_7 == 1) checked="" @endif>G_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_11') )
                  <label><input name="xray_cat_11" type="checkbox" value="1" @if(old('xray_cat_11') == 1) checked="" @endif>Ope後</label>
                  @else
                  <label><input name="xray_cat_11" type="checkbox" value="1" @if($xray->xray_cat_11 == 1) checked="" @endif>Ope後</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_15') )
                  <label><input name="xray_cat_15" type="checkbox" value="1" @if(old('xray_cat_15') == 1) checked="" @endif>矯正終了</label>
                  @else
                  <label><input name="xray_cat_15" type="checkbox" value="1" @if($xray->xray_cat_15 == 1) checked="" @endif>矯正終了</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_cat_4') )
                  <label><input name="xray_cat_4" type="checkbox" value="1" @if(old('xray_cat_4') == 1) checked="" @endif>B_stage F</label>
                  @else
                  <label><input name="xray_cat_4" type="checkbox" value="1" @if($xray->xray_cat_4 == 1) checked="" @endif>B_stage F</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_8') )
                  <label><input name="xray_cat_8" type="checkbox" value="1" @if(old('xray_cat_8') == 1) checked="" @endif>5G_stage</label>
                  @else
                  <label><input name="xray_cat_8" type="checkbox" value="1" @if($xray->xray_cat_8 == 1) checked="" @endif>5G_stage</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_12') )
                  <label><input name="xray_cat_12" type="checkbox" value="1" @if(old('xray_cat_12') == 1) checked="" @endif>経過</label>
                  @else
                  <label><input name="xray_cat_12" type="checkbox" value="1" @if($xray->xray_cat_12 == 1) checked="" @endif>経過</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_cat_16') )
                  <label><input name="xray_cat_16" type="checkbox" value="1" @if(old('xray_cat_16') == 1) checked="" @endif>その他</label>
                  @else
                  <label><input name="xray_cat_16" type="checkbox" value="1" @if($xray->xray_cat_16 == 1) checked="" @endif>その他</label>
                  @endif
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_kind -->
        <tr>
          <td class="col-title">種類</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_kind_1') )
                  <label><input name="xray_kind_1" type="checkbox" value="1" @if(old('xray_kind_1') == 1) checked="" @endif>パノラマ</label>
                  @else
                  <label><input name="xray_kind_1" type="checkbox" value="1" @if($xray->xray_kind_1 == 1) checked="" @endif>パノラマ</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_kind_5') )
                  <label><input name="xray_kind_5" type="checkbox" value="1" @if(old('xray_kind_5') == 1) checked="" @endif>オクルーザル左</label>
                  @else
                  <label><input name="xray_kind_5" type="checkbox" value="1" @if($xray->xray_kind_5 == 1) checked="" @endif>オクルーザル左</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_kind_9') )
                  <label><input name="xray_kind_9" type="checkbox" value="1" @if(old('xray_kind_9') == 1) checked="" @endif>その他</label>
                  @else
                  <label><input name="xray_kind_9" type="checkbox" value="1" @if($xray->xray_kind_9 == 1) checked="" @endif>その他</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_kind_2') )
                  <label><input name="xray_kind_2" type="checkbox" value="1" @if(old('xray_kind_2') == 1) checked="" @endif>セファロ側</label>
                  @else
                  <label><input name="xray_kind_2" type="checkbox" value="1" @if($xray->xray_kind_2 == 1) checked="" @endif>セファロ側</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_kind_6') )
                  <label><input name="xray_kind_6" type="checkbox" value="1" @if(old('xray_kind_6') == 1) checked="" @endif>デンタル</label>
                  @else
                  <label><input name="xray_kind_6" type="checkbox" value="1" @if($xray->xray_kind_6 == 1) checked="" @endif>デンタル</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_kind_3') )
                  <label><input name="xray_kind_3" type="checkbox" value="1" @if(old('xray_kind_3') == 1) checked="" @endif>セファロ正</label>
                  @else
                  <label><input name="xray_kind_3" type="checkbox" value="1" @if($xray->xray_kind_3 == 1) checked="" @endif>セファロ正</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_kind_7') )
                  <label><input name="xray_kind_7" type="checkbox" value="1" @if(old('xray_kind_7') == 1) checked="" @endif>顔写真</label>
                  @else
                  <label><input name="xray_kind_7" type="checkbox" value="1" @if($xray->xray_kind_7 == 1) checked="" @endif>顔写真</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_kind_4') )
                  <label><input name="xray_kind_4" type="checkbox" value="1" @if(old('xray_kind_4') == 1) checked="" @endif>オクルーザル右</label>
                  @else
                  <label><input name="xray_kind_4" type="checkbox" value="1" @if($xray->xray_kind_4 == 1) checked="" @endif>オクルーザル右</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_kind_8') )
                  <label><input name="xray_kind_8" type="checkbox" value="1" @if(old('xray_kind_8') == 1) checked="" @endif>手根骨</label>
                  @else
                  <label><input name="xray_kind_8" type="checkbox" value="1" @if($xray->xray_kind_8 == 1) checked="" @endif>手根骨</label>
                  @endif
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_memo 1 -->
        <tr>
          <td class="col-title">備考1</td>
          <td>
            <div class="row">
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_memo_1') )
                  <label><input name="xray_memo_1" type="checkbox" value="1" @if(old('xray_memo_1') == 1) checked="" @endif>CD-R</label>
                  @else
                  <label><input name="xray_memo_1" type="checkbox" value="1" @if($xray->xray_memo_1 == 1) checked="" @endif>CD-R</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_memo_5') )
                  <label><input name="xray_memo_5" type="checkbox" value="1" @if(old('xray_memo_5') == 1) checked="" @endif>2回撮影</label>
                  @else
                  <label><input name="xray_memo_5" type="checkbox" value="1" @if($xray->xray_memo_5 == 1) checked="" @endif>2回撮影</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_memo_2') )
                  <label><input name="xray_memo_2" type="checkbox" value="1" @if(old('xray_memo_2') == 1) checked="" @endif>Dr.S</label>
                  @else
                  <label><input name="xray_memo_2" type="checkbox" value="1" @if($xray->xray_memo_2 == 1) checked="" @endif>Dr.S</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_memo_6') )
                  <label><input name="xray_memo_6" type="checkbox" value="1" @if(old('xray_memo_6') == 1) checked="" @endif>再治療</label>
                  @else
                  <label><input name="xray_memo_6" type="checkbox" value="1" @if($xray->xray_memo_6 == 1) checked="" @endif>再治療</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_memo_3') )
                  <label><input name="xray_memo_3" type="checkbox" value="1" @if(old('xray_memo_3') == 1) checked="" @endif>蓋裂</label>
                  @else
                  <label><input name="xray_memo_3" type="checkbox" value="1" @if($xray->xray_memo_3 == 1) checked="" @endif>蓋裂</label>
                  @endif
                </div>
                <div class="checkbox">
                  @if ( old('xray_memo_7') )
                  <label><input name="xray_memo_7" type="checkbox" value="1" @if(old('xray_memo_7') == 1) checked="" @endif>転院</label>
                  @else
                  <label><input name="xray_memo_7" type="checkbox" value="1" @if($xray->xray_memo_7 == 1) checked="" @endif>転院</label>
                  @endif
                </div>
              </div>
              <div class="col-md-3">
                <div class="checkbox">
                  @if ( old('xray_memo_4') )
                  <label><input name="xray_memo_4" type="checkbox" value="1" @if(old('xray_memo_4') == 1) checked="" @endif>過剰歯</label>
                  @else
                  <label><input name="xray_memo_4" type="checkbox" value="1" @if($xray->xray_memo_4 == 1) checked="" @endif>過剰歯</label>
                  @endif
                </div>
              </div>
            </div>
          </td>
        </tr>

        <!-- xray_memo -->
        <tr>
          <td class="col-title">備考2</td>
          <td>
            @if ( old('xray_memo') )
            <textarea name="xray_memo" id="xray_memo" cols="60" rows="3" class="form-control">{{ old('xray_memo') }}</textarea>
            @else
            <textarea name="xray_memo" id="xray_memo" cols="60" rows="3" class="form-control">{{ $xray->xray_memo }}</textarea>
            @endif
          </td>
        </tr>
      </table>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <!-- save -->
        <input name="" id="button" value="登録する" type="submit" class="btn btn-sm btn-page">
        <!-- delete -->
        <input type="button" value="削除" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal-{{ $xray->xray_id }}"/>
          <!-- Modal -->
          <div class="modal fade" id="myModal-{{ $xray->xray_id }}" role="dialog">
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
                  <a href="{{ route('ortho.xrays.delete', [ $patient->p_id, $xray->xray_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end Modal -->
      </div>
    </div>
  </div>
</section>
{!! Form::close() !!}

@stop


@section('script')
  <script>
    $(document).ready(function(){
        var val = $('#month').find("option:selected").val();
        if ( val != 0) {
          getVal(val);
        }
    });
  </script>
@stop