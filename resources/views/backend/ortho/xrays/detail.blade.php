@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　患者の一覧　＞　放射線照射録の表示</h3>

    <div class="msg-alert-action margin-top-15">
      @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @elseif($message = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade in" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul class="no-margin-bottom"><strong><li> {{ $message }}</li></strong></ul>
        </div>
      @endif
    </div>

    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title">名前</td>
          <td>{{ $patient->p_no }}　{{ $patient->p_name }}（{{ $patient->p_name_kana }}）</td>
          <td class="col-title">担当</td>
          <td>
            @foreach ( $users as $user )
              @if ( $user->id == $patient->p_dr )
              {{ $user->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">生年月日</td>
          <td>{{ date('Y', strtotime($patient->p_birthday)) }}年{{ date('m', strtotime($patient->p_birthday)) }}月{{ date('d', strtotime($patient->p_birthday)) }}日</td>
          <td class="col-title">性別</td>
          <td><?php echo ($patient->p_sex == 1) ? '男' : '女'; ?></td>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼レントゲン
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='{{ route('ortho.xrays.regist', [ $patient->p_id ]) }}'" value="レントゲン新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <!-- xray -->
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">種類</td>
          <td align="center">撮影場所</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        @if ( empty($patient_xrays) || count($patient_xrays) == 0 )
        <tr>
          <td colspan="9">
            <h3 align="center" style="padding-bottom: 0;">{{ trans('common.no_data_correspond') }}</h3>
          </td>
        </tr>
        @else
          @foreach ( $patient_xrays as $patient_xray )
          <tr>
            <td>{{ date('Y/m/d', strtotime(@$patient_xray->xray_date)) }}</td>
            <td>
              @if ( !empty($patient_xray->xray_cat_1) )
              A_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_2) )
              A_stage F<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_3) )
              B_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_4) )
              B_stage F<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_5) )
              C_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_6) )
              D_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_7) )
              G_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_8) )
              5G_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_9) )
              10G_stage<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_10) )
              Ope前<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_11) )
              Ope後<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_12) )
              経過<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_13) )
              デンタル<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_14) )
              オクルーザル<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_15) )
              矯正終了<br>
              @endif
              @if ( !empty($patient_xray->xray_cat_16) )
              その他<br>
              @endif
            </td>
            <td>
              @if ( !empty($patient_xray->xray_kind_1) )
              パノラマ<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_2) )
              セファロ側<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_3) )
              セファロ正<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_4) )
              オクルーザル右<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_5) )
              オクルーザル左<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_6) )
              デンタル<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_7) )
              顔写真<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_8) )
              手根骨<br>
              @endif
              @if ( !empty($patient_xray->xray_kind_9) )
              その他<br>
              @endif
            </td>
            <td>{{ $patient_xray->clinic_name }}</td>
            <td>{{ $patient_xray->p_name }}</td>
            <td>
              @if ( !empty($patient_xray->xray_memo_1) )
              CD-R<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_2) )
              Dr.S<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_3) )
              蓋裂<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_4) )
              過剰歯<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_5) )
              2回撮影<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_6) )
              再治療<br>
              @endif
              @if ( !empty($patient_xray->xray_memo_7) )
              転院<br>
              @endif
            </td>
            <td>{{ $patient_xray->xray_memo }}</td>
            <td align="center">
              <input onclick="location.href='{{ route('ortho.xrays.edit', [ $patient->p_id, $patient_xray->xray_id ]) }}'" value="編集" type="button" class="btn  btn-xs btn-page">
            </td>
            <td align="center">
              <!-- Trigger the modal with a button -->
              <input type="button" value="削除" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-{{ $patient_xray->xray_id }}"/>
              <!-- Modal -->
              <div class="modal fade" id="myModal-{{ $patient_xray->xray_id }}" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.xrays.delete', [ $patient->p_id, $patient_xray->xray_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end Modal -->
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼3D-CT
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='{{ route('ortho.xrays.x3dct.regist', [ 'patient_id' => $patient->p_id ]) }}'" value="3D-CT新規入力" type="button" class="btn btn-sm btn-page">
      </div>
    </div>

    <!-- 3dct -->
    <table class="table table-bordered treatment2-list">
      <tbody>
        <tr class="col-title">
          <td align="center">撮影日</td>
          <td align="center">区分</td>
          <td align="center">モード</td>
          <td align="center">撮影条件</td>
          <td align="center">撮影者</td>
          <td align="center">備考1</td>
          <td align="center">備考2</td>
          <td align="center">編集</td>
          <td align="center">削除</td>
        </tr>
        <?php //echo '<pre>';print_r($patient_3dcts);echo '</pre>'; ?>
        @if ( !count($patient_3dcts) )
        <tr>
          <td colspan="9">
            <h3 align="center" style="padding-bottom: 0;">{{ trans('common.no_data_correspond') }}</h3>
          </td>
        </tr>
        @else
          @foreach ( $patient_3dcts as $patient_3dct )
          <tr>
            <td>
              @if ( !empty($patient_3dct->ct_date) )
                {{ date('Y/m/d', strtotime(@$patient_3dct->ct_date)) }}
              @endif
            </td>
            <td>
              @if ( !empty($patient_3dct->ct_cat_1) )
              1回目<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_2) )
              2回目<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_3) )
              3回目<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_4) )
              Ope前<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_5) )
              Ope後<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_6) )
              インプラント<br>
              @endif
              @if ( !empty($patient_3dct->ct_cat_7) )
              その他<br>
              @endif
            </td>
            <td>
              @if ( !empty($patient_3dct->ct_mode_1) )
              I<br>
              @endif
              @if ( !empty($patient_3dct->ct_mode_2) )
              P<br>
              @endif
              @if ( !empty($patient_3dct->ct_mode_3) )
              F<br>
              @endif
            </td>
            <td>
              @if ( !empty($patient_3dct->ct_condition_1) )
              100kv 10mA<br>
              @endif
              @if ( !empty($patient_3dct->ct_condition_2) )
              100kv 15mA<br>
              @endif
              @if ( !empty($patient_3dct->ct_condition_3) )
              120kv 5mA<br>
              @endif
              @if ( !empty($patient_3dct->ct_condition_4) )
              120kv 10mA<br>
              @endif
              @if ( !empty($patient_3dct->ct_condition_5) )
              120kv 15mA<br>
              @endif
            </td>
            <td>{{ $patient_3dct->p_name }}</td>
            <td>
              @if ( !empty($patient_3dct->ct_memo_1) )
              CD-R<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_2) )
              Dr.S<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_3) )
              口蓋裂<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_4) )
              過剰歯<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_5) )
              2回撮影<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_6) )
              再治療<br>
              @endif
              @if ( !empty($patient_3dct->ct_memo_7) )
              転院<br>
              @endif
            </td>
            <td>{{ $patient_3dct->ct_memo }}</td>
            <td align="center">
              <input onclick="location.href='{{ route('ortho.xrays.x3dct.edit', [ $patient->p_id, $patient_3dct->ct_id ]) }}'" value="編集" type="button" class="btn  btn-xs btn-page">
            </td>
            <td align="center">
              <!-- Trigger the modal with a button -->
              <input type="button" value="削除" class="btn btn-xs btn-page" data-toggle="modal" data-target="#myModal-3dct-{{ $patient_3dct->ct_id }}"/>
              <!-- Modal -->
              <div class="modal fade" id="myModal-3dct-{{ $patient_3dct->ct_id }}" role="dialog">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                    </div>
                    <div class="modal-body">
                      <p>{{ trans('common.modal_content_delete') }}</p>
                    </div>
                    <div class="modal-footer">
                      <a href="{{ route('ortho.xrays.x3dct.delete', [ $patient->p_id, $patient_3dct->ct_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
                      <button type="button" class="btn btn-sm btn-page" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- end Modal -->
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input onclick="location.href='{{ route('ortho.xrays.index') }}'" value="患者一覧に戻る" type="button" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>    
</section>
@endsection