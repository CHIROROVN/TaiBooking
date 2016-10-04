@extends('backend.ortho.ortho')

@section('content')

	<!-- Content shift search -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h1>シフト表</h1>

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
          
          {!! Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'get', 'enctype'=>'multipart/form-data', 'id' => 'frm-shift-edit')) !!}
          <div class="fillter">
            <div class="col-md-12" style="text-align:center;">

              <button type="submit" class="btn btn-sm btn-page no-border" name="prev" value="" id="prev">&lt;&lt; 前月</button>&nbsp;&nbsp;&nbsp;&nbsp;
              <span id="text-year">{{ $yearNow }}</span>年<span id="text-month">{{ $monthNow }}</span>月&nbsp;&nbsp;&nbsp;&nbsp;
              <button type="submit" class="btn btn-sm btn-page no-border" name="next" value="" id="next">翌月 &gt;&gt;</button>&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
          </div>

          <div class="shift-list-edit-belong-kind">
            <div width="100%" align="center">
              <select name="s_belong_kind" class="form-control form-control--small" id="s_belong_kind">
                <option value="1" @if($s_belong_kind == 1) selected="" @endif>医師</option>
                <option value="2" @if($s_belong_kind == 2) selected="" @endif>衛生士（相談業務あり）</option>
                <option value="3" @if($s_belong_kind == 3) selected="" @endif>衛生士（相談業務なし）</option>
                <option value="4" @if($s_belong_kind == 4) selected="" @endif>事務</option>
                <option value="5" @if($s_belong_kind == 5) selected="" @endif>受付</option>
                <option value="6" @if($s_belong_kind == 6) selected="" @endif>放射線技師</option>
                <option value="7" @if($s_belong_kind == 7) selected="" @endif>滅菌</option>
              </select>
            </div>
          </div>
          </form>

          @if ( count($users) > 0 && !empty($users) )
          {!! Form::open(array('route' => ['ortho.shifts.list_edit'], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
          <input type="hidden" name="date" value="{{ $yearNow }}-{{ $monthNow }}">
          <input type="hidden" name="s_belong_kind" value="{{ $s_belong_kind }}">

          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input value="保存する" type="submit" name="save" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input value="元に戻す" type="reset" name="back_save" class="btn btn-sm btn-page back-save">
              </div>
            </div>
            <!-- end row -->

            <?php $selected = ''; ?>
            <div class="table-date">
              <div style="margin: 0 auto; width: 1100px;">
                <!-- date -->
                <table class="table table-bordered " id="" style="float: left; width: 100px;">
                  <tr class="col-title"><td>&nbsp;</td></tr>
                  <tr class="col-title"><td>&nbsp;</td></tr>
                  @foreach ( $days as $dayKey => $dayValue )
                  <?php $fullDate = $yearNow . '-' . $monthNow . '-' . $dayKey; ?>
                  <tr>
                    <td style="padding: 11px;">{{ $dayValue }}</td>
                  <tr>
                  @endforeach
                </table>

                <!-- data -->
                <div style="float: left; width: 1000px; overflow-x: auto;">
                  <table class="table table-bordered " id="" style="">
                    <tr class="col-title">
                      @foreach ( $belongUsers as $belongUser )
                        @if ( isset($belongUser->belong_users) )
                        <?php $colspan = (isset($belongUser->belong_users)) ? count($belongUser->belong_users) : 1; ?>
                        <td colspan="{{ $colspan }}">{{ $belongUser->belong_name }}</td>
                        @endif
                      @endforeach
                    </tr>

                    <!-- list user -->
                    <tr class="col-title">
                      {!! $strUser !!}
                    </tr>

                    <!-- format value ==> -->
                    <!-- ==> u_id|shift_date|linic_id -->
                    @foreach ( $days as $dayKey => $dayValue )
                    <tr>
                      @foreach ( $users as $user )
                      <td style="">
                        <select name="select[]" class="form-control form-control--small data-user" user-id="{{ $user->id }}" full-date="{{ $fullDate }}">
                        <option value="{{ $user->id }}|{{ $fullDate }}|0">▼選択</option>
                        <?php
                        if ( isset($shifts[$user->id . '|' . $fullDate . '|' . '-1']) ) {
                          $selected = 'selected';
                        } 
                        ?>
                        <option value="{{ $user->id }}|{{ $fullDate }}|-1" {{ $selected }}>休み</option>
                        <!-- here -->
                        @foreach ( $clinics as $clinic )
                        <?php
                        if ( isset($shifts[$user->id . '|' . $fullDate . '|' . $clinic->clinic_id]) ) {
                        $selected = 'selected';
                        } else {
                        $selected = '';
                        }
                        ?>
                        <option value="{{ $user->id }}|{{ $fullDate }}|{{ $clinic->clinic_id }}" {{ $selected }}>{{ $clinic->clinic_name }}</option>
                        @endforeach
                        <!-- end here -->
                        </select>
                      </td>
                      @endforeach
                    <tr>
                    @endforeach
                  </table>
                </div>
                <!-- end data -->
              </div>
            </div>
            <!-- end table-date -->

          </div>
          <!-- end row content-page -->
          
          <div class="row content-page">
            <div class="row">
              <div class="col-md-12 text-center">
                <input name="save" value="保存する" type="submit" class="btn btn-sm btn-page">&nbsp;&nbsp;&nbsp;&nbsp;
                <input name="back_save" value="元に戻す" type="reset" class="btn btn-sm btn-page back-save">
              </div>
            </div>
          </div>
          </form>
          @endif
        </div>
      </div>
      <!-- end container -->
    </section>

@stop


@section('script')
  <script>
    $(document).ready(function(){
      var yearNow = parseInt('{{ $yearNow }}');
      var monthNow = parseInt('{{ $monthNow }}');

      // prev
      $("#prev").click(function(){
        getDate(yearNow, monthNow - 1, $(this));
      });
      
      // next
      $("#next").click(function(){
        getDate(yearNow, monthNow + 1, $(this));
      });

      function getDate(year, month, obj) {
        monthNow = parseInt(month);
        yearNow = parseInt(year);
        
        // prev year
        if ( month < 1 ) {
          yearNow = year - 1;
          monthNow = 12;
        }

        // next year
        if ( month > 12 ) {
          yearNow = year + 1;
          monthNow = 1;
        }

        var monthNowShow = String(monthNow);
        if ( monthNow < 10 ) {
          var monthNowShow = String('0') + String(monthNow);
        }
        // $('#text-year').html(yearNow);
        // $('#text-month').html(monthNowShow);
        // $('#input-year').val(yearNow);
        // $('#input-month').val(monthNowShow);
        obj.val(yearNow + '-' + monthNowShow);
      }
    });
  </script>

@stop