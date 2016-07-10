@extends('backend.ortho.ortho')

@section('content')

<section id="page">
  <div class="container">
    <div class="row content content--list">
        <h1>メモカレンダー</h1>

        <div id='calendar' class="memo-calendar"></div>
    </div>
  </div>
</section>

<?php echo '<script>var memos = ' . $memos . '</script>'; ?>
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
      events: memos,
      
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

    // set date for link text
    var tmpArr = [];
    $( ".fc-content-skeleton thead td" ).each(function( index ) {
        var start = $(this).attr('data-date');
        start = "{{ route('ortho.memos.regist') }}?memo_date=" + start;
        tmpArr[index] = start;
    });

    $( ".fc-content-skeleton tbody td" ).each(function( index ) {
      if ( $(this).attr('class') == null ) {
        $(this).append('<a style="margin-left: 5px; text-decoration: underline;" href="' + tmpArr[index] + '">未登録</a>');
      }
    });

  });
</script>

@endsection