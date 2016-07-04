@extends('backend.ortho.ortho')

@section('content')

{!! Form::open(array('route' => ['ortho.bookings.booking.change.date', $booking->booking_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>予約管理　＞　予約日時の変更</h3>
        <table class="table table-bordered">

          <!-- clinic_id -->
          <tr>
            <td class="col-title"><label for="clinic_id">医院 [*]</label></td>
            <td>
              <select name="clinic_id" id="clinic_id" class="form-control">
                <option value="0">▼選択</option>
                @foreach ( $clinics as $clinic )
                <option value="{{ $clinic->clinic_id }}">{{ $clinic->clinic_name }}</option>
                @endforeach
              </select>
            </td>
          </tr>

          <tr>
            <td class="col-title">担当ドクター</td>
            <td>
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　太郎</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">杉本　かよ</label>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　花子</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">大森　二郎</label>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　三郎</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">理大　太郎</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">衛生士</td>
            <td>
              <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　太郎</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">杉本　かよ</label>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　花子</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">大森　二郎</label>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">山田　三郎</label>
                  </div>
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">理大　太郎</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">曜日</td>
            <td>
              <div class="row">
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">日</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">月</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">火</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">水</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">木</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">金</label>
                  </div>
                </div>
                <div class="col-xs-3 col-sm-2 col-md-1">
                  <div class="checkbox">
                    <label><input name="checkbox" value="checkbox" type="checkbox">土</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr>
              <td class=col-title>何週間後</td>
              <td>
                  <div>
                  <label><input type="radio" name="week_radio" class="btn btn-default" value="1"  checked />1週間後</label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="week_radio" class="btn btn-default" value="2" />1ヵ月後</label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="week_radio" class="btn btn-default" value="3" />2ヵ月後</label>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <label><input type="radio" name="week_radio" class="btn btn-default" value="5" />週指定</label>
                  &nbsp;&nbsp;<input type="text" name="week_later" class="form-control" size="3" value="">週後
                  &nbsp;&nbsp;<label><input type="radio" name="week_radio" class="btn btn-default" value="4" />日付指定</label>
                  <div class="form-group">
                      <div class="input-group">
                          <input type="text" id="begin2" name="search_date" class="form-control datepicker" data-end="#end2"  size="12">
                                  <span class="input-group-btn">
                                          <button class="btn btn-default" type="button" data-toggle="datepicker" data-target="#begin2">
                                              <span class="fa fa-calendar"></span>
                                          </button>
                                  </span>
                      </div>
                  </div>
                  </div>
              </td>
          </tr>
          <tr>
            <td class="col-title">業務</td>
            <td>
              <div class="row">
<select name="select10" id="select10" class="form-control">
                <option selected="selected">指定なし</option>
              </select>
<!--                      <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="radio">
                    <label><input name="radio" value="radio" type="radio">指定なし</label>
                  </div>
                  <div class="radio">
                    <label><input name="radio2" value="radio" type="radio">セット</label>
                    <select name="">
                      <option>--</option>
                      <option>斜面(15)</option>
                      <option>可フェンス(15)</option>
                      <option>ツインブロック(15)</option>
                      <option>BJA(15)</option>
                      <option>TP(15)</option>
                      <option>T4K(15)</option>
                      <option>SR(15)</option>
                      <option>シュワルツ(30)</option>
                      <option>バイオブロック(30)</option>
                      <option>インビザ(30)</option>
                      <option>プロト(30)</option>
                      <option>HG(30)</option>
                      <option>RPE(30)</option>
                    </select>
                  </div>
                  <div class="radio">
                    <label><input name="radio2" value="radio" type="radio">その他</label>
                    <select name="">
                      <option>--</option>
                      <option>斜面(15)</option>
                      <option>可フェンス(15)</option>
                      <option>ツインブロック(15)</option>
                      <option>BJA(15)</option>
                      <option>TP(15)</option>
                      <option>T4K(15)</option>
                      <option>SR(15)</option>
                      <option>シュワルツ(30)</option>
                      <option>バイオブロック(30)</option>
                      <option>インビザ(30)</option>
                      <option>プロト(30)</option>
                      <option>HG(30)</option>
                      <option>RPE(30)</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="radio">
                    <label><input name="radio" value="radio" type="radio">相談</label>
                  </div>
                  <div class="radio">
                    <label><input name="radio2" value="radio" type="radio">チェック</label>
                    <select name="">
                      <option>--</option>
                      <option>斜面(15)</option>
                      <option>可フェンス(15)</option>
                      <option>ツインブロック(15)</option>
                      <option>BJA(15)</option>
                      <option>TP(15)</option>
                      <option>T4K(15)</option>
                      <option>SR(15)</option>
                      <option>シュワルツ(30)</option>
                      <option>バイオブロック(30)</option>
                      <option>インビザ(30)</option>
                      <option>プロト(30)</option>
                      <option>HG(30)</option>
                      <option>RPE(30)</option>
                    </select>
                  </div>
                  <div class="radio">
                    <label><input name="radio2" value="radio" type="radio">即日</label>
                    <select name="">
                      <option>--</option>
                      <option>斜面(15)</option>
                      <option>可フェンス(15)</option>
                      <option>ツインブロック(15)</option>
                      <option>BJA(15)</option>
                      <option>TP(15)</option>
                      <option>T4K(15)</option>
                      <option>SR(15)</option>
                      <option>シュワルツ(30)</option>
                      <option>バイオブロック(30)</option>
                      <option>インビザ(30)</option>
                      <option>プロト(30)</option>
                      <option>HG(30)</option>
                      <option>RPE(30)</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4">
                  <div class="radio">
                    <label><input name="radio" value="radio" type="radio">診断</label>
                  </div>
                  <div class="radio">
                    <label><input name="radio2" value="radio" type="radio">rem</label>
                    <select name="">
                      <option>--</option>
                      <option>斜面(15)</option>
                      <option>可フェンス(15)</option>
                      <option>ツインブロック(15)</option>
                      <option>BJA(15)</option>
                      <option>TP(15)</option>
                      <option>T4K(15)</option>
                      <option>SR(15)</option>
                      <option>シュワルツ(30)</option>
                      <option>バイオブロック(30)</option>
                      <option>インビザ(30)</option>
                      <option>プロト(30)</option>
                      <option>HG(30)</option>
                      <option>RPE(30)</option>
                    </select>
                  </div>
                </div>-->
              </div>
            </td>
          </tr>
        </table>
    </div>
<!--
<script language="javascript">
  function inputsEnable(flg){
    var input_tags = document.getElementById("timeband").getElementsByTagName("input");

    if (document.getElementById("care").checked == true){
      return false;
    }

    for(var i=0;i<input_tags.length;i++){
      input_tags[i].disabled = flg;
    }
  }
</script>
<script language="javascript">
  var input_tags = document.getElementById("timeband").getElementsByTagName("input");

  for(var i=0;i<input_tags.length;i++){
    input_tags[i].disabled = true;
  }
</script>
-->
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="ボタン" onclick="location.href='{{ route('ortho.bookings.booking.change.confirm', [ $booking->booking_id, 'next' => 'booking_result_calendar' ]) }}'" value="検索開始（カレンダー表示）" type="button" class="btn btn-sm btn-page mar-right">
        <input name="ボタン2" onclick="location.href='{{ route('ortho.bookings.booking.change.confirm', [ $booking->booking_id, 'next' => 'booking_result_list' ]) }}'" value="検索開始（一覧表表示）" type="button" class="btn btn-sm btn-page mar-right">
        <input name="button" id="button" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
    </div>
    </div>
  </div>
</section>
</form>

@endsection