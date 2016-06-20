@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => array('backend.campaigns.edit', $campaign->campaign_id), 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <!-- campaign_name -->
          <td class="col-title"><label for="campaign_name">キャンペーン名 <span class="note_required">※</span></label></td>
          <td>
            <input name="campaign_name" id="campaign_name" type="text" class="form-control form-control--small" value="{{ $campaign->campaign_name }}">
            @if ($errors->first('campaign_name'))<span class="error-input">{!! $errors->first('campaign_name') !!}</span>@endif
          </td>

          <!-- presentlist_id -->
          <td class="col-title"><label for="presentlist_id">プレゼント名 <span class="note_required">※</span></label></td>
          <td>
            <select name="presentlist_id" id="presentlist_id" class="form-control form-control--small">
              <option value="">▼選択</option>
              @foreach($presents as $present)
              <option value="{{ $present->presentlist_id }}" @if($campaign->presentlist_id == $present->presentlist_id) {{'selected'}} @endif>{{ $present->present_name }}</option>
              @endforeach
            </select>
            @if ($errors->first('presentlist_id'))<span class="error-input">{!! $errors->first('presentlist_id') !!}</span>@endif
          </td>

          <!-- baitai_id -->
          <td class="col-title"><label for="baitai_id">媒体名 <span class="note_required">※</span></label></td>
          <td>
            <select name="baitai_id" id="baitai_id" class="form-control form-control--small">
              <option value="">▼選択</option>
              @foreach($baitais as $baitai)
              <option value="{{ $baitai->baitai_id }}" @if($campaign->baitai_id == $baitai->baitai_id) {{'selected'}} @endif>{{ $baitai->baitai_name }}</option>
              @endforeach
            </select>
            @if ($errors->first('baitai_id'))<span class="error-input">{!! $errors->first('baitai_id') !!}</span>@endif
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input type="hidden" name="page" value="{{ $page }}">
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
      <!-- delete -->
      <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#myModal-{{ $campaign->campaign_id }}">削除</button>
      <!-- popup -->
      <div class="modal fade bs-example-modal-sm" id="myModal-{{ $campaign->campaign_id }}" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
            </div>
            <div class="modal-body">
              <p>{{ trans('common.modal_content_delete') }}</p>
            </div>
            <div class="modal-footer">
              <a href="{{ route('backend.campaigns.delete', [$campaign->campaign_id, 'page' => $page]) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
            </div>
          </div>
          <!-- End Modal content-->
        </div>
      </div>
      <!-- end popup -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input onclick="location.href='{{ route('backend.campaigns.index') }}'" value="前の画面に戻る" type="button" class="btn btn-sm btn-primary">
    </div>
  </div>
</div>
</form>
@endsection