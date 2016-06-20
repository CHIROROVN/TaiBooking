@extends('backend.backend')

@section('content')
<!-- content customer list -->
    <section id="page">
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
          <p>全{{$count_all}}件中、{{$total_count}}件が該当しました。うち、{{$record_from}}～{{$record_to + count($customers)}}件を表示しています。</p>
          <div class="row fl-right mar-bottom">
            <div class="col-md-12">
              <input onclick="location.href='{{route('backend.customers.regist')}}'" value="顧客の新規登録" type="button" class="btn btn-sm btn-primary"/>
            </div>
          </div>
          <table class="table table-bordered table-striped clearfix">
            <tr>
              <td class="col-title" align="center">学校コード</td>
              <td class="col-title" align="center">学校名</td>
              <td class="col-title" align="center">旧学校名</td>
              <td class="col-title" align="center">詳細</td>
              <td class="col-title" align="center">編集</td>
              <td class="col-title" align="center">削除</td>
            </tr>

            @if(count($customers) > 0)
            @foreach($customers as $customer)
              <tr>
                <td align="right">{{$customer->cus_code}}</td>
                <td>{{$customer->cus_name}}</td>
                <td>{{$customer->cus_old_name}}</td>
                
                <td align="center"><input onclick="location.href='{{route('backend.students.contact.index', ['stu_d'=>'1'])}}'" value="詳細" type="button" class="btn btn-xs btn-primary"></td>
                <td align="center"><input onclick="location.href='{{route('backend.customers.detail', $customer->cus_id)}}'" value="詳細" type="button" class="btn btn-xs btn-primary"></td>
                <td align="center">
                  <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $customer->cus_id }}">削除</button>
                  <!-- popup -->
                  <div class="modal fade bs-example-modal-sm" id="myModal-{{ $customer->cus_id }}" role="dialog">
                    <div class="modal-dialog modal-sm">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                        </div>
                        <div class="modal-body">
                          <p>{{trans('common.modal_content_delete')}}</p>
                        </div>
                        <div class="modal-footer">
                          <a href="{{ route('backend.customers.delete', array($customer->cus_id, 'page' => $customers->currentPage())) }}" class="btn btn-xs btn-primary">{{trans('common.modal_btn_delete')}}</a>
                          <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                        </div>
                      </div>
                      <!-- End Modal content-->
                  </div>
                </div>
                </td>
              </tr>
            @endforeach

            @else
              <tr><td colspan="6" style="text-align: center;">該当するデータがありません。</td></tr>
            @endif
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            {!! (new App\Pagination\SimplePagination($customers))->render() !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input name="searchWhere" id="searchWhere" value="再検索（条件を引き継ぐ）" type="button" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='{{ route('backend.customers.search', ['cus_code='.@$cus_code, 'cus_name='.@$cus_name, 'cus_old_name='.@$cus_old_name]) }}'">
            <input name="searchNoWhere" id="searchNoWhere" value="再検索（条件をクリアする）" type="button" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.customers.search') }}'">
          </div>
        </div>
      </div>
    </section>
    <!-- End content customer list -->
@endsection