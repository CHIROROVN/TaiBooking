@extends('backend.backend')

@section('content')
<div class="container">

  <div class="row content content--list">
    <div class="msg-alert-action">
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
          
    <p>全{{ $count_all }}件中、{{ $total_count }}件が該当しました。うち、{{ $record_from }}～{{ $record_to + $gpamphlets->count() }}件を表示しています。</p>

    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.gpamphlets.regist') }}'" value="一括資料請求番号の新規登録" type="button" class="btn btn-sm btn-primary"/>
      </div>
    </div>
    
    <table class="table table-bordered clearfix">
      <tr>
        <td class="col-title" align="center">一括資料請求番号</td>
        <td class="col-title" align="center">資料請求番号</td>
        <td class="col-title" align="center">編集</td>
        <td class="col-title" align="center">削除</td>
      </tr>
      @if (empty($gpamphlets) || count($gpamphlets) == 0)
      <tr>
        <td colspan="4" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td>
      </tr>
      @else
        @foreach ($gpamphlets as $gpamphlet)
        <tr>
          <td>{{ $gpamphlet->gpamph_number }}</td>
          <td align="center" style="padding: 0;">
            <table class="child-tbl table-striped">
            @foreach ( $gpamphlets_distinct as $item )
              @if ( $item->gpamph_number == $gpamphlet->gpamph_number )
              <tr><td style="height: 32px;">
              {{ $item->pamph_number }} <br>
              </td></tr>
              @endif
            @endforeach
            </table>
          </td>
          <td align="center" style="padding: 0;">
            <table class="child-tbl table-striped">
            @foreach ( $gpamphlets_distinct as $item )
              @if ( $item->gpamph_number == $gpamphlet->gpamph_number )
              <tr><td>
              <input style="margin-top: 5px;" onclick="location.href='{{ route('backend.gpamphlets.edit', array($item->gpamph_id, 
                's_gpamph_number'         => $s_gpamph_number,
                's_pamph_name'            => $s_pamph_name,
                's_pamph_id'              => $s_pamph_id,
                'page'                    => $gpamphlets->currentPage()
              )) }}'" value="編集" type="button" class="btn btn-xs btn-primary"> <br>
              </td></tr>
              @endif
            @endforeach
            </table>
          </td>
          <td align="center" style="padding: 0;">
            <table class="child-tbl table-striped">
            @foreach ( $gpamphlets_distinct as $item )
              @if ( $item->gpamph_number == $gpamphlet->gpamph_number )
              <tr><td>
              <button style="margin-top: 5px;" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $item->gpamph_id }}">削除</button>
              <!-- popup -->
              <div class="modal fade bs-example-modal-sm" id="myModal-{{ $item->gpamph_id }}" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('backend.gpamphlets.delete', array($item->gpamph_id, 
                        's_gpamph_number'         => $s_gpamph_number,
                        's_pamph_name'            => $s_pamph_name,
                        's_pamph_id'              => $s_pamph_id,
                        'page'                    => $gpamphlets->currentPage()
                      )) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                  <!-- End Modal content-->
                </div>
              </div>
              <!-- end popup --> <br>
              </td></tr>
              @endif
            @endforeach
            </table>
          </td>
        </tr>
        @endforeach
      @endif
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      {!! $gpamphlets->appends(['s_gpamph_number'         => $s_gpamph_number,
                                's_pamph_name'            => $s_pamph_name,
                                's_pamph_id'              => $s_pamph_id,
                              ])->render(new App\Pagination\SimplePagination($gpamphlets))  !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='{{ route('backend.gpamphlets.search', array(
        's_gpamph_number'         => $s_gpamph_number,
        's_pamph_name'            => $s_pamph_name,
        's_pamph_id'              => $s_pamph_id,
      )) }}'">
      <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.gpamphlets.search') }}'">
    </div>
  </div>
</div>
@endsection