@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic facility edit -->
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>医院情報管理　＞　たい矯正歯科　＞　登録済み設備の編集</h3>
              <div class="table-responsive">
              {!! Form::open( ['id' => 'frmFacilityEdit', 'class' => 'form-horizontal','method' => 'post', 'route' => ['ortho.facilities.edit', $clinic_id, $facility->facility_id], 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="facility_name">設備名 <span class="note_required">※</span></label></td>
                    <td>
                    	<input type="text" name="facility_name" id="facility_name" class="form-control" value="@if(old('facility_name')){{old('facility_name')}}@else{{$facility->facility_name}}@endif" />
                    	@if ($errors->first('facility_name'))
		                    <span class="error-input">※ {!! $errors->first('facility_name') !!}</span>
		            	@endif
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title">用途 <span class="note_required">※</span></td>
                    <td>
                      <div class="radio">
                        <label><input type="radio" name="facility_kind" id="treatment" value="1" @if(old('facility_kind') == '1') checked="checked" @elseif($facility->facility_kind == '1') checked="checked" @endif />治療</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="facility_kind" id="out_treatment" value="2" @if(old('facility_kind') == '2') checked="checked" @elseif($facility->facility_kind == '2') checked="checked" @endif />治療以外</label>
                      </div>
                    	@if ($errors->first('facility_kind'))
		                    <span class="error-input">※ {!! $errors->first('facility_kind') !!}</span>
		            	@endif
                    </td>
                  </tr>
                </table>
              </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="submit" name="button" value="保存する" class="btn btn-sm btn-page mar-right">
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
                      <a href="{{ route('ortho.facilities.delete', [$clinic_id, $facility->facility_id]) }}" class="btn btn-sm btn-page">{{trans('common.modal_btn_delete')}}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{trans('common.modal_btn_cancel')}}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /Modal -->
          </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="button" onClick="location.href='{{route('ortho.facilities.index',[$clinic_id])}}'" value="登録済み設備一覧に戻る" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </section>
      <!-- End content clinic facility edit -->
@endsection