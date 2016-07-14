<?php $__env->startSection('content'); ?>
<section id="page">
  <div class="container">
    <div class="row content content--list">
        <h1>予約簿</h1>
        <div class="fillter">
          <div class="col-md-12 page-left">
          
          <?php echo Form::open(array('route' => 'ortho.bookings.booking.monthly', 'id'=>'bookingMonthly', 'method' => 'get', 'enctype'=>'multipart/form-data')); ?>

            <select name="area_id" id="area_id" class="form-control form-control--small">
              <option value="">▼地域</option>
              <?php if(!empty($areas)): ?>
                <?php foreach($areas as $a_id => $area_name): ?>
                  <option value="<?php echo e($a_id); ?>" <?php if($a_id == $area_id): ?> selected="" <?php endif; ?>><?php echo e($area_name); ?></option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
            <select name="clinic_id" id="clinic_id" class="form-control form-control--small">
              <option value="">▼医院名</option>
            </select>
            <select name="u_id" id="u_id" class="form-control form-control--small">
              <option value="">▼Dr</option>
              <?php foreach( $users as $user ): ?>
              <option value="<?php echo e($user->id); ?>" <?php if($u_id == $user->id): ?> selected="" <?php endif; ?>><?php echo e($user->u_name); ?></option>
              <?php endforeach; ?>
            </select>
            <input type="submit" class="btn btn-sm btn-page no-border" name="" value="絞込表示">
          </form>

          </div>
        </div>
        <div id='calendar'></div>
    </div>
  </div>
</section>

<?php echo '<script>var clinic_id = ' . $clinic_id . '</script>'; ?>
<script>  
    $('#area_id').click(function(event) {
      var area_id = $('#area_id').val();
      var url = "<?php echo e(route('ortho.bookings.monthly.clinics')); ?>";
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
          },
          error: function (data) {
              console.log('Error:', data);
          }
      });

    });

  $(document).ready(function() {
     var area_id = $.urlParam('area_id');
     var clinic_id = $.urlParam('clinic_id');
       var url = "<?php echo e(route('ortho.bookings.monthly.clinics')); ?>";
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
  });

  $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
  }

</script>

<?php echo '<script>var bookings = ' . $bookings . '</script>'; ?>
<script>
  $(document).ready(function() {
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

// var clinic_id = $.urlParam('clinic_id');

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
        window.location.href = "<?php echo e(route('ortho.bookings.booking.daily')); ?>?start_date=" + start;

      },

      editable: true,
    });
  });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.ortho.ortho', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>