@extends('backend.ortho.ortho')

<script>
  // get days in month year => return number
  var curYearStar = '';
  var curMonthStar = '';
  var curYearEnd = '';
  var curMonthEnd = '';

  function getDayName(yearMonthDay) {
    var d = new Date(yearMonthDay);
    var weekday = new Array(7);
    weekday[0]=  "日";
    weekday[1] = "月";
    weekday[2] = "火";
    weekday[3] = "水";
    weekday[4] = "木";
    weekday[5] = "金";
    weekday[6] = "土";
    return weekday[d.getDay()];
  }
  function daysInMonth(year, month, editDay) {
    var str = '<option value="">---日</option>';
    if ( year.length && month.length ) {
      var numbers = new Date(year, month, 0).getDate();
      console.log(year);
      console.log(month);
      console.log(numbers);
      var selected = '';
      for (var i = 1; i <= numbers; i++) {
        if ( editDay == i ) {
          selected = 'selected';
        } else {
          selected = '';
        }
        var dayName = getDayName(year + '-' + month + '-' + i);
        if ( i < 10 ) {
          i = '0' + i;
        }
        str = str + '<option value="' + i + '" ' + selected + '>' + i + '日(' + dayName + ')</option>';
      }
    }
    return str;
  }
  function monthsInYear(year, editMonth) {
    var str = '<option value="">---月</option>';
    if ( year.length ) {
      var selected = '';
      for (var i = 1; i <= 12; i++) {
        if ( editMonth == i ) {
          selected = 'selected';
        } else {
          selected = '';
        }
        if ( i < 10 ) {
          i = '0' + i;
        }
        str = str + '<option value="' + i + '" ' + selected + '>' + i + '月</option>';
      }
    }
    return str;
  }

  function getMonths(object, year, editMonth) {
    if ( object == 'ddr_start_month' ) {
      curYearStar = year;
    } else {
      curYearEnd = year;
    }
    $('#' + object).html(monthsInYear(year, editMonth));
    // $('#ddr_start_month').html(monthsInYear(year, editMonth));
  }
  function getDays(object, month, editDay) {
    if ( object == 'ddr_start_day' ) {
      curMonthStar = month;
      $('#' + object).html(daysInMonth(curYearStar, curMonthStar, editDay));
    } else {
      curMonthEnd = month;
      $('#' + object).html(daysInMonth(curYearEnd, curMonthEnd, editDay));
    }
    // $('#ddr_start_day').html(daysInMonth(curYearStar, curMonthStar, editDay));
  }
</script>

