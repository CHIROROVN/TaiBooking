@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3 class="margin-bottom">患者管理　＞　登録済み患者の一覧</h3>

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

    <div class="row">
      <!-- serach -->
      {!! Form::open(array('route' => 'ortho.patients.index', 'method' => 'get', 'enctype'=>'multipart/form-data')) !!}
      <div class="col-md-6">
        <input name="keyword" type="text" id="keyword_id" class="form-control form-control--default" value="{{ $keyword }}">
        <input type="hidden" name="keyword_id" id="keyword_id-id" value="{{ $keyword_id }}">
       <!--  <input name="" value="検索" type="submit" class="btn btn-sm btn-page"> -->

    <div class="btn-group btn-page">
      <button type="submit" class="btn btn-mini btn-page" style="width: 85px;">検索</button>
      <button class="btn btn-mini dropdown-toggle btn-page" data-toggle="dropdown">
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
          <li>
            <a href="{{ route('ortho.patients.search', [ 'p_no' => $p_no, 'p_name_f' => $p_name_f, 'p_name_g' => $p_name_g, 'p_name_f_kana' => $p_name_f_kana, 'p_name_g_kana' => $p_name_g_kana, 'p_tel' => $p_tel, 'p_hos' => $p_hos, 'p_hos_memo' => $p_hos_memo ]) }}">検索高度な</a>
          </li>
      </ul>
    </div>

      </div>
      </form>

      <!-- regist -->
      <div class="col-md-6 text-right">
        <input type="submit" name="button" value="患者の新規登録" class="btn btn-sm btn-page" onclick="location.href='{{ route('ortho.patients.regist') }}'">
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered table-striped treatment2-list">
        <tbody>
          <tr>
            <td class="col-title" align="center">カルテNo</td>
            <td class="col-title" align="center">患者名</td>
            <td class="col-title" align="center">患者名よみ</td>
            <td class="col-title" align="center">性別</td>
            <td class="col-title" align="center">生年月日</td>
            <td class="col-title" align="center">詳細</td>
            <td class="col-title" align="center">問診票の参照</td>
            <td class="col-title" align="center" style="min-width: 71px;">予約表示</td>
            <td class="col-title" align="center" style="min-width: 95px;">来院履歴</td>
            <td class="col-title" align="center" style="min-width: 95px;">コミュノート</td>
          </tr>

          @if ( empty($patients) || count($patients) == 0 )
          <tr>
            <td colspan="10" align="center">{{ trans('common.no_data_correspond') }}</td>
          </tr>
          @else
            @foreach ( $patients as $patient )
            <tr>
              <td align="right">{{ $patient->p_no }}</td>
              <td>{{ $patient->p_name_f }} {{ $patient->p_name_g }}</td>
              <td>{{ $patient->p_name_f_kana }} {{ $patient->p_name_g_kana }}</td>
              <td><?php echo ($patient->p_sex == 1) ? '男' : '女'; ?></td>
              <td>{{ date('Y/m/d', strtotime($patient->p_birthday)) }}</td>
              <td align="center"><input onclick="location.href='{{ route('ortho.patients.detail', [$patient->p_id]) }}'" value="詳細" type="button" class="btn btn-xs btn-page"></td>
              <td align="center">
                @if ( isset($interviews[$patient->p_id]) )
                <input onclick="location.href='{{ route('ortho.interviews.detail', [$patient->p_id]) }}'" value="問診票の参照" type="button" class="btn btn-xs btn-page">
                @else
                <input onclick="location.href='{{ route('ortho.interviews.detail', [$patient->p_id]) }}'" value="問診票の参照" type="button" class="btn btn-xs btn-page" disabled="">
                @endif
              </td>
              <td align="center"><input onclick="location.href='{{ route('ortho.patients.patient_booking_list', [ $patient->p_id ]) }}'" value="予約表示" type="button" class="btn btn-xs btn-page"/></td>
              <td align="center"><input onclick="location.href='{{ route('ortho.patients.visit.list', [ $patient->p_id ]) }}'" value="来院履歴" type="button" class="btn btn-xs btn-page"/></td>
              <td align="center"><input onclick="location.href='{{ route('ortho.patients.communications.index', [ $patient->p_id ]) }}'" value="コミュノート" type="button" class="btn btn-xs btn-page"/></td>
            </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        {!! $patients->appends([
          'keyword'       => $keyword,
          'keyword_id'    => $keyword_id,
          'p_no'          => $p_no,
          'p_name_f'      => $p_name_f,
          'p_name_g'      => $p_name_g,
          'p_name_f_kana' => $p_name_f_kana,
          'p_name_g_kana' => $p_name_g_kana,
          'p_tel'         => $p_tel,
          'p_hos'         => $p_hos,
          'p_hos_memo'    => $p_hos_memo
        ])->render(new App\Pagination\SimplePagination($patients)) !!}
      </div>
    </div>
  </div>
</section>

@stop


@section('script')
  <script>
    $(document).ready(function(){
      // p_relation_id
      $( "#keyword_id" ).autocomplete({
        minLength: 0,
        // source: pamphlets,
        source: function(request, response){
            var key = $('#keyword_id').val();
            $.ajax({
                url: "{{ route('ortho.patients.autocomplete.patient') }}",
                beforeSend: function(){
                    // console.log(response);
                },
                async:    true,
                data: { key: key },
                dataType: "json",
                method: "get",
                // success: response
                success: function(data) {
                  // console.log(data);
                  response(data);
                },
            });
        },
        focus: function( event, ui ) {
          $( "#keyword_id" ).val( ui.item.label );
          return false;
        },
        select: function( event, ui ) {
          $( "#keyword_id" ).val( ui.item.label );
          $( "#keyword_id-id" ).val( ui.item.value );
          // $( "#keyword_id-description" ).html( ui.item.desc );
          return false;
        }
      }).autocomplete( "instance" )._renderItem = function( ul, item ) {
          return $( "<li>" )
            //.append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
            .append( "<a>" + item.desc + "</a>" )
            .appendTo( ul );
      };
    });
  </script>
@stop