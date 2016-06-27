@extends('backend.ortho.ortho')

@section('content')
	<!-- Content treatment1 regist -->
    <div class="content-page">
      <h3>共通マスタ管理　＞　治療内容の新規登録</h3>
    {!! Form::open(array('route' => ['ortho.treatments.treatment1.edit', $treatment1->treatment_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
      <table class="table table-bordered">
        <tbody>
          <tr>
            <td class="col-title"><label for="treatment_name">治療内容 <span class="note_required">※</span></label></td>
            <td>
              <input class="form-control" type="text" name="treatment_name" id="treatment_name" value="@if(old('treatment_name')){{old('treatment_name')}}@else{{$treatment1->treatment_name}}@endif" />
              @if ($errors->first('treatment_name'))
                    <span class="error-input">※ {!! $errors->first('treatment_name') !!}</span>
              @endif
            </td>
          </tr>
            <td class="col-title"><label for="treatment_time">時間 <span class="note_required">※</span></label></td>
            <td>
              <select id="treatment_time" name="treatment_time">
                <option value="15" @if(old('treatment_time') == '15') selected="selected" @elseif($treatment1->treatment_time == '15') selected="selected" @endif>15分</option>
                <option value="30" @if(old('treatment_time') == '30') selected="selected" @elseif($treatment1->treatment_time == '30') selected="selected" @endif>30分</option>
                <option value="45" @if(old('treatment_time') == '45') selected="selected" @elseif($treatment1->treatment_time == '45') selected="selected" @endif>45分</option>
                <option value="60" @if(old('treatment_time') == '60') selected="selected" @elseif($treatment1->treatment_time == '60') selected="selected" @endif>60分</option>
                <option value="75" @if(old('treatment_time') == '75') selected="selected" @elseif($treatment1->treatment_time == '75') selected="selected" @endif>75分</option>
                <option value="90" @if(old('treatment_time') == '90') selected="selected" @elseif($treatment1->treatment_time == '90') selected="selected" @endif>90分</option>
                <option value="105" @if(old('treatment_time') == '105') selected="selected" @elseif($treatment1->treatment_time == '105') selected="selected" @endif>105分</option>
                <option value="120" @if(old('treatment_time') == '120') selected="selected" @elseif($treatment1->treatment_time == '120') selected="selected" @endif>120分</option>
              </select>
              @if ($errors->first('treatment_time'))
                    <span class="error-input">※ {!! $errors->first('treatment_time') !!}</span>
              @endif
            </td>
          </tr>
        </tbody>
      </table>
      <div class="row margin-bottom">
        <div class="text-center">
          <input type="submit" name="btnSave" value="登録する" class="btn btn-sm btn-page">
          <button type="button" class="btn btn-sm btn-page" data-toggle="modal" data-target="#myModal">削除する</button>
              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{trans('common.modal_header_delete')}}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{trans('common.modal_content_delete')}}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.treatments.treatment1.delete', $treatment1->treatment_id) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Modal -->
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <input type="button" name="btnBack" value="登録済み治療内容一覧に戻る" class="btn btn-sm btn-page" onclick="location.href='{{route('ortho.treatments.treatment1.index')}}'">
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  <!-- End content treatment1 regist -->
@endsection