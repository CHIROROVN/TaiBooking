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
{!! Form::open(array('route' => ['ortho.ddrs.edit', $ddr->ddr_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content content--calendar">
        <h3>院長カレンダー　＞　登録済み予定の編集</h3>

        <div class="table-responsive">
          <table class="table table-bordered">
            <tr>
              <td class="col-title">開始日時 <span class="note-required">(※)</span></td>
              <td>

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
                <input type="hidden" id="datepicker">
                
                <!-- ddr_start_time -->
                <select name="ddr_start_hh" class="form-control form-control--small">
                  <option value="">---時</option>
                  @foreach ( $hours as $hour)
                    @if ( old('ddr_start_hh') )
                    <option value="{{ $hour }}" @if(old('ddr_start_hh') == $hour) selected="" @endif>{{ $hour }}時</option>
                    @else
                    <option value="{{ $hour }}" @if(@$ddr_start_time_hh == $hour) selected="" @endif>{{ $hour }}時</option>
                    @endif
                  @endforeach
                </select>
                <select name="ddr_start_mm" class="form-control form-control--small">
                  <option value="">---分</option>
                  @if ( old('ddr_start_mm') )
                  <option value="00" @if(old('ddr_start_mm') == '00') selected="" @endif>00分</option>
                  <option value="15" @if(old('ddr_start_mm') == '15') selected="" @endif>15分</option>
                  <option value="30" @if(old('ddr_start_mm') == '30') selected="" @endif>30分</option>
                  <option value="45" @if(old('ddr_start_mm') == '45') selected="" @endif>45分</option>
                  @else
                  <option value="00" @if(@$ddr_start_time_mm == '00') selected="" @endif>00分</option>
                  <option value="15" @if(@$ddr_start_time_mm == '15') selected="" @endif>15分</option>
                  <option value="30" @if(@$ddr_start_time_mm == '30') selected="" @endif>30分</option>
                  <option value="45" @if(@$ddr_start_time_mm == '45') selected="" @endif>45分</option>
                  @endif
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
                    @if ( old('ddr_end_year') )
                    <option value="{{ $year }}" @if(old('ddr_end_year') == $year) selected="" @endif>{{ $year }}</option>
                    @else
                    <option value="{{ $year }}" @if(@$ddr_end_date_y == $year) selected="" @endif>{{ $year }}</option>
                    @endif
                  @endforeach
                </select>
                <select name="ddr_end_month" id="ddr_end_month" class="form-control form-control--small" onchange="getDays('ddr_end_day', $(this).val(), '')">
                  <option value="">---月</option>
                </select>
                <select name="ddr_end_day" id="ddr_end_day" class="form-control form-control--small">
                  <option value="">---日</option>
                </select>
                <input type="hidden" id="datepicker1">

                <!-- ddr_end_time -->
                <select name="ddr_end_hh" class="form-control form-control--small">
                  <option value="">--時</option>
                  @foreach ( $hours as $hour)
                    @if ( old('ddr_end_hh') )
                    <option value="{{ $hour }}" @if(old('ddr_end_hh') == $hour) selected="" @endif>{{ $hour }}時</option>
                    @else
                    <option value="{{ $hour }}" @if(@$ddr_end_time_hh == $hour) selected="" @endif>{{ $hour }}時</option>
                    @endif
                  @endforeach
                </select>
                <select name="ddr_end_mm" class="form-control form-control--small">
                  <option value="">--分</option>
                  @if ( old('ddr_end_mm') )
                  <option value="00" @if(old('ddr_end_mm') == '00') selected="" @endif>00分</option>
                  <option value="15" @if(old('ddr_end_mm') == '15') selected="" @endif>15分</option>
                  <option value="30" @if(old('ddr_end_mm') == '30') selected="" @endif>30分</option>
                  <option value="45" @if(old('ddr_end_mm') == '45') selected="" @endif>45分</option>
                  @else
                  <option value="00" @if(@$ddr_end_time_mm == '00') selected="" @endif>00分</option>
                  <option value="15" @if(@$ddr_end_time_mm == '15') selected="" @endif>15分</option>
                  <option value="30" @if(@$ddr_end_time_mm == '30') selected="" @endif>30分</option>
                  <option value="45" @if(@$ddr_end_time_mm == '45') selected="" @endif>45分</option>
                  @endif
                </select>
                まで
              </td>
            </tr>
            <tr>
              <td class="col-title">内容</td>
              <td>
                <!-- ddr_kind -->
                <select name="ddr_kind" class="form-control form-control--small">
                  @if ( old('ddr_kind') )
                  <option style="color: #000" value="1" @if(old('ddr_kind') == 1) selected="" @endif>■</option>
                  <option style="color: #F00" value="2" @if(old('ddr_kind') == 2) selected="" @endif>■</option>
                  <option style="color: #00F" value="3" @if(old('ddr_kind') == 3) selected="" @endif>■</option>
                  <option style="color: #390" value="4" @if(old('ddr_kind') == 4) selected="" @endif>■</option>
                  <option style="color: #F90" value="5" @if(old('ddr_kind') == 5) selected="" @endif>■</option>
                  @else
                  <option style="color: #000" value="1" @if($ddr->ddr_kind == 1) selected="" @endif>■</option>
                  <option style="color: #F00" value="2" @if($ddr->ddr_kind == 2) selected="" @endif>■</option>
                  <option style="color: #00F" value="3" @if($ddr->ddr_kind == 3) selected="" @endif>■</option>
                  <option style="color: #390" value="4" @if($ddr->ddr_kind == 4) selected="" @endif>■</option>
                  <option style="color: #F90" value="5" @if($ddr->ddr_kind == 5) selected="" @endif>■</option>
                  @endif
                </select>          
                @if ( old('ddr_contents') )
                <input name="ddr_contents" type="text" value="{{ old('ddr_contents') }}" class="form-control form-control--medium"/>
                @else
                <input name="ddr_contents" type="text" value="{{ @$ddr->ddr_contents }}" class="form-control form-control--medium"/>
                @endif
              </td>
            </tr>
          </table>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 text-center">
          <!-- save -->
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page mar-right">
          <!-- delete -->
          <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
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
                  <a href="{{ route('ortho.ddrs.delete', [$ddr->ddr_id]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end modal -->
        </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}


<script type="text/javascript">
  $(document).ready(function(){
    var editYearStar = "{{ $ddr_start_date_y }}";
    var editMonthStar = "{{ $ddr_start_date_m }}";
    var editDayStar = "{{ $ddr_start_date_d }}";
    var editYearEnd = "{{ $ddr_end_date_y }}";
    var editMonthEnd = "{{ $ddr_end_date_m }}";
    var editDayEnd = "{{ $ddr_end_date_d }}";

    getMonths('ddr_start_month', editYearStar, editMonthStar);
    getDays('ddr_start_day', editMonthStar, editDayStar);

    getMonths('ddr_end_month', editYearEnd, editMonthEnd);
    getDays('ddr_end_day', editMonthEnd, editDayEnd);

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


    // datepicker
    $(function() {
      $( "#datepicker" ).datepicker({
        showOn: "button",
        buttonImage: "{{ asset('') }}public/backend/ortho/common/image/dummy-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: 'yyyy-mm-dd',
        inline: true,
        onSelect: function(dateText, inst) { 
          var date = $(this).datepicker('getDate'),
          day  = date.getDate(),
          month = date.getMonth() + 1,
          year =  date.getFullYear();
          console.log(year);
          console.log(month);
          console.log(day);

          $( "#ddr_start_year option" ).each(function( index ) {
            if($(this).val() == year) {
                $(this).prop("selected", true);
            }
          });

          getMonths('ddr_start_month', year.toString(), month.toString());
          getDays('ddr_start_day', month.toString(), day.toString());
        }
      });
    });

    // datepicker 1
    $(function() {
      $( "#datepicker1" ).datepicker({
        showOn: "button",
        buttonImage: "{{ asset('') }}public/backend/ortho/common/image/dummy-calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date",
        dateFormat: 'yyyy-mm-dd',
        inline: true,
        onSelect: function(dateText, inst) { 
          var date = $(this).datepicker('getDate'),
          day  = date.getDate(),
          month = date.getMonth() + 1,
          year =  date.getFullYear();

          $( "#ddr_end_year option" ).each(function( index ) {
            if($(this).val() == year) {
                $(this).prop("selected", true);
            }
          });

          getMonths('ddr_end_month', year.toString(), month.toString());
          getDays('ddr_end_day', month.toString(), day.toString());
        }
      });
    });

  });
</script>


@endsection