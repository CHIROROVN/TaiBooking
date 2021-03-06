@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container">
    <div class="row content content--list">
        <h1>予約簿</h1>

        @if ( Auth::user()->u_power_booking == -1 && Auth::user()->u_power2 == 1 )
        <div class="fillter">
          <div class="col-md-12 page-left">
          
            {!! Form::open(array('route' => 'ortho.bookings.booking.monthly', 'id'=>'bookingMonthly', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
            <select name="area_id" id="area_id" class="form-control form-control--small">
              <option value="">▼地域</option>
              
              @if(!empty($areas))
                @foreach($areas as $a_id => $area_name)
                  <option value="{{$a_id}}" @if($a_id == $area_id) selected="" @endif>{{$area_name}}</option>
                @endforeach
              @endif

            </select>
            <select name="clinic_id" id="clinic_id" class="form-control form-control--medium">
              <option value="">▼医院名</option>
            </select>
            <select name="u_id" id="u_id" class="form-control form-control--small">
              <option value="">▼Dr</option>
              
              <?php $selected = '' ?>
              @foreach ( $doctors as $doctor )
              <?php $selected = (Auth::user()->id == $doctor->id || $u_id == $doctor->id) ? 'selected' : ''; ?>
              <option value="{{ $doctor->id }}" {{ $selected }}>{{ $doctor->u_name }}</option>
              @endforeach

            </select>
            <input type="submit" class="btn btn-sm btn-page no-border" name="" value="絞込表示">
            </form>

          </div>
        </div>
        @endif

        <div id='calendar'></div>
    </div>
  </div>
</section>

<?php echo '<script>var clinic_id = ' . $clinic_id . '</script>'; ?>
<?php echo '<script>var bookings = ' . $bookings . '</script>'; ?>
<?php echo '<script>var u_id = ' . $u_id . '</script>'; ?>
<?php echo '<script>var u_login_id = ' . Auth::user()->id . '</script>'; ?>

@stop


@section('script')
  <script>  
    $('#area_id').click(function(event) {
      var area_id = $('#area_id').val();
      var url = "{{route('ortho.bookings.monthly.clinics')}}";
      var htmlOptions = "<option value="+">▼医院名</option>";
      $.ajax({
          type:"GET",
          url:url,
          data:{area_id:area_id},
          success: function(results){
            $.each(results, function(k, val){
              if ( val.clinic_name == 'たい矯正歯科' ) {
                htmlOptions += "<option value="+val.clinic_id+" selected>" + val.clinic_name + "</option>";
              } else {
                htmlOptions += "<option value="+val.clinic_id+">" + val.clinic_name + "</option>";
              }
            });
            $('#clinic_id').html(htmlOptions);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });

    $('#clinic_id').click(function(event) {
      var clinic_id = $('#clinic_id').val();
      var url = "{{route('ortho.bookings.monthly.users')}}";
      var htmlOptions = "<option value="+">▼Dr</option>";
      $.ajax({
          type:"GET",
          url:url,
          data:{clinic_id:clinic_id},
          success: function(results){
            $.each(results, function(k, val){
                if ( val.id == u_id || val.id == u_login_id ) {
                    htmlOptions += "<option value="+val.id+" selected>" + val.u_name_display + "</option>";
                } else {
                    htmlOptions += "<option value="+val.id+">" + val.u_name_display + "</option>";
                }

            });
            $('#u_id').html(htmlOptions);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });
    });

    $(document).ready(function() {
      $('[data-toggle="tooltip"]').tooltip();


      // order
      var area_id = getUrlParameter('area_id');
      var clinic_id = getUrlParameter('clinic_id');
      var url = "{{route('ortho.bookings.monthly.clinics')}}";
      var htmlOptions = "<option value="+">▼医院名</option>";
      $.ajax({
          type:"GET",
          url:url,
          data:{area_id:area_id},
          success: function(results){
            $.each(results, function(k, val){
            htmlOptions += "<option value="+val.clinic_id+">" + val.clinic_name + "</option>";
          });
          $('#clinic_id').html(htmlOptions);
          $("#clinic_id").find('option').each(function( i, opt ) {
                if( opt.value == clinic_id ){
                    $(opt).attr('selected', 'selected');
                }
            });
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

      var url = "{{route('ortho.bookings.monthly.users')}}";
      var htmlOptions2 = "<option value="+">▼Dr</option>";
      $.ajax({
          type:"GET",
          url:url,
          data:{clinic_id:clinic_id},
          success: function(results){
            $.each(results, function(k, val){

                if ( val.id == u_id || val.id == u_login_id ) {
                    htmlOptions2 += "<option value="+val.id+" selected>" + val.u_name_display + "</option>";
                } else {
                    htmlOptions2 += "<option value="+val.id+">" + val.u_name_display + "</option>";
                }
          });
          $('#u_id').html(htmlOptions2);
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });


      // order
      var date = new Date();
      var d = date.getDate();
      var m = date.getMonth();
      var y = date.getFullYear();
      
      var calendar = $('#calendar').fullCalendar({
        lang: 'ja',
        eventLimit: false,
        editable: false,
        timezone: 'Asia/Tokyo',
        buttonText: {
            prev: '<< 前月',
            next: '翌月 >>',
            today: '今月'
        },
        header: {
          left: 'prev today next',
          center: 'title',
          //right: 'month,agendaWeek,agendaDay'
          right: ''
        },
         displayEventTime: false,
         
        //load all event from DB
        events: bookings,
        
        // Convert the allDay from string to boolean
        eventRender: function(event, element, view) {
          if (event.allDay === 'true') {
            event.allDay = true;
          } else {
            event.allDay = false;
          }
        },
        selectable: true,
        selectHelper: true,
        select: function(start, end, allDay) {
            var start = moment(start).format('YYYY-MM-DD');
            var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
          
          calendar.fullCalendar('unselect');
          window.location.href = "{{ route('ortho.bookings.booking.daily') }}?start_date=" + start + "&clinic_id={{@$clinic_id}}";
          // location.reload();
        },
      });
    });


function getUrlParameter(sParam) {
  var sPageURL = decodeURIComponent(window.location.search.substring(1)),
      sURLVariables = sPageURL.split('&'),
      sParameterName,
      i;

  for (i = 0; i < sURLVariables.length; i++) {
      sParameterName = sURLVariables[i].split('=');

      if (sParameterName[0] === sParam) {
          return sParameterName[1] === undefined ? true : sParameterName[1];
      }
  }
}
  </script>
@stop