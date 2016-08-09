@extends('backend.ortho.ortho')
@section('content')
{!! Form::open( ['id' => 'frmBookingSearch', 'class' => 'form-horizontal','method' => 'get', 'route' => 'ortho.patients.index', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>患者管理　＞　検索患者</h3>

        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="textName">カルテNo</label></td>
            <td>
              <input type="text" name="p_no" id="p_no" maxlength="8" class="form-control" value="{{ @$p_no }}">
            </td>
          </tr>

          <tr>
            <td class="col-title">TEL</td>
            <td>
              <input type="text" name="p_tel" id="p_tel" maxlength="12" class="form-control" value="{{ @$p_tel }}">
            </td>
          </tr>

          <tr>
            <td class="col-title">HOS Memo</td>
            <td>
              <input type="text" name="p_hos_memo" id="p_hos_memo" maxlength="12" class="form-control" value="{{ @$p_hos_memo }}">
            </td>
          </tr>

          <tr>
            <td class="col-title">HOS</td>
            <td>
              <select  name="p_hos" class="form-control" title="▼選択">
                <option data-hidden="true"></option>
                @foreach ( $clinics as $clinic )
                <option value="{{ $clinic->clinic_id }}" @if(@$p_hos == $clinic->clinic_id) selected="" @endif >{{ $clinic->clinic_name }}</option>
                @endforeach
              </select>
            </div>
            </td>
          </tr>
        </table>
      </div>

      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="" id="" value="検索開始（一覧表表示）" type="submit" class="btn btn-sm btn-page mar-right">
          <input name="Reset" id="btnReset" value="条件クリア" type="reset" class="btn btn-sm btn-page mar-right">
        </div>
      </div>
    </div>
  </section>
{!! Form::close() !!}

@endsection