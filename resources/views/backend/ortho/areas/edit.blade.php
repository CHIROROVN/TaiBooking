@extends('backend.ortho.ortho')

@section('content')
    {!! Form::open(array('route' => ['ortho.areas.edit', $area->area_id], 'method' => 'post')) !!}
      <section id="page">
        <div class="container">
          <div class="row content-page">
            <h3>共通マスタ管理　＞　地域の新規登録</h3>
              <div class="table-responsive">
                <table class="table table-bordered">
                  <tr>
                    <td class="col-title"><label for="area_name">地域名 <span class="note_required">※</span></label></td>
                    <td>
                      <input type="text" name="area_name" id="area_name" value="{{ $area->area_name }}" class="form-control"/>
                      <span class="error-input">@if ($errors->first('area_name')) ※{!! $errors->first('area_name') !!} @endif</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="col-title">所属医院</td>
                    <td>
                      <!-- <div class="checkbox">
                        <label><input type="checkbox" name="clinic[]" value="-1" @if(isset($area_clinics[-1])) {{'checked'}} @endif />たい矯正歯科</label>
                      </div> -->
                      @if(!empty($clinics) && count($clinics) > 0)
                        <?php $listClinics = $clinics; ?>
                        @foreach($listClinics as $key => $value)
                          @if ( $value->clinic_name == 'たい矯正歯科' )
                          <div class="checkbox">
                            <label><input type="checkbox" name="clinic[]" value="{{ $value->clinic_id }}" @if(isset($area_clinics[$value->clinic_id])) {{'checked'}} @endif />{{ $value->clinic_name }}</label>
                          </div>
                          <?php unset($listClinics[$key]); ?>
                          @endif
                        @endforeach
                        @foreach($listClinics as $clinic)
                        <div class="checkbox">
                          <label><input type="checkbox" name="clinic[]" value="{{ $clinic->clinic_id }}" @if(isset($area_clinics[$clinic->clinic_id])) {{'checked'}} @endif />{{ $clinic->clinic_name }}</label>
                        </div>
                        @endforeach
                      @endif
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
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.areas.delete', [$area->area_id]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end modal -->
            </div>
          </div>
          <div class="row margin-bottom">
            <div class="col-md-12 text-center">
              <a href="{{ route('ortho.areas.index') }}" class="btn btn-sm btn-page">登録済み地域一覧に戻る</a>
            </div>
          </div>
        </div>
      </section>
    {!! Form::close() !!}
@endsection