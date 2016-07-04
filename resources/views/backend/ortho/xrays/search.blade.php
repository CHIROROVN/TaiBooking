@extends('backend.ortho.ortho')

@section('content')

<script>
  function getVal(val, select_day, old_day_value) {
    var month = '';
    var old_day = old_day_value;
    $('#' + select_day).find('option').remove();

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
      $('#' + select_day).append('<option value="0">--日</option>');
      $.each( msg, function( key, value ) {
        if ( old_day == value ) {
          $('#' + select_day).append('<option value="' + value + '" selected>' + value + '</option>');
        } else {
          $('#' + select_day).append('<option value="' + value + '">' + value + '</option>');
        }
      });
    });
  }
</script>

{!! Form::open(array('route' => 'ortho.xrays.index', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page content--patient-brother">
      <h3>放射線照射録管理　＞　患者の検索</h3>
      <table class="table table-bordered">

        <!-- p_no or p_name -->
        <tr>
          <td class="col-title"><label for="s_p_name">患者名</label></td>
          <td>
            <input name="s_p_name" id="s_p_id" type="text"  class="form-control form-control--small" value="{{ $s_p_name }}">
            <input name="s_p_id" type="hidden" id="s_p_id-id" value="{{ $s_p_id }}">
          </td>
        </tr>

        <!-- p_birthday -->
        <?php
        $year_now = date('Y');
        $year_next = $year_now + 1;
        $year_prev = $year_now - 1;
        ?>
        <tr>
          <td class="col-title"><label for="p_birthday">生年月日</label></td>
          <td>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <!-- s_p_birthday_year_from -->
                <select name="s_p_birthday_year_from" id="p_birthday" class="form-control form-control--small">
                  <option value="0">----年</option>
                  <option value="{{ $year_prev }}" @if($s_p_birthday_year_from == $year_prev) selected="" @endif>{{ $year_prev }}</option>
                  <option value="{{ $year_now }}" @if($s_p_birthday_year_from == $year_now) selected="" @endif>{{ $year_now }}</option>
                  <option value="{{ $year_next }}" @if($s_p_birthday_year_from == $year_next) selected="" @endif>{{ $year_next }}</option>
                </select>

                <!-- s_p_birthday_month_from -->
                <select name="s_p_birthday_month_from" id="s_p_birthday_month_from" class="form-control form-control--small" onchange="getVal(this, 's_p_birthday_day_from', null);">
                  <option value="0">--月</option>
                  @for ( $i = 1; $i <= 12; $i++ )
                  <option value="{{ $i }}" @if($s_p_birthday_month_from == $i) selected="" @endif>{{ $i }}</option>
                  @endfor
                </select>

                <!-- s_p_birthday_day_from -->
                <select name="s_p_birthday_day_from" id="s_p_birthday_day_from" class="form-control form-control--small">
                  <option value="0">--日</option>
                </select>
                ～
                </div>
                <div class="col-xs-12 col-md-6 margin-top-5">
                  <!-- s_p_birthday_year_to -->
                  <select name="s_p_birthday_year_to" class="form-control form-control--small">
                    <option value="0">----年</option>
                    <option value="{{ $year_prev }}" @if($s_p_birthday_year_to == $year_prev) selected="" @endif>{{ $year_prev }}</option>
                    <option value="{{ $year_now }}" @if($s_p_birthday_year_to == $year_now) selected="" @endif>{{ $year_now }}</option>
                    <option value="{{ $year_next }}" @if($s_p_birthday_year_to == $year_next) selected="" @endif>{{ $year_next }}</option>
                  </select>

                  <!-- s_p_birthday_month_to -->
                  <select name="s_p_birthday_month_to" id="s_p_birthday_month_to" class="form-control form-control--small" onchange="getVal(this, 's_p_birthday_day_to', null);">
                    <option value="0">--月</option>
                    @for ( $i = 1; $i <= 12; $i++ )
                    <option value="{{ $i }}" @if($s_p_birthday_month_to == $i) selected="" @endif>{{ $i }}</option>
                    @endfor
                  </select>

                  <!-- s_p_birthday_day_to -->
                  <select name="s_p_birthday_day_to" id="s_p_birthday_day_to" class="form-control form-control--small">
                    <option value="0">--日</option>
                  </select>
                </div>
              </div>
          </td>
        </tr>

        <!-- p_sex -->
        <tr>
          <td class="col-title">性別</td>
          <td>
            <input name="s_p_sex_men" value="1" id="s_p_sex_men" type="checkbox" @if($s_p_sex_men == 1) checked="" @endif>
            男　　　　　
            <input name="s_p_sex_women" value="2" id="s_p_sex_women" type="checkbox" @if($s_p_sex_women == 2) checked="" @endif>
            女
          </td>
        </tr>

        <!-- xray_date or 3dct_date -->
        <tr>
          <td class="col-title">撮影日</td>
          <td>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <!-- s_xray_date_year_from -->
                <select name="s_xray_date_year_from" class="form-control form-control--small">
                  <option value="0">----年</option>
                  <option value="{{ $year_prev }}" @if($s_xray_date_year_from == $year_prev) selected="" @endif>{{ $year_prev }}</option>
                  <option value="{{ $year_now }}" @if($s_xray_date_year_from == $year_now) selected="" @endif>{{ $year_now }}</option>
                  <option value="{{ $year_next }}" @if($s_xray_date_year_from == $year_next) selected="" @endif>{{ $year_next }}</option>
                </select>

                <!-- s_xray_date_month_from -->
                <select name="s_xray_date_month_from" id="s_xray_date_month_from" class="form-control form-control--small" onchange="getVal(this, 's_xray_date_day_from', null);">
                  <option value="0">--月</option>
                  @for ( $i = 1; $i <= 12; $i++ )
                  <option value="{{ $i }}" @if($s_xray_date_month_from == $i) selected="" @endif>{{ $i }}</option>
                  @endfor
                </select>

                <!-- s_xray_date_day_from -->
                <select name="s_xray_date_day_from" id="s_xray_date_day_from" class="form-control form-control--small">
                  <option value="0">--日</option>
                </select>
                ～
                </div>
                <div class="col-xs-12 col-md-6 margin-top-5">
                  <!-- s_xray_date_year_to -->
                  <select name="s_xray_date_year_to" class="form-control form-control--small">
                    <option value="0">----年</option>
                    <option value="{{ $year_prev }}" @if($s_xray_date_year_to == $year_prev) selected="" @endif>{{ $year_prev }}</option>
                    <option value="{{ $year_now }}" @if($s_xray_date_year_to == $year_now) selected="" @endif>{{ $year_now }}</option>
                    <option value="{{ $year_next }}" @if($s_xray_date_year_to == $year_next) selected="" @endif>{{ $year_next }}</option>
                  </select>

                  <!-- s_xray_date_month_to -->
                  <select name="s_xray_date_month_to" id="s_xray_date_month_to" class="form-control form-control--small" onchange="getVal(this, 's_xray_date_day_to', null);">
                    <option value="0">--月</option>
                    @for ( $i = 1; $i <= 12; $i++ )
                    <option value="{{ $i }}" @if($s_xray_date_month_to == $i) selected="" @endif>{{ $i }}</option>
                    @endfor
                  </select>

                  <!-- s_xray_date_day_to -->
                  <select name="s_xray_date_day_to" id="s_xray_date_day_to" class="form-control form-control--small">
                    <option value="0">--日</option>
                  </select>
                </div>
              </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input name="" value="検索開始" type="submit" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
</form>

<script>
  $(document).ready(function(){
      var val = $('#s_p_birthday_month_from').find("option:selected").val();
      var val1 = $('#s_p_birthday_month_to').find("option:selected").val();
      var val2 = $('#s_xray_date_month_from').find("option:selected").val();
      var val3 = $('#s_xray_date_month_to').find("option:selected").val();

      if ( val != 0) {
        getVal(val, 's_p_birthday_day_from', '{{ $s_p_birthday_day_from }}');
      }
      if ( val1 != 0) {
        getVal(val1, 's_p_birthday_day_to', '{{ $s_p_birthday_day_to }}');
      }
      if ( val2 != 0) {
        getVal(val2, 's_xray_date_day_from', '{{ $s_xray_date_day_from }}');
      }
      if ( val3 != 0) {
        getVal(val3, 's_xray_date_day_to', '{{ $s_xray_date_day_to }}');
      }


      // s_p_id
      $( "#s_p_id" ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#s_p_id').val();
            $.ajax({
                url: "{{ route('ortho.patients.brothers.autocomplete.patient') }}",
                beforeSend: function(){
                    // console.log(response);
                },
                async:    true,
                data: { key: key },
                dataType: "json",
                method: "get",
                // success: response
                success: function(data) {
                  // console.log(data);
                  response(data);
                },
            });
        },
        focus: function( event, ui ) {
          $( "#s_p_id" ).val( ui.item.label );
          return false;
        },
        select: function( event, ui ) {
          $( "#s_p_id" ).val( ui.item.label );
          $( "#s_p_id-id" ).val( ui.item.value );
          // $( "#p_relation_id-description" ).html( ui.item.desc );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
  });
</script>

@endsection