@section('content')
{!! Form::open(array('route' => 'ortho.ddrs.regist', 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content content--calendar">
        <h3>院長カレンダー　＞　予定の新規登録</h3>

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td class="col-title">開始日時 <span class="note-required">(※)</span></td>
              <td>

                <!-- start_date -->
                <input type="hidden" name="start_date" value="{{ $start_date }}">

                <!-- ddr_start_date -->
                <select name="ddr_start_year" id="ddr_start_year" class="form-control form-control--small" onchange="getMonths('ddr_start_month', $(this).val(), '')">
                  <option value="">---年</option>
                  @foreach ( $years as $year )
                  <option value="{{ $year }}" @if($ddr_start_date_y == $year) selected="" @endif>{{ $year }}</option>
                  @endforeach
                </select>
                <select name="ddr_start_month" id="ddr_start_month" class="form-control form-control--small" onchange="getDays('ddr_start_day', $(this).val(), '')">
                  <option value="">---月</option>
                </select>
                <select name="ddr_start_day" id="ddr_start_day" class="form-control form-control--small">
                  <option value="">---日</option>
                </select>
                <img src="{{ asset('') }}public/backend/ortho/common/image/dummy-calendar.png" width="27" height="23" />
                <input type="hidden" id="hidden-datetime">
                
                <!-- ddr_start_time -->
                <select name="ddr_start_hh" class="form-control form-control--small">
                  <option value="">---時</option>
                  @foreach ( $hours as $hour)
                  <option value="{{ $hour }}" @if(old('ddr_start_hh') == $hour) selected="" @endif>{{ $hour }}時</option>
                  @endforeach
                </select>
                <select name="ddr_start_mm" class="form-control form-control--small">
                  <option value="">---分</option>
                  <option value="00" @if(old('ddr_start_mm') == '00') selected="" @endif>00分</option>
                  <option value="15" @if(old('ddr_start_mm') == '15') selected="" @endif>15分</option>
                  <option value="30" @if(old('ddr_start_mm') == '30') selected="" @endif>30分</option>
                  <option value="45" @if(old('ddr_start_mm') == '45') selected="" @endif>45分</option>
                </select>
                から
                <span class="error-input">@if ($errors->first('ddr_start_date')) {!! $errors->first('ddr_start_date') !!} @endif</span>
              </td>
            </tr>
            <tr>
              <td class="col-title">終了日時</td>
              <td>
                <!-- ddr_end_date -->
                <select name="ddr_end_year" id="ddr_end_year" class="form-control form-control--small" onchange="getMonths('ddr_end_month', $(this).val(), '')">
                  <option value="">---年</option>
                  @foreach ( $years as $year )
                  <option value="{{ $year }}">{{ $year }}</option>
                  @endforeach
                </select>
                <select name="ddr_end_month" id="ddr_end_month" class="form-control form-control--small" onchange="getDays('ddr_end_day', $(this).val(), '')">
                  <option value="">---月</option>
                </select>
                <select name="ddr_end_day" id="ddr_end_day" class="form-control form-control--small">
                  <option value="">---日</option>
                </select>
                <img src="{{ asset('') }}public/backend/ortho/common/image/dummy-calendar.png" width="27" height="23" />
                <input type="hidden" id="hidden-datetime1">

                <!-- ddr_end_time -->
                <select name="ddr_end_hh" class="form-control form-control--small">
                  <option value="">--時</option>
                  @foreach ( $hours as $hour)
                  <option value="{{ $hour }}" @if(old('ddr_end_hh') == $hour) selected="" @endif>{{ $hour }}時</option>
                  @endforeach
                </select>
                <select name="ddr_end_mm" class="form-control form-control--small">
                  <option>--分</option>
                  <option value="00" @if(old('ddr_end_mm') == '00') selected="" @endif>00分</option>
                  <option value="15" @if(old('ddr_end_mm') == '15') selected="" @endif>15分</option>
                  <option value="30" @if(old('ddr_end_mm') == '30') selected="" @endif>30分</option>
                  <option value="45" @if(old('ddr_end_mm') == '45') selected="" @endif>45分</option>
                </select>
                まで
              </td>
            </tr>
            <tr>
              <td class="col-title">内容</td>
              <td>
                <!-- ddr_kind -->
                <select name="ddr_kind" class="form-control form-control--small">
                  <option style="color: #000" value="1" @if(old('ddr_kind') == 1) selected="" @endif>■</option>
                  <option style="color: #F00" value="2" @if(old('ddr_kind') == 2) selected="" @endif>■</option>
                  <option style="color: #00F" value="3" @if(old('ddr_kind') == 3) selected="" @endif>■</option>
                  <option style="color: #390" value="4" @if(old('ddr_kind') == 4) selected="" @endif>■</option>
                  <option style="color: #F90" value="5" @if(old('ddr_kind') == 5) selected="" @endif>■</option>
                </select>          
                <input name="ddr_contents" type="text" value="{{ old('ddr_contents') }}" class="form-control form-control--medium"/>
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 text-center">
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}


<script type="text/javascript">
  $(document).ready(function(){
    var numbers = new Date('2016', '2', 0).getDate();
    console.log(numbers);
    var editYearStar = "{{ $ddr_start_date_y }}";
    var editMonthStar = "{{ $ddr_start_date_m }}";
    var editDayStar = "{{ $ddr_start_date_d }}";

    getMonths('ddr_start_month', editYearStar, editMonthStar);
    getDays('ddr_start_day', editMonthStar, editDayStar);

    // start date
    $('#ddr_start_year').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_start_month').html('<option value="">---月</option>');
        $('#ddr_start_day').html('<option value="">---日</option>');
      }
    });
    $('#ddr_start_month').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_start_day').html('<option value="">---日</option>');
      }
    });
    // end date
    $('#ddr_end_year').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_end_month').html('<option value="">---月</option>');
        $('#ddr_end_day').html('<option value="">---日</option>');
      }
    });
    $('#ddr_end_month').change(function() {
      if ( !$(this).val().length ) {
        $('#ddr_end_day').html('<option value="">---日</option>');
      }
    });

    // 1
    // $(function () {
    //   $('#hidden-datetime').datetimepicker({
    //     format: 'YYYY/MM/DD'
    //   });
    // });
    // 2
    // $(function () {
    //   $('#hidden-datetime1').datetimepicker({
    //     format: 'YYYY/MM/DD'
    //   });
    // });


  });
</script>


@endsection