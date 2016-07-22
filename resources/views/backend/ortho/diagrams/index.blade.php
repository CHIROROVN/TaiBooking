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
    <?php //echo '<script>var bookings = ' . $bookings . '</script>'; ?>

    <script type="text/javascript"> 

      // $(document).ready(function() {
      //   var date = new Date();
      //   var d = date.getDate();
      //   var m = date.getMonth();
      //   var y = date.getFullYear();
        
      //   var calendar = $('#calendar').fullCalendar({
      //     lang: 'ja',
      //     eventLimit: false,
      //     editable: false,
      //     timezone: 'Asia/Tokyo',
      //     header: {
      //       left: 'prev today next',
      //       center: 'title',
      //       //right: 'month,agendaWeek,agendaDay'
      //       right: ''
      //     },
      //      displayEventTime: false,
           
      //     //load all event from DB
      //     events: bookings,
          
      //     // Convert the allDay from string to boolean
      //     eventRender: function(event, element, view) {
      //       if (event.allDay === 'true') {
      //         event.allDay = true;
      //       } else {
      //         event.allDay = false;
      //       }
      //     },
      //     selectable: false,
      //     selectHelper: false,
      //     select: function(start, end, allDay) {
      //         var start = moment(start).format('YYYY-MM-DD');
      //         var end = moment(end).format('YYYY-MM-DD HH:mm:ss');
            
      //       calendar.fullCalendar('unselect');
      //       // window.location.href = "{{ route('ortho.bookings.booking.daily') }}?start_date=" + start;
      //       //location.reload();
      //     },
      //   });

      //   $('.fc-next-button').click(function() {

      //   });
      // });


      $(document).ready(function() {
        var dateCur   = new Date();
        var year      = dateCur.getFullYear();
        var month     = dateCur.getMonth() + 1;
        var day       = dateCur.getDate();

        myFunction(year + '-' + month + '-' + day);

        $(document).on("click",".fc-next-button span",function(){
          var monthNext = month + 1;
          myFunction(year + '-' + monthNext + '-' + day);
        });


        function myFunction(date){
          console.log(date);
          $.ajax({
            type: "GET",
            dataType: "json",
            data: { dateCur: date },
            url: "{{ route('ortho.diagrams.get.ajax') }}",
            cache: false,
            success: function(data) {
              console.log(data);
              var calendar = $('#calendar').fullCalendar({
                lang: 'ja',
                eventLimit: false,
                editable: false,
                timezone: 'Asia/Tokyo',
                header: {
                  left: 'prev today next',
                  center: 'title',
                  //right: 'month,agendaWeek,agendaDay'
                  right: ''
                },
                 displayEventTime: false,
                 
                //load all event from DB
                events: data.diagrams,
                
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
              });
            } // end success
          }); // end ajax
        }; // end var myFunction

      });

    </script>
  <!-- End content diagram -->
@endsection