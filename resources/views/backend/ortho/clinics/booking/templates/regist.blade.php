@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic booking template regist -->
  <section id="page">
    <div class="container">
      <div class="row content content--page">
        <h3>医院情報管理　＞　たい矯正歯科　＞　予約雛形の新規登録</h3>
        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="txtTemName">雛形名</label></td>
            <td>
              <input name="txtTemName" id="txtTemName" value="" type="text" class="form-control form-control--default">
              <!-- <input type="button" class="btn btn-sm btn-page no-border" name="button" value="保存する"> -->
            </td>
          </tr>
        </table>
        <div class="table-responsive">
          <table class="table table-bordered table-shift-set">
            <tr>
              <td align="center">時間</td>
              @foreach ( $facilitys as $facility )
              <td align="center">{{ $facility->facility_name }}</td>
              @endforeach
            </tr>

            <!-- check "brown", "green", "blue" color -->
            @foreach ( $times as $time )
            <?php
              $tmp_arr = explode(':', $time);
              $hour = $tmp_arr[0]; // printf( "%02d", $tmp_arr[0] );
              $minute = $tmp_arr[1]; //printf( "%02d", $tmp_arr[1] );
            ?>
            <tr>
              <td align="center">{{ $time }}～</td>
              @foreach ( $facilitys as $facility )
                
                <td align="center" class="col-brown"><img src="{{ asset('') }}public/backend/ortho/common/image/img-col-shift-set.png" /></td>
                
              @endforeach
            </tr>
            @endforeach
            
          </table>
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='clinic_list.html'" value="医院一覧に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  <!-- End content clinic booking template regist -->
@endsection