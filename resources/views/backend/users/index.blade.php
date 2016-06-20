@extends('backend.backend')

@section('content')
  <!-- content users list -->
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

          <div class="row fl-right mar-bottom">
            <div class="col-md-12">
              <input onclick="location.href='{{URL::route('backend.users.regist')}}'" value="ユーザーの新規登録" type="button" class="btn btn-sm btn-primary"/>
            </div>
          </div>
          <table class="table table-bordered table-striped clearfix">
            <tr>
              <td class="col-title" align="center">名前</td>
              <td class="col-title" align="center">所属</td>
              <td class="col-title" align="center">ユーザーID</td>
              <td class="col-title" align="center">権限</td>
              <td class="col-title" align="center">編集</td>
              <td class="col-title" align="center">削除</td>
            </tr>
            <?php $powers = array('000' => 'Ｓ管理者', '010' => '管理', '020' => '営業', '030' => '印刷', '040' => '中国'); ?>
            @if(count($users) > 0 && !empty($users))
              @foreach($users as $user)
                <tr>
                  <td>{{$user->u_name}}</td>
                  <td>{{ $user->u_belong }}</td>
                  <td>{{$user->u_login}}</td>
                  <td>
                    <?php
                    $u_power = json_decode($user->u_power, true);
                    foreach ($u_power as $item) {
                      if ( isset($powers[$item]) ) {
                        echo $powers[$item] . '<br>';
                      }
                    }
                    ?>
                  </td>
                  <td align="center"><input onclick="location.href='{{URL::route('backend.users.update', [$user->u_id, 'page' => $users->currentPage()])}}'" value="編集" type="button" class="btn btn-xs btn-primary"></td>
                  <td align="center">
                    <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-{{ $user->u_id }}">削除</button>
                    <!-- popup -->
                    <div class="modal fade bs-example-modal-sm" id="myModal-{{ $user->u_id }}" role="dialog">
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
                            <a href="{{ route('backend.users.delete', array($user->u_id, 'page' => $users->currentPage())) }}" class="btn btn-xs btn-primary">削除</a>
                            <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        <!-- End Modal content-->
                      </div>
                    </div>
                    <!-- end popup -->
                  </td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="6" style="text-align: center;">該当データなし。</td></tr>
            @endif
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            {!! (new App\Pagination\SimplePagination($users))->render() !!}
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">
            <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
            <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
  <!-- End content users list -->
@endsection