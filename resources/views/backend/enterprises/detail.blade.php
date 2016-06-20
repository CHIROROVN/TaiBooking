@extends('backend.backend')

@section('content')
	<!-- content enterprise detail -->
    <section id="page">
      <div class="container">
        <div class="row content">
          <table class="table table-bordered">
            <tr>
              <td class="col-title">法人名</td>
              <td>{{$enterprise->ent_name}}</td>
              <td class="col-title">ログインID</td>
              <td>{{$enterprise->ent_login}}</td>
              <td class="col-title">パスワード</td>
              <td>{{$enterprise->ent_passwd}}</td>
            </tr>
            <tr>
              <td class="col-title">傘下の学校</td>
              <td colspan="5">
                @if($count = count(CusName($enterprise->ent_id)))
	              @foreach(CusName($enterprise->ent_id) as $key => $cusName)
	                {{@$cusName->cus_name}}@if($count > 1 && ($key <= $count - 2)){{'、'}}@endif
	              @endforeach
	            @endif
              </td>
            </tr>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{ route('backend.enterprises.edit', $enterprise->ent_id) }}'" value="編集する" type="button" class="btn btn-sm btn-primary btn-mar-right">
            <input data-toggle="modal" data-target="#myModal-{{ $enterprise->ent_id }}" value="削除する" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>

<!--         data-toggle="modal" data-target="#myModal-{{ $enterprise->ent_id }}" -->
        <!-- popup -->
            <div class="modal fade bs-example-modal-sm" id="myModal-{{ $enterprise->ent_id }}" role="dialog">
              <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete</h4>
                  </div>
                  <div class="modal-body">
                    <p>Are you want to delete?</p>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ route('backend.enterprises.delete', $enterprise->ent_id) }}" class="btn btn-xs btn-primary">削除</a>
                    <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">Close</button>
                  </div>
                </div>
                <!-- End Modal content-->
              </div>
            </div>
            <!-- end popup -->
        <div class="row">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('backend.enterprises.index')}}'" value="一覧に戻る" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content enterprise detail -->
@endsection