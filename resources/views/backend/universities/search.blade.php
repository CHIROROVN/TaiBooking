@extends('backend.backend')

@section('content')
{!! Form::open(array('route' => 'backend.universities.index', 'method' => 'get')) !!}
<div class="container">
  <div class="row content">
    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.universities.regist') }}'" value="高等学校の新規登録" type="button" class="btn btn-sm btn-primary">
      </div>
    </div>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title"><label for="s_univ_code">大学コード</label></td>
          <td>
            <input name="s_univ_code" id="s_univ_code" type="text" class="form-control form-control--small" value="{{ $s_univ_code }}">
          </td>
          <td class="col-title"><label for="s_univ_name">大学名</label></td>
          <td>
            <input name="s_univ_name" id="s_univ_name" type="text" class="form-control form-control--small" value="{{ $s_univ_name }}">
          </td>
          <td class="col-title"><label for="s_univ_pref_id">都道府県名</label></td>
          <td>
            <select name="s_univ_pref_id[]" multiple="multiple" id="s_univ_pref_id" class="form-control form-control--small">
              @if ( !empty($s_univ_pref_id) )
                @if ( in_array(0, $s_univ_pref_id) )
                  <option value="0" selected="">選択なし</option>
                @else
                  <option value="0">選択なし</option>
                @endif
                @foreach ( $prefs as $pref )
                <option value="{{ $pref->pref_id }}" @if(in_array($pref->pref_id, $s_univ_pref_id)) selected="" @endif>{{ $pref->pref_name }}</option>  
                @endforeach
              @else
                <option value="0">選択なし</option>
                @foreach ( $prefs as $pref )
                <option value="{{ $pref->pref_id }}">{{ $pref->pref_name }}</option>
                @endforeach
              @endif
            </select>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      <input value="検索開始（AND検索）" type="submit" class="btn btn-sm btn-primary form-control--mar-right">
      <input name="button5" id="button5" value="クリア（全消し）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.universities.search', array('where' => 'null')) }}'">
    </div>
  </div>
</div>
</form>

@endsection