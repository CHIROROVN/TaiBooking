@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>各種リスト表示　＞　「TEL待ちリスト」の表示</h3>

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

    <div class="row">
      <div class="col-md-12" style="float: left; width: auto;">
        {!! Form::open(array('route' => 'ortho.list1_list.index', 'method' => 'get')) !!}
        <!-- p_id -->
        <input type="hidden" name="p_id" id="p_id" value="{{ $p_id }}">
        <input type="text" name="patient" id="patient" class=" form-control" style="width: 150px; display: inline; float: left;" value="{{ $patient }}">
        <!-- date -->
        <input type="calendar" name="insert_date" id="insert_date" class=" form-control datepicker" style="width: 150px; float: left; margin-left: 10px;" value="{{ $insert_date }}">
        <!-- submit -->
        <input type="submit" class="btn btn-sm btn-page" value="サーチ">
        </form>
      </div>
      <div class="col-md-12 text-right" style="float: right; width: auto;">
        <a href="{{ route('ortho.list1_list.regist') }}" class="btn btn-sm btn-page">TEL待ちリストの新規登録</a>
      </div>
    </div>
    
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr>
          <td align="center" class="col-title">医院名</td>
          <td align="center" class="col-title">登録日</td>
          <td align="center" class="col-title">当初予約日時</td>
          <td align="center" class="col-title">カルテNo</td>
          <td align="center" class="col-title">患者名</td>
          <td align="center" class="col-title">xxxx担当ドクター</td>
          <td align="center" class="col-title">xxxx業務内容-1</td>
          <td align="center" class="col-title" style="min-width: 120px">電話番号</td>
          <td align="center" class="col-title">備考</td>
          <td style="width: 200px; min-width: 200px;" align="center" class="col-title col-edit">予約の登録</td>
          <td style="width: 200px; min-width: 200px;" align="center" class="col-title col-action">TEL待ち情報の編集</td>
        </tr>

        @if(empty($list1_list) || count($list1_list) < 1)
          <tr>
            <td colspan="9">
              <h3 align="center">該当するデータがありません。</h3>
            </td>
          </tr>
        @else
          @foreach($list1_list as $item)
          <tr>
            <td>
              @foreach ( $clinics as $clinic )
                @if ( $clinic->clinic_id == $item->clinic_id )
                  {{ $clinic->clinic_name }}
                @endif
              @endforeach
            </td>
            <td>{{ $item->insert_date }}</td>
            <td>{{ $item->booking_date }}</td>
            <td>
              @if ( isset($patients[$item->patient_id]) )
                {{ $patients[$item->patient_id]->p_no }}
              @endif
            </td>
            <td>
              @if ( isset($patients[$item->patient_id]) )
                {{ $patients[$item->patient_id]->p_name_f }} {{ $patients[$item->patient_id]->p_name_g }} ({{ $patients[$item->patient_id]->p_name_f_kana }} {{ $patients[$item->patient_id]->p_name_g_kana }})
              @endif
            </td>
            <td>
              @if ( isset($list_doctors[$item->doctor_id]) )
                {{ $list_doctors[$item->doctor_id] }}
              @endif
            </td>
            <td>
              @if ( $item->service_1_kind == 1 )
                @if ( isset($services[$item->service_1]) )
                  {{ $services[$item->service_1] }}
                @endif
              @else
                @if ( isset($treatment1s[$item->service_1]) )
                  {{ $treatment1s[$item->service_1] }}
                @endif
              @endif
            </td>
            <td>
              @if ( isset($patients[$item->patient_id]) )
                {{ $patients[$item->patient_id]->p_tel }}
              @endif
            </td>
            <td>
              {{ @$item->free_text }}
            </td>
            <td align="center"><a href="{{ route('ortho.bookings.booking_search') }}" class="btn btn-sm btn-page">予約の登録</a></td>
            <td align="center"><a href="{{ route('ortho.list1_list.edit', [ $item->id ]) }}" class="btn btn-sm btn-page">TEL待ち情報の編集</a></td>
          </tr>
          @endforeach
        @endif

      </tbody>
    </table>
  </div>
</section>
@stop

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