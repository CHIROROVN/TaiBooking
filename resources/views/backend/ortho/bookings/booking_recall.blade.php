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
            <input type="calendar" name="insert_date" id="insert_date" class=" form-control input-text-mid datepicker" value="{{ @$insert_date }}">
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


      // datepicker
      $.datepicker.setDefaults( $.datepicker.regional[ "ja" ] );
      $(".datepicker").datepicker({
          showOn: 'both',
          buttonText: 'カレンダー',
          buttonImageOnly: true,
          buttonImage: "{{asset('public/backend/ortho/common/image/dummy-calendar.png')}}",
          dateFormat: 'yy-mm-dd',
          constrainInput: true,
          inline: true,
          lang: 'ja'
      });
    });
  </script>
@stop
@endsection