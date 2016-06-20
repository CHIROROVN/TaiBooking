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

    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.presents.regist') }}'" value="プレゼントの新規登録" type="button" class="btn btn-sm btn-primary"/>
      </div>
    </div>

    <table class="table table-bordered table-striped clearfix">
      <tr>
        <td class="col-title" align="center">プレゼントコード</td>
        <td class="col-title" align="center">プレゼント名</td>
        <td class="col-title" align="center">編集</td>
        <td class="col-title" align="center">削除</td>
      </tr>
      @if (empty($presents) || count($presents) == 0)
      <tr>
        <td colspan="4" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td>
      </tr>
      @else
        @foreach ($presents as $present)
        <tr>
          <td>{{ $present->present_code }}</td>
          <td>{{ $present->present_name }}</td>
          <td align="center"><input onclick="location.href='{{ route('backend.presents.edit', [$present->presentlist_id, 'page' => $presents->currentPage()]) }}'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
          <td align="center">
            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $present->presentlist_id }}">削除</button>
            <!-- popup -->
            <div class="modal fade bs-example-modal-sm" id="myModal-{{ $present->presentlist_id }}" role="dialog">
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
                    <a href="{{ route('backend.presents.delete', [$present->presentlist_id, 'page' => $presents->currentPage()]) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
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
      {!! (new App\Pagination\SimplePagination($presents))->render() !!}
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 text-center">
      <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
      <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
@endsection