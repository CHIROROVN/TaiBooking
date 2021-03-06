@extends('backend.ortho.ortho')
@section('content')
{!! Form::open( ['id' => 'frmBookingSearch', 'class' => 'form-horizontal','method' => 'get', 'route' => 'ortho.patients.index', 'enctype'=>'multipart/form-data', 'accept-charset'=>'utf-8']) !!}
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>患者管理　＞　検索患者</h3>

        <table class="table table-bordered">
          <tr>
            <td class="col-title"><label for="p_no">カルテNo</label></td>
            <td>
              <input type="text" name="p_no" id="p_no" maxlength="8" class="form-control" value="{{ $p_no }}" placeholder="カルテNo">
            </td>
          </tr>

          <tr>
            <td class="col-title"><label for="p_name_f">氏名</label></td>
            <td>
              <input type="text" name="p_name_f" id="p_name_f" class="form-control form-control--sm" value="{{ $p_name_f }}" placeholder="患者の氏名">
              <input type="text" name="p_name_g" id="p_name_g" class="form-control form-control--sm" value="{{ $p_name_g }}" placeholder="患者の苗字">
            </td>
          </tr>

          <tr>
            <td class="col-title"><label for="p_name_f_kana">氏名（ひらがな）</label></td>
            <td>
              <input type="text" name="p_name_f_kana" id="p_name_f_kana" class="form-control form-control--sm" value="{{ $p_name_f_kana }}" placeholder="患者の氏名（ひらがな）">
              <input type="text" name="p_name_g_kana" id="p_name_g_kana" class="form-control form-control--sm" value="{{ $p_name_g_kana }}" placeholder="患者の苗字（ひらがな）">
            </td>
          </tr>

          <tr>
            <td class="col-title">TEL</td>
            <td>
              <input type="text" name="p_tel" id="p_tel" maxlength="12" class="form-control" value="{{ @$p_tel }}" placeholder="電話番号">
            </td>
          </tr>

          <tr>
            <td class="col-title">携帯電話</td>
            <td>
              <input type="text" name="p_mobile" id="p_mobile" maxlength="12" class="form-control" value="{{ @$p_mobile }}" placeholder="携帯電話">
            </td>
          </tr>

          <tr>
            <td class="col-title">HOS（テキスト入力）</td>
            <td>
              <input type="text" name="p_hos_memo" id="p_hos_memo" maxlength="12" class="form-control" value="{{ @$p_hos_memo }}">
            </td>
          </tr>

          <tr>
            <td class="col-title">HOS（プルダウン選択）</td>
            <td>
              <select  name="p_hos" class="form-control" title="▼選択">
                <option data-hidden="true"></option>

                <?php $selected = '' ?>
                @foreach ( $clinics as $clinic )
                <?php $selected = ($clinic->clinic_id == $p_hos || $clinic->clinic_id == Auth::user()->u_power_booking) ? 'selected' : '' ?>
                <option value="{{ $clinic->clinic_id }}" {{ $selected }} >{{ $clinic->clinic_name }}</option>
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
