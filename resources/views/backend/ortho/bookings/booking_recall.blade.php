@extends('backend.ortho.ortho')

@section('content')
    <!-- content list1 list -->
  <section id="page">
    <div class="container content-page">
      <h3>各種リスト表示　＞　「リコールリスト」の表示</h3>
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
        <div class="row" style="float: left;">
          <div class="col-md-12">
            {!! Form::open(array('route' => 'ortho.bookings.booking_recall', 'method' => 'get', 'class'=>'form-inline')) !!}
            <!-- p_id -->
            <input type="hidden" name="p_id" id="p_id" value="{{ @$p_id }}">
            <input type="text" name="patient" id="patient" class=" form-control input-text-mid" value="{{ @$patient }}">
            <!-- date -->
            <select name="year" id="year" class="form-control form-control" style="text-align: center;">
                <option value='' >----</option>
                <?php echo $yoption;?>;
            </select>&nbsp;年

              <select name="month" id="month" class="form-control" style="text-align: center;">
                  <option value="" @if($oldmonth == '') selected="" @endif>--</option>
                  <option value="00" @if($oldmonth == '00') selected="" @endif>00</option>
                  <option value="01" @if($oldmonth == '01') selected="" @endif>01</option>
                  <option value="02" @if($oldmonth == '02') selected="" @endif>02</option>
                  <option value="03" @if($oldmonth == '03') selected="" @endif>03</option>
                  <option value="04" @if($oldmonth == '04') selected="" @endif>04</option>
                  <option value="05" @if($oldmonth == '05') selected="" @endif>05</option>
                  <option value="06" @if($oldmonth == '06') selected="" @endif>06</option>
                  <option value="07" @if($oldmonth == '07') selected="" @endif>07</option>
                  <option value="08" @if($oldmonth == '08') selected="" @endif>08</option>
                  <option value="09" @if($oldmonth == '09') selected="" @endif>09</option>
                  <option value="10" @if($oldmonth == '10') selected="" @endif>10</option>
                  <option value="11" @if($oldmonth == '11') selected="" @endif>11</option>
                  <option value="12" @if($oldmonth == '12') selected="" @endif>12</option>
              </select>&nbsp;月
            <!-- submit -->
            <input type="submit" class="btn btn-sm btn-page" value="検索">
            </form>
          </div>
        </div>
        <div class="row" style="float: right;">
         <div class="col-md-12 text-right" style="float: right;">
                <input name="button" value="リコールリストの新規登録" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.bookings.booking_recall_regist')}}'" type="button">
          </div>
        </div>

      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <tbody>
            <tr>
              <td class="col-title" align="center">医院名</td>
              <td class="col-title" align="center">登録日</td>
              <td class="col-title" align="center">カルテNo</td>
              <td class="col-title" align="center">患者名</td>
              <td class="col-title" align="center">電話番号</td>
              <td class="col-title" align="center">リコール月</td>
              <td class="col-title" align="center">備考</td>
              <td class="col-title" align="center" style="min-width: 90px;">予約の登録</td>
              <td class="col-title" align="center" style="min-width: 140px;">リコール情報の編集</td>
            </tr>

            @if ( !empty($recalls) && count($recalls) > 0 )
            @foreach ( $recalls as $recall )
            <tr>
              <td>{{$recall->clinic_name}}</td>
              <td>{{formatDate($recall->last_date)}}</td>
              <td>{{$recall->patient_id}}</td>
              <td>{{$recall->p_name_f}}{{$recall->p_name_g}}</td>
              <td>{{$recall->p_tel}}</td>
              <td>{{formatYm($recall->booking_recall_ym, '/')}}</td>
              <td>{{$recall->booking_memo}}</td>
              <td align="center">
                <input class="btn btn-xs btn-page" onclick="location.href='{{route('ortho.bookings.booking_search')}}'" value="予約の登録" type="button">
              </td>
              <td align="center">
                <input class="btn btn-xs btn-page" onclick="location.href='{{route('ortho.bookings.booking_recall_edit',$recall->id)}}'" value="リコール情報の編集" type="button">
              </td>
            </tr>
            @endforeach
            @else
            <tr><td colspan="9" style="text-align: center;">該当するデータがありません。</td></tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>    
  </section>
  <!-- End content list1 list -->
  @section('script')
  <script>
    $(document).ready(function(){
      $( "#patient" ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#patient').val();
            $.ajax({
                url: "{{ route('ortho.patients.autocomplete.patient') }}",
                beforeSend: function(){
                },
                method: "GET",
                data: { key: key },
                dataType: "json",
                success: function(data) {
                  response(data);
                },
            });
        },
        focus: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          return true;
        },
        select: function( event, ui ) {
          $( "#patient" ).val( ui.item.label );
          $( "#p_id" ).val( ui.item.value );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
    });

  </script>
  <script type="text/javascript">
    var date = new Date();
    var m    = date.getMonth()+1;
    $("#year").change(function() {
      if($(this).val() == ''){
        $('#month option[value=""]').prop('selected',true);
      }else{
        $('#month option[value="'+m+'"]').prop('selected',true);
      }
    });
  </script>
@stop
@endsection