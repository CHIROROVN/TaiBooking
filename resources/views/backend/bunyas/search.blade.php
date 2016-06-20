@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.bunyas.index', 'method' => 'get')) !!}
<div class="container">
        <div class="row content">
          <div class="row fl-right mar-bottom">
            <div class="col-md-12">
              <input onclick="location.href='{{ route('backend.bunyas.regist') }}'" value="分野の新規登録" type="button" class="btn btn-sm btn-primary">
            </div>
          </div>
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="s_bunya_code">分野コード</label></td>
                <td>
                  <input name="s_bunya_code" id="s_bunya_code" type="text" class="form-control form-control--small" value="{{ $s_bunya_code }}">
                </td>
                <td class="col-title"><label for="s_bunya_name">分野名</label></td>
                <td><input name="s_bunya_name" id="s_bunya_name" type="text" class="form-control form-control--small" value="{{ $s_bunya_name }}"></td>
                <td class="col-title"><label for="s_bunya_kind_pro">分野種別</label></td>
                <td>
                  <input name="s_bunya_kind_pro" id="s_bunya_kind_pro" value="1" type="checkbox" @if($s_bunya_kind_pro == 1) {{'checked'}} @endif> 職業　　　
                  <input name="s_bunya_kind_stu" id="s_bunya_kind_stu" value="2" type="checkbox" @if($s_bunya_kind_stu == 2) {{'checked'}} @endif> 学問
                </td>
              </tr>
              <tr>
                <td class="col-title"><label for="s_bunya_class_main">分野区分</label></td>
                <td colspan="5">
                  <input name="s_bunya_class_main" id="s_bunya_class_main" value="1" type="checkbox" @if($s_bunya_class_main == 1) {{'checked'}} @endif> メイン　　　
                  <input name="s_bunya_class_sub" id="s_bunya_class_sub" value="2" type="checkbox" @if($s_bunya_class_sub == 2) {{'checked'}} @endif> サブ
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row mar-bottom30">
          <div class="col-md-12 text-center">
            <input value="検索開始（AND検索）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
            <input name="button5" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.bunyas.search', array('where' => 'null')) }}'">
          </div>
        </div>
      </div>
</form>
@endsection