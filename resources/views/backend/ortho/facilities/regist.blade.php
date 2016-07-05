@extends('backend.ortho.ortho')

@section('content')
	 <!-- Content clinic facility regist -->
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>医院情報管理　＞　{{ $clinic->clinic_name }}　＞　設備の新規登録</h3>
          {!! Form::open(array('route' => ['ortho.facilities.regist', $clinic->clinic_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="facility_name">設備名 <span class="note_required">※</span></label></td>
                    <td><input type="text" name="facility_name" id="facility_name" class="form-control"/>
                    	@if ($errors->first('facility_name'))
		                    <span class="error-input">※ {!! $errors->first('facility_name') !!}</span>
		            	@endif
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title">用途 <span class="note_required">※</span></td>
                    <td>
                      <div class="radio">
                        <label><input type="radio" name="facility_kind" id="treatment" value="1" @if(old('facility_kind') == '1') checked="checked" @endif />治療</label>
                      </div>
                      <div class="radio">
                        <label><input type="radio" name="facility_kind" id="out_treatment" value="2" @if(old('facility_kind') == '2') checked="checked" @endif />治療以外</label>
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
              <input type="submit" name="button" id="button" value="登録する" class="btn btn-sm btn-page">
          </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <input type="button" onClick="location.href='{{route('ortho.facilities.index',[$clinic->clinic_id])}}'" value="登録済み設備一覧に戻る" class="btn btn-sm btn-page mar-right">
            </div>
          </div>
          {!! Form::close() !!}
        </div>
      </section>
      <!-- End content clinic facility regist -->
@endsection