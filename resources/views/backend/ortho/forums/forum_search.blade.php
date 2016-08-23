@extends('backend.ortho.ortho')
@section('content')
    <!-- Content forum search -->
      <section id="page">
        <div class="container">
        {!! Form::open(array('route' => 'ortho.forums.forum_search', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8', 'method'=>'post')) !!}
          <div class="row content-page content--patient-brother">
            <h3>伝言板　＞　メッセージの検索</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="textTitle">キーワード</label></td>
                    <td><input type="text" name="keyword" id="keyword" class="form-control form-control--sm"/></td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" value="検索開始" class="btn btn-sm btn-page">
          </div>
          </div>
          {!! Form::close() !!}
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input onclick="location.href='{{route('ortho.forums.forum_list')}}'" value="登録済み話題一覧に戻る" type="button" class="btn btn-sm btn-page">
            </div>
          </div>
        </div>
      </section>
      <!-- End content search -->
@endsection