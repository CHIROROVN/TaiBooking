@extends('backend.ortho.ortho')

@section('content')
<!-- Content diagram -->
 <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h3>予約管理　＞　模式図の表示</h3>
          {!! Form::open(array('route' => 'ortho.diagrams.index', 'id'=>'diagram', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
           <table class="table table-bordered">
              <tr>
                <td class="col-title">ドクター名</td>
                <td>
                  <select name="doctor_id" id="doctor" class="form-control form-control--small mar-right">
                  @if(empty($doctors))
                    <option value="">▼ドクター</option>
                  @else
                    <option value="">▼ドクター</option>
                    @foreach($doctors as $doctor)
                      <option value="{{@$doctor->id}}" @if(@$doctor->id == @$doctor_id) selected="" @endif >{{@$doctor->u_name}}</option>
                    @endforeach
                  @endif
                  </select>
                  <input id="button" value="模式図の表示" type="submit" class="btn btn-sm btn-page" style="margin-top:-5px;">
                </td>
              </tr>
            </table>
            {!! Form::close() !!}


            <div id='calendar' class="diagram-calendar"></div>

        </div>
      </div>
    </section>
    <?php echo '<script>var bookings = ' . $bookings . '</script>'; ?>

    <script type="text/javascript"> 

      $(document).ready(function() {
        var date = new Date('{{ $date }}');
        var d = date.getDate();
        var m = date.getMonth() + 1;
        var y = date.getFullYear();

        // next
        $(document).on("click",".fc-next-button span",function(){
          var nextMonth = m + 1;
          var textMonth = '';
          if ( nextMonth > 12 ) {
            y = y + 1;
            nextMonth = 1;
          }
          if ( nextMonth < 10 ) {
            textMonth = '0' + nextMonth;
          } else {
            textMonth = nextMonth;
          }
          var fullDate = y + '-' + textMonth + '-' + d;
          window.location.href = "{{ route('ortho.diagrams.index') }}?date=" + fullDate + "&doctor_id={{ $doctor_id }}";
        });

        // prev
        $(document).on("click",".fc-prev-button span",function(){
          var prevMonth = m - 1;
          var textMonth = '';
          if ( prevMonth < 1 ) {
            y = y - 1;
            prevMonth = 12;
          }
          if ( prevMonth < 10 ) {
            textMonth = '0' + prevMonth;
          } else {
            textMonth = prevMonth;
          }
          var fullDate = y + '-' + textMonth + '-' + d;
          window.location.href = "{{ route('ortho.diagrams.index') }}?date=" + fullDate + "&doctor_id={{ $doctor_id }}";
        });
        
        var calendar = $('#calendar').fullCalendar({
          lang: 'ja',
          eventLimit: false,
          editable: false,
          timezone: 'Asia/Tokyo',
          customButtons: {
            // current day
            myCustomButton: {
              text: '今月',
              click: function() {
                window.location.href = "{{ route('ortho.diagrams.index') }}";
              }
            }
          },
          header: {
            left: 'prev myCustomButton next',
            center: 'title',
            //right: 'month,agendaWeek,agendaDay'
            right: ''
          },
          displayEventTime: false,
          defaultDate: '{{ $date }}',
           
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
          selectable: false,
          selectHelper: false,
          select: function(start, end, allDay) {
              var start = moment(start).format('YYYY-MM-DD');
              var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
            
            calendar.fullCalendar('unselect');
            // window.location.href = "{{ route('ortho.bookings.booking.daily') }}?start_date=" + start;
            //location.reload();
          },
        }); //end calendar
      });

    </script>
  <!-- End content diagram -->
@endsection