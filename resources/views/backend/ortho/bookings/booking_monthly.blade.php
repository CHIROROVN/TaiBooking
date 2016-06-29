@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container">
    <div class="row content content--list">
        <h1>予約簿</h1>
        <div class="fillter">
          <div class="col-md-12 page-left">
            <select name="" id="" class="form-control form-control--small">
              <option value="">▼地域</option>
            </select>
            <select name="" id="" class="form-control form-control--small">
              <option value="">▼医院名</option>
            </select>
            <select name="" id="" class="form-control form-control--small">
              <option value="">▼Dr</option>
            </select>
            <input type="button" class="btn btn-sm btn-page no-border" name="button" value="絞込表示">
          </div>
        </div>
        <div id='calendar'></div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var calendar = $('#calendar').fullCalendar({
      lang: 'ja',
      eventLimit: false,
      editable: true,
      timezone: 'Asia/Tokyo',
      header: {
        left: 'prev today next',
        center: 'title',
        //right: 'month,agendaWeek,agendaDay'
        right: ''
      },

      //load all event from DB
      //events: "http://demo_fullcalendar/events.php",
      events: [
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'booking-daily.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-08',
          end: '2016-04-09',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-04',
          end: '2016-04-05',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-03',
          end: '2016-04-06',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-03',
          end: '2016-04-07',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-09',
          end: '2016-04-10',
          url: 'ddr_calendar_edit.html'
        },
        {
          title: '<img src="{{ asset('') }}public/backend/ortho/common/image/hospital.png">たい矯正歯科<img src="{{ asset('') }}public/backend/ortho/common/image/docter.png">大村Dr ',
          start: '2016-04-09',
          end: '2016-04-11',
          url: 'ddr_calendar_edit.html'
        }
      ],
      
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
          var start = moment(start).format('YYYY-MM-DD HH:mm:ss'); 
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

        //window.location.href = 'http://demo_fullcalendar/create-news?start=' + start + '&end=' + end + '&allDay=' + allDay;
        window.location.href = "{{ route('ortho.bookings.booking.result.calendar') }}";
      },

      editable: true,
    });
  });
  </script>
@endsection