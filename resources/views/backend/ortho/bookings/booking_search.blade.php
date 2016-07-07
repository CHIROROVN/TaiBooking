@extends('backend.ortho.ortho')
@section('content')
	 <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>予約管理　＞　予約日時の変更</h3>
              <table class="table table-bordered">
                <tr>
                  <td class="col-title"><label for="textName">医院 [*]</label></td>
                  <td>
                    <select name="select10" id="select10" class="form-control">
                      <option selected="selected">▼選択</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td class="col-title">担当ドクター</td>
                  <td>
                    <div class="row">
                      <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 山田　太郎</label>
                        </div>
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 杉本　かよ</label>
                        </div>
                      </div>
                      <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 山田　花子</label>
                        </div>
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 大森　二郎</label>
                        </div>
                      </div>
                      <div class="col-xs-4 col-sm-4 col-md-4">
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 山田　三郎</label>
                        </div>
                        <div class="checkbox">
                          <label><input name="checkbox" value="checkbox" type="checkbox"> 理大　太郎</label>
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
                      <div class="row">
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value="1"  checked />1週間後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value="1"  checked />1ヵ月後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value="2"  />2ヵ月後</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value="3" />週指定</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value="5"  />日付指定</label>
                          </div>
                        </div>
                        <div class="col-xs-3 col-sm-2 col-md-1">
                          <div class="radio">
                            <label><input type="radio" name="week_radio" value=""  />週後</label>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                          <input style="display:inline" type="text" id="begin2" name="search_date" class="form-control" data-end="#end2">
                         <input type="button" class="btn btn-sm btn-page" name="button" value="Button" />
                        </div>
                      </div>
                    </td>
                </tr>
                <tr>
                  <td class="col-title">業務</td>
                  <td>
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
              <input name="ボタン" onclick="location.href='{{route('ortho.bookings.booking.result.calendar')}}'" value="検索開始（カレンダー表示）" type="button" class="btn btn-sm btn-page mar-right">
              <input name="ボタン2" onclick="location.href='{{route('ortho.bookings.booking.result.list')}}'" value="検索開始（一覧表表示）" type="button" class="btn btn-sm btn-page mar-right">
              <input name="button" id="button" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
          </div>
          </div>
        </div>
      </section>
@endsection