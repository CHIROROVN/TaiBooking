@extends('backend.backend')

@section('content')
<!-- Content student import -->
    <section id="page">
      <div class="container">
        <div class="row content content--import">
          <table class="table table-bordered">
            <tbody>
              <tr>
                <td class="col-title"><label for="textcsvfile">CSVファイル</label></td>
                <td>
                  <button type="button" class="bfs btn btn-primary" data-style="fileStyle-l"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> ファイルを選ぶ</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row content content--import">
          <div class="col-md-12 bg-warning">
            <h2>取り込みができるCSVファイルは、以下のフォーマットです。</h2>
            <ul>
              <li><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>文字コードはUTF-8です。</li>
              <li><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>1行目は見出しではありません。</li>
              <li><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>フォーマットは以下の通りです。</li>
            </ul>
          </div>
        </div>
        <div class="row content content--import">
          <div class="col-md-12 text-center">
            <input onclick="location.href='{{route('backend.students.import_result')}}'" value="本登録として取り込み開始" type="button" class="btn btn-sm btn-primary btn-mar-right">
            <input onclick="location.href='{{route('backend.students.import_result')}}'" value="仮登録として取り込み開始" type="button" class="btn btn-sm btn-primary">
          </div>
        </div>
      </div>
    </section>
    <!-- End content student import -->
    @endsection