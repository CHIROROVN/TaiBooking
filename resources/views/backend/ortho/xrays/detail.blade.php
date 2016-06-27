@extends('backend.ortho.ortho')

@section('content')
<section id="page">
  <div class="container content-page">
    <h3>放射線照射録管理　＞　患者の一覧　＞　放射線照射録の表示</h3>

    <table class="table table-bordered">
      <tbody>
        <tr>
          <td class="col-title">名前</td>
          <td>{{ $xray->p_no }}　{{ $xray->p_name }}（{{ $xray->p_name_kana }}）</td>
          <td class="col-title">担当</td>
          <td>
            @foreach ( $users as $user )
              @if ( $user->id == $xray->p_dr )
              {{ $user->u_name }}
              @endif
            @endforeach
          </td>
        </tr>
        <tr>
          <td class="col-title">生年月日</td>
          <td>1980年11月27日</td>
          <td class="col-title">性別</td>
          <td><?php echo ($xray->p_sex == 1) ? '男' : '女'; ?></td>
        </tr>
      </tbody>
    </table>

    <div class="row">
      <div class="col-xs-6 col-md-6">
        ▼レントゲン
      </div>
      <div class="col-xs-6 col-md-6 text-right">
        <input onclick="location.href='{{ route('ortho.xrays.regist', [ 'patient_id' => $xray->p_id ]) }}'" value="レントゲン新規入力" type="button" class="btn btn-sm btn-page">
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
            <td>{{ date('Y/m/d', strtotime($patient_xray->xray_date)) }}</td>
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
              <input onclick="location.href='{{ route('ortho.xrays.edit', [ $patient_xray->xray_id ]) }}'" value="編集" type="button" class="btn  btn-xs btn-page">
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
                      <a href="{{ route('ortho.xrays.delete', [ $patient_xray->xray_id ]) }}" class="btn btn-sm btn-page">{{ trans('common.modal_btn_delete') }}</a>
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
        <input onclick="location.href='xray_3dct_regist.html'" value="3D-CT新規入力" type="button" class="btn btn-sm btn-page">
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
        <tr>
          <td>2016/05/01</td>
          <td>3回目</td>
          <td>P</td>
          <td>120kv 10mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/12/31</td>
          <td>2回目</td>
          <td>P</td>
          <td>120kv 10mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
        <tr>
          <td>2015/09/01</td>
          <td>1回目</td>
          <td>P</td>
          <td>120kv 5mA</td>
          <td></td>
          <td></td>
          <td></td>
          <td align="center">
            <input name="button3" id="button3" value="編集" type="submit" class="btn btn-xs btn-page"/>
          </td>
          <td align="center">
            <input name="button4" id="button4" value="削除" type="submit" class="btn btn-xs btn-page"/>
          </td>
        </tr>
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