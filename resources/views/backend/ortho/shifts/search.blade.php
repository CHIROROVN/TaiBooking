@extends('backend.ortho.ortho')

@section('content')
	<!-- Content shift search -->
    <section id="page">
      <div class="container">
        <div class="row content-page">
          <h3>シフト管理　＞　シフトの検索</h3>
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="cbClinic">医院</label></td>
              <td>
                <select name="cbClinic" id="cbClinic" class="form-control form-control--small">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="cbMember">メンバー</label></td>
              <td>
                <select name="cbMember" id="cbMember" class="form-control form-control--small">
                  <option>▼選択</option>
                </select>
              </td>
            </tr>
            <tr>
              <td class="col-title"><label for="cbDate">日付</label></td>
              <td>
                <select name="select11" id="cbDate" class="form-control form-control--small">
                  <option>----年</option>
                </select>
                <select name="select11" class="form-control form-control--small">
                  <option>--月</option>
                </select>
                <select name="select11" class="form-control form-control--small">
                  <option>--日</option>
                </select>
                <img src="common/image/dummy-calendar.png" height="23" width="27">
              </td>
            </tr>
          </table>
        </div>
        <div class="row content-page">
          <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='shift_list.html'" value="検索開始" type="button" class="btn btn-sm btn-page">
          </div>
        </div>
          <h3>シフト管理　＞　シフトのCSV登録</h3>
          <table class="table table-bordered">
            <tr>
              <td class="col-title"><label for="btCSVfile">CSVファイル</label></td>
              <td>
                <button type="button" id="btCSVfile" class="bfs btn btn-page" data-style="fileStyle-l"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> ファイルを選ぶ</button>
              </td>
            </tr>
          </table>
        </div>
        <div class="row margin-bottom">
          <div class="col-md-12 text-center">
            <input name="button" id="button" value="取り込み開始" type="submit" class="btn btn-sm btn-page">
          </div>
        </div>
      </div>
    </section>
    
  <!-- End content shift search -->
@stop


@section('script')
  <script src="{{ asset('') }}public/backend/ortho/common/js/bootstrap-button-to-input-file.js"></script>
  <script>
    var filestyler = new buttontoinputFile();
  </script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>
@stop