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
          
    <p>全{{ $count_all }}件中、{{ $total_count }}件が該当しました。うち、{{ $record_from }}～{{ $record_to + $baitais->count() }}件を表示しています。</p>

    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.baitais.regist') }}'" value="媒体の新規登録" type="button" class="btn btn-sm btn-primary"/>
      </div>
    </div>
    
    <table class="table table-bordered table-striped clearfix">
      <tr>
        <td class="col-title" align="center">媒体コード</td>
        <td class="col-title" align="center">媒体名</td>
        <td class="col-title" align="center">新旧</td>
        <td class="col-title" align="center">発行年</td>
        <td class="col-title" align="center">編集</td>
        <td class="col-title" align="center">削除</td>
      </tr>
      @if (empty($baitais) || count($baitais) == 0)
      <tr>
        <td colspan="6" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td>
      </tr>
      @else
        @foreach ($baitais as $baitai)
        <tr>
          <td>{{ $baitai->baitai_code }}</td>
          <td>{{ $baitai->baitai_name }}</td>
          <td><?php echo ($baitai->baitai_kind == 2) ? '新' : '旧'; ?></td>
          <td>{{ $baitai-> baitai_year }}</td>
          <td align="center"><input onclick="location.href='{{ route('backend.baitais.edit', array($baitai->baitai_id, 
            's_baitai_code'       => $s_baitai_code,
            's_baitai_name'       => $s_baitai_name,
            's_baitai_kind_old'   => $s_baitai_kind_old,
            's_baitai_kind_new'   => $s_baitai_kind_new,
            's_baitai_year_begin' => $s_baitai_year_begin,
            's_baitai_year_end'   => $s_baitai_year_end,
            'page'                => $baitais->currentPage()
          )) }}'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
          <td align="center">
            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $baitai->baitai_id }}">削除</button>
            <!-- popup -->
            <div class="modal fade bs-example-modal-sm" id="myModal-{{ $baitai->baitai_id }}" role="dialog">
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
                    <a href="{{ route('backend.baitais.delete', array($baitai->baitai_id, 
                      's_baitai_code'         => $s_baitai_code,
                      's_baitai_name'         => $s_baitai_name,
                      's_baitai_kind_old'     => $s_baitai_kind_old,
                      's_baitai_kind_new'     => $s_baitai_kind_new,
                      's_baitai_year_begin'   => $s_baitai_year_begin,
                      's_baitai_year_end'     => $s_baitai_year_end,
                      'page'                  => $baitais->currentPage()
                    )) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                  </div>
                </div>
                <!-- End Modal content-->
              </div>
            </div>
            <!-- end popup -->
          </td>
        </tr>
        @endforeach
      @endif
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      {!! $baitais->appends(['s_baitai_code'        => $s_baitai_code,
                              's_baitai_name'       => $s_baitai_name,
                              's_baitai_kind_old'   => $s_baitai_kind_old,
                              's_baitai_kind_new'   => $s_baitai_kind_new,
                              's_baitai_year_begin' => $s_baitai_year_begin,
                              's_baitai_year_end'   => $s_baitai_year_end
                              ])->render(new App\Pagination\SimplePagination($baitais))  !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='{{ route('backend.baitais.search', array(
        's_baitai_code'       => $s_baitai_code,
        's_baitai_name'       => $s_baitai_name,
        's_baitai_kind_old'   => $s_baitai_kind_old,
        's_baitai_kind_new'   => $s_baitai_kind_new,
        's_baitai_year_begin' => $s_baitai_year_begin,
        's_baitai_year_end'   => $s_baitai_year_end
      )) }}'">
      <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.baitais.search') }}'">
    </div>
  </div>
</div>
@endsection