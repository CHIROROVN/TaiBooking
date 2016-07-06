@extends('backend.ortho.ortho')

@section('content')

	<!-- Content shift search -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h1>シフト表</h1>

{!! Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
          <div class="fillter">
            <div class="col-md-12" style="text-align:center;">
              <input type="button" class="btn btn-sm btn-page no-border" name="prev" id="prev" value="&lt;&lt; 前月">&nbsp;&nbsp;&nbsp;&nbsp;
              <span id="text-year">{{ $yearNow }}</span>年<span id="text-month">{{ $monthNow }}</span>月&nbsp;&nbsp;&nbsp;&nbsp;
              <input type="button" class="btn btn-sm btn-page no-border" name="next" id="next" value="翌月 &gt;&gt;">
            </div>
          </div>

          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input value="保存する" type="button" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;<input value="元に戻す" type="button" class="btn btn-sm btn-page">
              </div>
            </div>
            <table class="table table-bordered">
              <tr class="col-title">
                <td>&nbsp;</td>
                <td colspan="2">Dr</td>
                <td colspan="2">衛生士</td>
                <td colspan="2">滅菌</td>
                <td colspan="2">放射線</td>
                <td colspan="2">受付</td>
                </tr>
              <tr class="col-title">
                <td>&nbsp;</td>
                <td>田井</td>
                <td>高木雅</td>
                <td>会津</td>
                <td>吉末</td>
                <td>榊山</td>
                <td>大森</td>
                <td>金道</td>
                <td>大磐</td>
                <td>石川</td>
                <td>平田</td>
              </tr>
              <tr>
                <td>6/1(水)</td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/2(木)</td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select2" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/3(金)</td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select3" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/4(土)</td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select4" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/5(日)</td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select5" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/6(月)</td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select6" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/7(火)</td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select7" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              <tr>
                <td>6/8(水)</td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                <td><select name="select8" class="form-control form-control--small">
                  <option>▼選択</option>
                  <option>Clinic1</option>
                </select></td>
                </tr>
              </table>
            </div>
          
          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input name="save" value="保存する" type="submit" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;<input name="back_save" value="元に戻す" type="submit" class="btn btn-sm btn-page">
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end container -->
    </section>
</form>

    <script>
      $(document).ready(function(){
        int yearNow = '{{ $yearNow }}';
        int monthNow = '{{ $monthNow }}';

        // prev
        $("#prev").click(function(){
          getDate(yearNow, monthNow - 1);
        });
        
        // next
        $("#next").click(function(){
          getDate(yearNow, monthNow + 1);
        });

        function getDate(year, month) {
          monthNow = month;
          yearNow = year;
          
          // prev year
          if ( month == 1 ) {
            yearNow = year - 1;
          }

          // next year
          if ( month == 12 ) {
            yearNow = year + 1;
          }

          $('#text-year').html(yearNow);
          $('#text-month').html(monthNow);
        }
      });
    </script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
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
  <!-- End content shift search -->

@endsection