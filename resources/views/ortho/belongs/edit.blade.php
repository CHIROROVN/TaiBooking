@extends('ortho.ortho')

@section('content')
    {!! Form::open(array('url' => 'ortho/belongs/edit/' . $belong->belong_id, 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>ユーザー管理　＞　所属の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="belong_name">所属名 (*)</label></td>
                    <td>
                      <input type="text" name="belong_name" id="belong_name " class="form-control" value="{{ $belong->belong_name }}" />
                      <span class="error-input">@if ($errors->first('belong_name')) {!! $errors->first('belong_name') !!} @endif</span>
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page">
              <!-- Trigger the modal with a button -->
              <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete confirm</h4>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure to delete?</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ asset('ortho/belongs/delete/' . $belong->belong_id) }}" class="btn btn-sm btn-page">Yes</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">No</button>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ asset('ortho/belongs') }}" class="btn btn-sm btn-page">登録済み所属一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@endsection