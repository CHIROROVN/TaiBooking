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

    <p>全{{ $count_all }}件中、{{ $total_count }}件が該当しました。うち、{{ $record_from }}～{{ $record_to + $bunyas->count() }}件を表示しています。</p>

    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.bunyas.regist') }}'" value="分野の新規登録" type="button" class="btn btn-sm btn-primary"/>
      </div>
    </div>
    
    <table class="table table-bordered table-striped clearfix">
      <tr>
        <td class="col-title" align="center">媒体コード</td>
        <td class="col-title" align="center">分野名</td>
        <td class="col-title" align="center">種類</td>
        <td class="col-title" align="center">区分</td>
        <td class="col-title" align="center">編集</td>
        <td class="col-title" align="center">削除</td>
      </tr>
      @if (empty($bunyas) || count($bunyas) == 0)
      <tr>
        <td colspan="6" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td>
      </tr>
      @else
        @foreach ($bunyas as $bunya)
        <tr>
          <td>{{ $bunya->bunya_code }}</td>
          <td>{{ $bunya->bunya_name }}</td>
          <td><?php echo ($bunya->bunya_kind == 1) ? '職業' : '学問'; ?></td>
          <td><?php echo ($bunya->bunya_class == 1) ? 'メイン' : 'サブ'; ?></td>
          <td align="center"><input onclick="location.href='{{ route('backend.bunyas.edit', [$bunya->bunya_id, 
            's_bunya_code'       => $s_bunya_code,
            's_bunya_name'       => $s_bunya_name,
            's_bunya_kind_pro'   => $s_bunya_kind_pro,
            's_bunya_kind_stu'   => $s_bunya_kind_stu,
            's_bunya_class_main' => $s_bunya_class_main,
            's_bunya_class_sub'  => $s_bunya_class_sub,
            'page'               => $bunyas->currentPage()
          ]) }}'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
          <td align="center">
            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $bunya->bunya_id }}">削除</button>
            <!-- popup -->
            <div class="modal fade bs-example-modal-sm" id="myModal-{{ $bunya->bunya_id }}" role="dialog">
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
                    <a href="{{ route('backend.bunyas.delete', [$bunya->bunya_id, 
                      's_bunya_code'       => $s_bunya_code,
                      's_bunya_name'       => $s_bunya_name,
                      's_bunya_kind_pro'   => $s_bunya_kind_pro,
                      's_bunya_kind_stu'   => $s_bunya_kind_stu,
                      's_bunya_class_main' => $s_bunya_class_main,
                      's_bunya_class_sub'  => $s_bunya_class_sub,
                      'page'               => $bunyas->currentPage()
                    ]) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
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
      {!! $bunyas->appends(['s_bunya_code'       => $s_bunya_code,
                              's_bunya_name'       => $s_bunya_name,
                              's_bunya_kind_pro'   => $s_bunya_kind_pro,
                              's_bunya_kind_stu'   => $s_bunya_kind_stu,
                              's_bunya_class_main' => $s_bunya_class_main,
                              's_bunya_class_sub'  => $s_bunya_class_sub
                              ])->render(new App\Pagination\SimplePagination($bunyas))  !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='{{ route('backend.bunyas.search', [
        's_bunya_code'       => $s_bunya_code,
        's_bunya_name'       => $s_bunya_name,
        's_bunya_kind_pro'   => $s_bunya_kind_pro,
        's_bunya_kind_stu'   => $s_bunya_kind_stu,
        's_bunya_class_main' => $s_bunya_class_main,
        's_bunya_class_sub'  => $s_bunya_class_sub,
      ]) }}'">
      <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.bunyas.search') }}'">
    </div>
  </div>
</div>
@endsection