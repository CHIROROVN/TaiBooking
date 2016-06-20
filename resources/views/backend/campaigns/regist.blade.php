@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.campaigns.regist', 'enctype'=>'multipart/form-data')) !!}
<div class="container">
  <div class="row content">
    <table class="table table-bordered">
      <tbody>
        <tr>
          <!-- campaign_name -->
          <td class="col-title"><label for="campaign_name">キャンペーン名 <span class="note_required">※</span></label></td>
          <td>
            <input name="campaign_name" id="campaign_name" type="text" class="form-control form-control--small" value="{{ old('campaign_name') }}">
            @if ($errors->first('campaign_name'))<span class="error-input">{!! $errors->first('campaign_name') !!}</span>@endif
          </td>

          <!-- presentlist_id -->
          <td class="col-title"><label for="presentlist_id">プレゼント名 <span class="note_required">※</span></label></td>
          <td>
            <select name="presentlist_id" id="presentlist_id" class="form-control form-control--small">
              <option value="">▼選択</option>
              @foreach($presents as $present)
              <option value="{{ $present->presentlist_id }}" @if(old('presentlist_id') == $present->presentlist_id) {{'selected'}} @endif>{{ $present->present_name }}</option>
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
              <option value="{{ $baitai->baitai_id }}" @if(old('baitai_id') == $baitai->baitai_id) {{'selected'}} @endif>{{ $baitai->baitai_name }}</option>
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
      <input name="button4" id="button4" value="登録する" type="submit" class="btn btn-sm btn-primary">
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