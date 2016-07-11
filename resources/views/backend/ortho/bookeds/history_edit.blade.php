@extends('backend.ortho.ortho')

@section('content')
  {!! Form::open(array('route' => ['ortho.bookeds.history.edit', $booked->booking_id], 'method' => 'post')) !!}
  <section id="page">
    <div class="container">
      <div class="row content-page">
        <h3>予約管理　＞　予約の一覧　＞　来院履歴の編集</h3>
        <table class="table table-bordered">

          <!-- result_date -->
          <tr>
            <td class="col-title" colspan="2"><label for="result_date">日付</label></td>
            <td><select name="result_date" id="result_date" class="form-control form-control--medium">
              <option value="">----日</option>
              @foreach ( $dates as $date )
              <option value="{{ $date }}" @if($currentDay == $date) selected="" @endif>{{ formatDate($date, '/') }}({{ DayJp($date) }}日)</option>
              @endforeach
            </select></td>
          </tr>

          <!-- result_start_time -->
          <tr>
            <td class="col-title" colspan="2">時間</td>
            <td><select name="result_start_time_hh" id="result_start_time_hh" class="form-control form-control--small">
              <option>6時</option>
              <option>7時</option>
              <option>8時</option>
              <option selected>9時</option>
              <option>10時</option>
              <option>11時</option>
              <option>12時</option>
              <option>13時</option>
              <option>14時</option>
              <option>15時</option>
              <option>16時</option>
              <option>17時</option>
              <option>18時</option>
              <option>19時</option>
              <option>20時</option>
              <option>21時</option>
              <option>22時</option>
              <option>23時</option>
            </select>
              <select name="result_start_time_mm" id="result_start_time_mm" class="form-control form-control--small">
                <option selected>00分</option>
                <option>15分</option>
                <option>30分</option>
                <option>45分</option>
            </select>
              ～
              <!-- result_total_time -->
              <select name="result_total_time_hh" id="result_total_time_hh" class="form-control form-control--small">
                <option>6時</option>
                <option>7時</option>
                <option>8時</option>
                <option selected>9時</option>
                <option>10時</option>
                <option>11時</option>
                <option>12時</option>
                <option>13時</option>
                <option>14時</option>
                <option>15時</option>
                <option>16時</option>
                <option>17時</option>
                <option>18時</option>
                <option>19時</option>
                <option>20時</option>
                <option>21時</option>
                <option>22時</option>
                <option>23時</option>
              </select>
              <select name="result_total_time_mm" id="result_total_time_mm" class="form-control form-control--small">
                <option>00分</option>
                <option selected>15分</option>
                <option>30分</option>
                <option>45分</option>
              </select></td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbChair">医院</label></td>
            <td>
              <select name="cbClinic" id="cbClinic" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbDoctor">ドクター</label></td>
            <td>
              <select name="cbDoctor" id="cbDoctor" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbHygienist">衛生士</label></td>
            <td>
              <select name="cbHygienist" id="cbHygienist" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbTreatContent1">実施業務-1</label></td>
            <td>
              <select name="cbTreatContent1" id="cbTreatContent1" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbTreatContent2">実施業務-2</label></td>
            <td>
              <select name="cbTreatContent2" id="cbTreatContent2" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title" colspan="2"><label for="cbMemo">メモ</label></td>
            <td><textarea></textarea>
            </td>
          </tr>

          <tr>
            <td class="col-title" rowspan="3">次回予約のために<br>
              ※Drの指示による</td>
            <td class="col-title"><label for="cbInspection">日時候補</label></td>
            <td>
              <div class="form-inline">
                <input type="text" name="textfield" id="textfield">
              </div>
            </td>
          </tr>
          <tr>
            <td class="col-title"><label for="cbTreatContent1">予定業務-1</label></td>
            <td>
              <select name="nextTreatContent1" id="nextTreatContent1" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>
          <tr>
            <td class="col-title"><label for="cbTreatContent2">予定業務-2</label></td>
            <td>
              <select name="nextTreatContent2" id="nextTreatContent2" class="form-control">
                <option>▼選択</option>
              </select>
            </td>
          </tr>

        </table>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input name="button2" id="button2" value="保存する" type="submit" class="btn btn-sm btn-page">
      </div>
      </div>
      <div class="row margin-bottom">
        <div class="col-md-12 text-center">
          <input onclick="history.back()" value="前の画面に戻る" type="button" class="btn btn-sm btn-page">
        </div>
      </div>
    </div>
  </section>
  {!! Form::close() !!}
@endsection