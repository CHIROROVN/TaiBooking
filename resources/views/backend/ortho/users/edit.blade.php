@extends('backend.ortho.ortho')

@section('content')
  {!! Form::open(array('url' => 'ortho/users/edit/' . $user->id, 'method' => 'post')) !!}
    <div class="content-page">
      <h3>ユーザー管理　＞　ユーザーの新規登録</h3>
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title">氏名 <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name" id="u_name" value="{{ $user->u_name }}" />
              <span class="error-input">@if ($errors->first('u_name')) ※{!! $errors->first('u_name') !!} @endif</span>
            </td>
          </tr>
          <tr>
            <td class="col-title">氏名よみ <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name_yomi" id="u_name_yomi" value="{{ $user->u_name_yomi }}" />
              <span class="error-input">@if ($errors->first('u_name_yomi')) ※{!! $errors->first('u_name_yomi') !!} @endif</span>
            </td>
          </tr>
          <tr>
            <td class="col-title">（表示用）氏名 <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_name_display" id="u_name_display" value="{{ $user->u_name_display }}" />
              <span class="error-input">@if($errors->first('u_name_display')) ※{!! $errors->first('u_name_display') !!} @endif</span>
            </td>
          </tr>
          <tr>
            <td class="col-title">ログインID <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="text" name="u_login" id="u_login" value="{{ $user->u_login }}" />
              <span class="error-input">@if ($errors->first('u_login')) ※{!! $errors->first('u_login') !!} @endif</span>
            </td>
          </tr>
          <tr>
            <td class="col-title">パスワード <span class="note_required">※</span></td>
            <td>
              <input class="form-control" type="password" name="password" id="password" value="" />
              <span class="error-input">@if ($errors->first('password')) ※{!! $errors->first('password') !!} @endif</span>
            </td>
          </tr>
          <tr>
            <td class="col-title">所属</td>
            <td>
              <?php $i = 0; ?>
              @if(!empty($belongs) && count($belongs) > 0)
                @foreach($belongs as $belong)
                  <?php $i++; ?>
                  <div class="radio">
                    <label><input type="radio" @if($user->u_belong == $belong->belong_id) {{'checked'}} @endif name="u_belong" value="{{ $belong->belong_id }}">{{ $belong->belong_name }}</label>
                  </div>
                @endforeach
              @endif
            </td>
          </tr>
          <tr>
            <td class="col-title">権限</td>
            <td>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power1" @if($user->u_power1 == 1) {{'checked'}} @endif value="1">患者管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power2" @if($user->u_power2 == 1) {{'checked'}} @endif value="1">予約管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power3" @if($user->u_power3 == 1) {{'checked'}} @endif value="1">院長予定管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power4" @if($user->u_power4 == 1) {{'checked'}} @endif value="1">放射線録管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power5" @if($user->u_power5 == 1) {{'checked'}} @endif value="1">月1回の予約業務前処理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power6" @if($user->u_power6 == 1) {{'checked'}} @endif value="1">医院情報管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power7" @if($user->u_power7 == 1) {{'checked'}} @endif value="1">放射線照射録管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power8" @if($user->u_power8 == 1) {{'checked'}} @endif value="1">共通マスタ管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power9" @if($user->u_power9 == 1) {{'checked'}} @endif value="1">ユーザー管理</label>
              </div>
              <div class="checkbox">
                <label><input type="checkbox" name="u_power10" @if($user->u_power10 == 1) {{'checked'}} @endif value="1">初診業務</label>
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title">検索対象</td>
            <td>
              <div class="checkbox">
                <label><input type="checkbox" name="u_human_flg" @if($user->u_human_flg == 1) {{'checked'}} @endif value="1">含めない（人ではないユーザーである）</label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="save" value="登録する" class="btn btn-sm btn-page">
          <!-- Trigger the modal with a button -->
          <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
          <!-- Modal -->
          <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                </div>
                <div class="modal-body">
                  <p>{{ trans('common.modal_content_delete') }}</p>
                </div>
                <div class="modal-footer">
                  <a href="{{ asset('ortho/users/delete/' . $user->id) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                  <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="row margin-bottom">
        <div class="text-center">
          <a href="{{ asset('ortho/users') }}" class="btn btn-sm btn-page">登録済みユーザー一覧に戻る</a>
        </div>
      </div>
    </div>
  {!! Form::close() !!}
@endsection