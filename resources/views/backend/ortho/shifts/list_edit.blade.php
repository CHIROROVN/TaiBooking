@extends('backend.ortho.ortho')

@section('content')

	<!-- Content shift search -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h1>シフト表</h1>

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
          
          {!! Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'id' => 'frm-shift-edit')) !!}
          <div class="fillter">
            <div class="col-md-12" style="text-align:center;">

              <button type="submit" class="btn btn-sm btn-page no-border" name="prev" value="" id="prev">&lt;&lt; 前月</button>&nbsp;&nbsp;&nbsp;&nbsp;
              <span id="text-year">{{ $yearNow }}</span>年<span id="text-month">{{ $monthNow }}</span>月&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="submit" class="btn btn-sm btn-page no-border" name="next" value="" id="next">翌月 &gt;&gt;</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
          </div>

          <div class="shift-list-edit-belong-kind">
            <div width="100%" align="center">
              <select name="s_belong_kind" class="form-control form-control--small" id="s_belong_kind">
                <option value="1" @if($s_belong_kind == 1) selected="" @endif>医師</option>
                <option value="2" @if($s_belong_kind == 2) selected="" @endif>衛生士（相談業務あり）</option>
                <option value="3" @if($s_belong_kind == 3) selected="" @endif>衛生士（相談業務なし）</option>
                <option value="4" @if($s_belong_kind == 4) selected="" @endif>事務</option>
                <option value="5" @if($s_belong_kind == 5) selected="" @endif>受付</option>
                <option value="6" @if($s_belong_kind == 6) selected="" @endif>放射線技師</option>
                <option value="7" @if($s_belong_kind == 7) selected="" @endif>滅菌</option>
              </select>
            </div>
          </div>
          </form>

          @if ( count($users) > 0 && !empty($users) )
          {!! Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
          <input type="hidden" name="date" value="{{ $yearNow }}-{{ $monthNow }}">
          <input type="hidden" name="s_belong_kind" value="{{ $s_belong_kind }}">

          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input value="保存する" type="submit" name="save" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input value="元に戻す" type="reset" name="back_save" class="btn btn-sm btn-page back-save">
              </div>
            </div>

            <div class="table-responsive">
            <div id="tableDiv_Arrays" class="tableDiv">
            <table class="table table-bordered FixedTables" id="Open_Text_Arrays">
              <tr class="col-title">
                <td>&nbsp;</td>
                @foreach ( $belongUsers as $belongUser )
                  @if ( isset($belongUser->belong_users) )
                  <?php $colspan = (isset($belongUser->belong_users)) ? count($belongUser->belong_users) : 1; ?>
                  <td colspan="{{ $colspan }}">{{ $belongUser->belong_name }}</td>
                  @endif
                @endforeach
              </tr>

              <tr class="col-title">
                <td>&nbsp;</td>
                @foreach ( $belongUsers as $belongUser )
                  @if ( isset($belongUser->belong_users) )
                    @foreach( $belongUser->belong_users as $u )
                    <td>{{ $u->u_name }}</td>
                    @endforeach
                  @endif
                @endforeach
              </tr>

              <!-- format value ==> -->
              <!-- ==> u_id|shift_date|linic_id -->
                <?php $selected = ''; ?>
                @foreach ( $days as $dayKey => $dayValue )
                <?php $fullDate = $yearNow . '-' . $monthNow . '-' . $dayKey; ?>
                <tr>
                  <td>{{ $dayValue }}</td>
                  @foreach ( $users as $user )
                  <td style="">
                    <select name="select[]" class="form-control form-control--small">
                    <option value="{{ $user->id }}|{{ $fullDate }}|0">▼選択</option>
                    <?php
                    if ( isset($shifts[$user->id . '|' . $fullDate . '|' . '-1']) ) {
                      $selected = 'selected';
                    } 
                    ?>
                    <option value="{{ $user->id }}|{{ $fullDate }}|-1" {{ $selected }}>休み</option>
                    @foreach ( $clinics as $clinic )
                    <?php
                    if ( isset($shifts[$user->id . '|' . $fullDate . '|' . $clinic->clinic_id]) ) {
                      $selected = 'selected';
                    } else {
                      $selected = '';
                    }
                    ?>
                    <option value="{{ $user->id }}|{{ $fullDate }}|{{ $clinic->clinic_id }}" {{ $selected }}>{{ $clinic->clinic_name }}</option>
                    @endforeach
                    
                    </select>
                  </td>
                  @endforeach
                <tr>
                @endforeach
            </table>
            </div>
            </div>

          </div>
          
          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input name="save" value="保存する" type="submit" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="back_save" value="元に戻す" type="reset" class="btn btn-sm btn-page back-save">
              </div>
            </div>
          </div>
          </form>
          @endif
        </div>
      </div>
      <!-- end container -->
    </section>

  <script>
    $(document).ready(function(){
      var yearNow = parseInt('{{ $yearNow }}');
      var monthNow = parseInt('{{ $monthNow }}');

      // prev
      $("#prev").click(function(){
        getDate(yearNow, monthNow - 1, $(this));
      });
      
      // next
      $("#next").click(function(){
        getDate(yearNow, monthNow + 1, $(this));
      });

      function getDate(year, month, obj) {
        monthNow = parseInt(month);
        yearNow = parseInt(year);
        
        // prev year
        if ( month < 1 ) {
          yearNow = year - 1;
          monthNow = 12;
        }

        // next year
        if ( month > 12 ) {
          yearNow = year + 1;
          monthNow = 1;
        }

        var monthNowShow = String(monthNow);
        if ( monthNow < 10 ) {
          var monthNowShow = String('0') + String(monthNow);
        }
        // $('#text-year').html(yearNow);
        // $('#text-month').html(monthNowShow);
        // $('#input-year').val(yearNow);
        // $('#input-month').val(monthNowShow);
        obj.val(yearNow + '-' + monthNowShow);
      }

      // change belong kind
      $( "#s_belong_kind" ).change(function() {
        $( "#frm-shift-edit" ).submit();
      });
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

  <script type="text/javascript">
    // this "tableDiv" must be the table's class
    $(".tableDiv").each(function() {      
        var Id = $(this).get(0).id;
        var maintbheight = 500;
        var maintbwidth = 1200;

        $("#" + Id + " .FixedTables").fixedTable({
            width: maintbwidth,
            height: maintbheight,
            fixedColumns: 1,
            // header style
            classHeader: "fixedHead col-title",
            // footer style        
            classFooter: "fixedFoot",
            // fixed column on the left        
            classColumn: "fixedColumn",
            // the width of fixed column on the left      
            fixedColumnWidth: 100,
            // table's parent div's id           
            outerId: Id,
            // tds' in content area default background color                     
            Contentbackcolor: "transparent",
            // tds' in content area background color while hover.     
            Contenthovercolor: "transparent", 
            // tds' in fixed column default background color   
            fixedColumnbackcolor:"transparent", 
            // tds' in fixed column background color while hover. 
            fixedColumnhovercolor:"transparent"  
        });        
    });
    $('.fixedTable > table').addClass('table table-bordered');
    $('.fixedTable > table tr td').each(function(index, el) {
      if ( $(this).html() === '&nbsp;' ) {
        $(this).parent().addClass('col-title');
      }

      
    });
  </script>
  <!-- End content shift search -->

@endsection