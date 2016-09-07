@extends('backend.ortho.ortho')

@section('content')
	<!-- Content shift list -->
    <section id="page">
      <div class="container">
        <div class="row content content--list">
          <h3 class="margin-bottom">シフト管理　＞　シフトのカレンダー表示</h3>
            <div class="fillter">
              <div class="col-md-12 page-left">
                <select name="" id="" class="form-control form-control--small">
                  <option value="">▼地域</option>
                </select>
                <select name="" id="" class="form-control form-control--small">
                  <option value="">▼医院名</option>
                </select>
                <input class="btn btn-sm btn-page no-border" name="button" onclick="location.href='carte_patient_search.html'" value="絞込表示" type="button">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <select name="" id="" class="form-control form-control--small">
                  <option value="">▼Dr</option>
                </select>
                <input class="btn btn-sm btn-page no-border" name="button" onclick="location.href='logout.html'" value="絞込表示" type="button">
              </div>
            </div>
            <div>
              <input type="submit" name="button" id="button" value="&lt;&lt; 前月" class="btn btn-sm btn-page"/>
              <input type="submit" name="button2" id="button2" value="今月"  class="btn btn-sm btn-page"/>
              <input type="submit" name="button3" id="button3" value="翌月 &gt;&gt;"  class="btn btn-sm btn-page"/>
              <h3 class="text-center">2016年4月</h3>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table--calendar">
              <tr>
                <td class="col-title" align="center">日</td>
                <td class="col-title" align="center">月</td>
                <td class="col-title" align="center">火</td>
                <td class="col-title" align="center">水</td>
                <td class="col-title" align="center">木</td>
                <td class="col-title" align="center">金</td>
                <td class="col-title" align="center">土</td>
              </tr>
              <tr>
                <td><span class="td-disabled">27</span></td>
                <td><span class="td-disabled">28</span></td>
                <td><span class="td-disabled">29</span></td>
                <td><span class="td-disabled">30</span></td>
                <td><span class="td-disabled">31</span></td>
                <td><a href="shift_template-set.html" class="link-shift-template-set">1</a></td>
                <td><a href="shift_template-set.html" class="link-shift-template-set">2</a></td>
              </tr>
              <tr>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">3</a>
                </td>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">4</a>
                </td>
                <td>
                  <p><a href="shift_set.html" class="link-shift-set">5</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">6</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">7</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">8</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">9</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">10</a>
                </td>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">11</a>
                </td>
                <td>
                  <p><a href="shift_set.html">12</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">13</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">14</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">15</a></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">16<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
              </tr>
              <tr>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">17</a>
                </td>
                <td>
                  <a href="shift_template-set.html" class="link-shift-template-set">18</a>
                </td>
                <td>
                  <p><a href="shift_set.html">19<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">20<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">21<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">22<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
                <td>
                  <p><a href="shift_set.html">23<a/></p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr 
                      </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                  <p>
                    <a href="shift_edit.html">
                      <span class="fc-event">
                        <img src="common/image/hospital.png">たい矯正歯科
                        <img src="common/image/docter.png">大村Dr </span>
                    </a>
                  </p>
                </td>
              </tr>
            </table>
            </div>
        </div>
      </div>
    </section>
  <!-- End content shift list -->
@endsection