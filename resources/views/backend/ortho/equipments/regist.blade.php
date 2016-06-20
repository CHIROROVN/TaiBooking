@extends('backend.ortho.ortho')

@section('content')
 <!-- Content equipment regist -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　装置の新規登録</h3>
    {!! Form::open( ['id' => 'frmEquipmentRegist', 'class' => 'form-horizontal','method' => 'post', 'route' => 'ortho.equipments.regist', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
		<div class="msg-alert-action">
              @if ($message = Session::get('success'))
              <div class="alert alert-success  alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> {{ $message }}</li></strong></ul>
              </div>
            @elseif($message = Session::get('danger'))
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <ul><strong><li> {{ $message }}</li></strong></ul>
              </div>
            @endif
		</div>

	<table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="equipment_name">装置名 <span class="note_required">※</span></label></td>
            <td>
              <input class="form-control" type="text" name="equipment_name" id="equipment_name" value="{{old('equipment_name')}}" />
              @if ($errors->first('equipment_name'))
                    <span class="error-input">※ {!! $errors->first('equipment_name') !!}</span>
              @endif

            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="button" value="登録する" class="btn btn-sm btn-page">
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="button" name="button" value="登録済み業務名一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.equipments.index')}}'">
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  <!--End content equipment regist -->
@endsection
