@extends('backend.backend')

@section('content')
<!-- content enterprise search -->
    <section id="page">
      <div class="container">
      {!! Form::open( ['id' => 'frmEntSearch', 'class' => 'form-horizontal','method' => 'post', 'route' => 'backend.enterprises.search', 'enctype'=>'multipart/form-data']) !!}
        <div class="row content">
          <div class="row fl-right mar-bottom">
            <div class="col-md-12">
              <input onclick="location.href='{{route('backend.enterprises.regist')}}'" value="法人の新規登録" type="button" class="btn btn-sm btn-primary">
            </div>
          </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="ent_name">法人名</label></td>
                <td>
                  <input name="ent_name" id="ent_name" type="text" class="form-control form-control--default" value="{{@$ent_name}}">
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input value="検索開始（AND検索）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
            <input name="btnReset" id="btnReset" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary">
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </section>
    <!-- End content enterprise search -->
@endsection