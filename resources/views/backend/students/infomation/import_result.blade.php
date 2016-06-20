@extends('backend.backend')

@section('content')
<!-- content student import result -->
    <section id="page">
      <div class="container">
        <div class="row content">
          <p>全10000件中、998件を本登録／仮登録として取り込みました。取り込みが出来なかったデータは以下の通りです。</p>
        </div>
        <div class="row content content--import">
          <div class="col-md-12 bg-warning">
            <ul>
              <li><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>37行目</li>
              <li><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>999行目</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  <!-- content student import result -->
@endsection