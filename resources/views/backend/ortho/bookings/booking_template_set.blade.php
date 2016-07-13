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
                <option value="{{ $key }}">{{ $clinic }}</option>
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

  <?php //echo '<script>var memos = ' . $memos . '</script>'; ?>
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
      events: '',
      
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

        window.location.href = "{{ route('ortho.memos.regist') }}?memo_date=" + start;
      },
    });

  });
  </script>

@endsection