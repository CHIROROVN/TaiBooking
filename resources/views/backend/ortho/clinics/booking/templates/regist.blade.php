@extends('backend.ortho.ortho')

@section('content')
	<!-- Content clinic booking template regist -->
{!! Form::open(array('route' => ['ortho.clinics.booking.templates.regist', $clinic->clinic_id], 'method' => 'post', 'enctype'=>'multipart/form-data')) !!}
  <section id="page">
    <div class="container">
      <div class="row content content--page">
        <h3>医院情報管理　＞　{{ $clinic->clinic_name }}　＞　予約雛形の新規登録</h3>
        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="mbt_name">雛形名 <span class="note_required">※</span></label></td>
            <td>
              <input name="mbt_name" id="mbt_name" value="{{ old('mbt_name') }}" type="text" class="form-control form-control--default">
              <span class="error-input">@if ($errors->first('mbt_name')) ※{!! $errors->first('mbt_name') !!} @endif</span>
              <!-- <input type="button" class="btn btn-sm btn-page no-border" name="button" value="保存する"> -->
            </td>
          </tr>
        </table>
        
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="location.href='{{ route('ortho.clinics.index') }}'" value="医院一覧に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
</form>
  <!-- End content clinic booking template regist -->
@endsection