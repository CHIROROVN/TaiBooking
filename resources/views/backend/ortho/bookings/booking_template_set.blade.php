@extends('backend.ortho.ortho')

@section('content')
	<!-- content list1 list -->
  <section id="page">
    <div class="container">
      <div class="row content content--page">
      <h3>予約雛形の適用と個別開閉</h3>
          <div class="fillter">
            <div class="col-md-12 page-left">
              {!! Form::open(array('route' => 'ortho.bookings.template.set', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
              <select name="s_clinic_id" id="s_clinic_id" class="form-control form-control--small">
                <option value="">▼医院名</option>
                @foreach ( $clinics as $key => $clinic )
                <option value="{{ $key }}" @if($s_clinic_id == $key) selected="" @endif>{{ $clinic }}</option>
                @endforeach
              </select>
              <input type="submit" class="btn btn-sm btn-page no-border" name="" value="表示">
              </form>
            </div>
          </div>
          <div id='calendar'></div>
      </div>
    </div>
  </section>
  <!-- End content list1 list -->

  <?php echo '<script>var bookings = ' . $bookings . '</script>'; ?>
  <script>
  $(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
      lang: 'ja',
      eventLimit: false,
      editable: false,
      timezone: 'Asia/Tokyo',
      displayEventTime: false,
      header: {
        left: 'prev today next',
        center: 'title',
        //right: 'month,agendaWeek,agendaDay'
        right: ''
      },

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
        // var title = prompt('Event Title:');
        // var url = prompt('Type Event url, if exits:');
        // if (title) {
          // var start = moment(start).format('YYYY-MM-DD HH:mm:ss'); 
          var start = moment(start).format('YYYY-MM-DD');
          var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
        //  $.ajax({
        //    url: 'http://demo_fullcalendar/add_events.php',
        //    data: 'title='+ title+'&start='+ start +'&end='+ end +'&url='+ url ,
        //    type: "POST",
        //    success: function(json) {
        //      alert('Added Successfully');
        //    }
        //  });
        //  calendar.fullCalendar('renderEvent',
        //  {
        //    title: title,
        //    start: start,
        //    end: end,
        //    allDay: allDay
        //  },
        //  true
        //  );
        // }
        
        calendar.fullCalendar('unselect');

        // get clinic_id
        var clinic_id = $('#s_clinic_id').find(":selected").val();

        window.location.href = "{{ route('ortho.bookings.template.daily') }}?date=" + start + '&clinic_id=' + clinic_id;
      },
    });

    // set date for link text
    var tmpArr = [];
    var clinic_id = $('#s_clinic_id').find(":selected").val();
    $( ".fc-content-skeleton thead td" ).each(function( index ) {
        var start = $(this).attr('data-date');
        start = "{{ route('ortho.bookings.template.daily') }}?date=" + start + '&clinic_id=' + clinic_id;
        tmpArr[index] = start;
    });

    $( ".fc-content-skeleton tbody td" ).each(function( index ) {
      if ( $(this).attr('class') == null ) {
        $(this).append('<a style="margin-left: 5px; text-decoration: underline;" href="' + tmpArr[index] + '">Not yet</a>');
      }
    });

  });
  </script>

@endsection