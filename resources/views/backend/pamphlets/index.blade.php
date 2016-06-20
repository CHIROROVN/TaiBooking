@extends('backend.backend')

@section('content')
<div class="container">

  <div class="row content content--list">
    <div class="msg-alert-action">
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
          
    <p>全{{ $count_all }}件中、{{ $total_count }}件が該当しました。うち、{{ $record_from }}～{{ $record_to + $pamphlets->count() }}件を表示しています。</p>

    <div class="row fl-right mar-bottom">
      <div class="col-md-12">
        <input onclick="location.href='{{ route('backend.pamphlets.regist') }}'" value="資料請求番号の新規登録" type="button" class="btn btn-sm btn-primary"/>
      </div>
    </div>
    
    <table class="table table-bordered table-striped clearfix">
      <tr>
        <td class="col-title" align="center">資料請求番号</td>
        <td class="col-title" align="center">資料名</td>
        <td class="col-title" align="center">種別</td>
        <td class="col-title" align="center">使用/未使用</td>
        <td class="col-title" align="center">学校</td>
        <td class="col-title" align="center">発送</td>
        <td class="col-title" align="center">学校</td>
        <td class="col-title" align="center">都道府県</td>
        <td class="col-title" align="center">対象</td>
        <td class="col-title" align="center">編集</td>
        <td class="col-title" align="center">削除</td>
      </tr>
      @if (empty($pamphlets) || count($pamphlets) == 0)
      <tr>
        <td colspan="11" align="center"><strong>{{ trans('common.no_data_correspond') }}</strong></td>
      </tr>
      @else
        @foreach ($pamphlets as $pamphlet)
          <tr>
            <td>{{ $pamphlet->pamph_number }}</td>
            <td>{{ $pamphlet->pamph_name }}</td>  
            <td>
              <?php
                if ( $pamphlet->pamph_kind == 0 ) {
                  echo '学校';
                }elseif ( $pamphlet->pamph_kind == 1 ) {
                  echo '予備';
                } else {
                  echo '一括';
                }
              ?>
            </td>
            <td><?php echo ($pamphlet->pamph_class == 1) ? '使用済み' : '未使用'; ?></td>
            <td>
              @foreach ( $pamphlets_distinct as $item )
                @if ( $item->pamph_number == $pamphlet->pamph_number )
                {{ $item->cus_name }} <br>
                @endif
              @endforeach
            </td>
            <td><?php echo ($pamphlet->pamph_send == 1) ? 'あり' : 'なし'; ?></td>
            <td><?php echo isset($bunyas[$pamphlet->pamph_bunya_id]) ? $bunyas[$pamphlet->pamph_bunya_id] : ''; ?></td>
            <td>
              <?php
              if ( isset($areas[$pamphlet->pamph_area]) ) {
                echo $areas[$pamphlet->pamph_area];
              } elseif ( isset($prefs[$pamphlet->pamph_pref]) ) {
                echo $prefs[$pamphlet->pamph_pref];
              } else {
                echo '';
              }
              ?>
            </td>
            <td>
              <?php
                if ( $pamphlet->pamph_sex == 0 ) {
                  echo '共通';
                }elseif ( $pamphlet->pamph_sex == 1 ) {
                  echo '男';
                } else {
                  echo '女';
                }
              ?>
            </td>

            <!-- edit -->
            <td align="center">
              <table style="margin-top: 0 !important;">
                <tr>
                  <td>
                    <?php $tmp_count = 0; ?>
                    @foreach ( $pamphlets_distinct as $item )
                      @if ( $item->pamph_number == $pamphlet->pamph_number )
                      <input style="margin-top: 5px;" onclick="location.href='{{ route('backend.pamphlets.edit', array($item->pamph_id, 
                        's_pamph_number'          => $s_pamph_number,
                        's_pamph_name'            => $s_pamph_name,
                        's_pamph_kind_school'     => $s_pamph_kind_school,
                        's_pamph_kind_reserve'    => $s_pamph_kind_reserve,
                        's_pamph_kind_bundle'     => $s_pamph_kind_bundle,
                        's_pamph_class_unused'    => $s_pamph_class_unused,
                        's_pamph_class_used'      => $s_pamph_class_used,
                        's_pamph_cus_id'          => $s_pamph_cus_id,
                        's_pamph_cus_name'        => $s_pamph_cus_name,
                        's_pamph_send_none'       => $s_pamph_send_none,
                        's_pamph_send_yes'        => $s_pamph_send_yes,
                        's_pamph_bunya_id'        => $s_pamph_bunya_id,
                        's_pamph_bunya_name'      => $s_pamph_bunya_name,
                        's_pamph_pref'            => $s_pamph_pref,
                        's_pamph_area'            => $s_pamph_area,
                        's_pamph_sex_unspecified' => $s_pamph_sex_unspecified,
                        's_pamph_sex_men'         => $s_pamph_sex_men,
                        's_pamph_sex_women'       => $s_pamph_sex_women,
                        'page'                    => $pamphlets->currentPage()
                      )) }}'" value="編集" type="button" class="btn btn-xs btn-primary"> <br>
                      <?php $tmp_count ++; ?>
                      @endif
                    @endforeach
                  </td>
                </tr>
              </table>
            </td>

            <!-- delete -->
            <td align="center">
              <table style="margin-top: 0 !important;">
                <tr>
                  <td>
                    <?php $tmp_count = 0; ?>
                    @foreach ( $pamphlets_distinct as $item )
                      @if ( $item->pamph_number == $pamphlet->pamph_number )
                      <button style="margin-top: 5px;" type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModal-single-{{ $item->pamph_id }}">削除</button>
                      <!-- popup -->
                      <div class="modal fade bs-example-modal-sm" id="myModal-single-{{ $item->pamph_id }}" role="dialog">
                        <div class="modal-dialog modal-sm">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">{{ trans('common.modal_header_delete') }}</h4>
                            </div>
                            <div class="modal-body">
                              <p>{{ trans('common.modal_content_delete') }}</p>
                            </div>
                            <div class="modal-footer">
                              <a href="{{ route('backend.pamphlets.delete', array($item->pamph_id, 
                                's_pamph_number'          => $s_pamph_number,
                                's_pamph_name'            => $s_pamph_name,
                                's_pamph_kind_school'     => $s_pamph_kind_school,
                                's_pamph_kind_reserve'    => $s_pamph_kind_reserve,
                                's_pamph_kind_bundle'     => $s_pamph_kind_bundle,
                                's_pamph_class_unused'    => $s_pamph_class_unused,
                                's_pamph_class_used'      => $s_pamph_class_used,
                                's_pamph_cus_id'          => $s_pamph_cus_id,
                                's_pamph_cus_name'        => $s_pamph_cus_name,
                                's_pamph_send_none'       => $s_pamph_send_none,
                                's_pamph_send_yes'        => $s_pamph_send_yes,
                                's_pamph_bunya_id'        => $s_pamph_bunya_id,
                                's_pamph_bunya_name'      => $s_pamph_bunya_name,
                                's_pamph_pref'            => $s_pamph_pref,
                                's_pamph_area'            => $s_pamph_area,
                                's_pamph_sex_unspecified' => $s_pamph_sex_unspecified,
                                's_pamph_sex_men'         => $s_pamph_sex_men,
                                's_pamph_sex_women'       => $s_pamph_sex_women,
                                'page'                    => $pamphlets->currentPage()
                              )) }}" class="btn btn-xs btn-primary">{{ trans('common.modal_btn_delete') }}</a>
                              <button type="button" class="btn btn-xs btn-default" data-dismiss="modal">{{ trans('common.modal_btn_cancel') }}</button>
                            </div>
                          </div>
                          <!-- End Modal content-->
                        </div>
                      </div>
                      <!-- end popup --> <br>
                      <?php $tmp_count ++; ?>
                      @endif
                    @endforeach
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        @endforeach
      @endif
    </table>
  </div>
  <div class="row mar-bottom30">
    <div class="col-md-12 text-center">
      {!! $pamphlets->appends(['s_pamph_number'          => $s_pamph_number,
                                's_pamph_name'            => $s_pamph_name,
                                's_pamph_kind_school'     => $s_pamph_kind_school,
                                's_pamph_kind_reserve'    => $s_pamph_kind_reserve,
                                's_pamph_kind_bundle'     => $s_pamph_kind_bundle,
                                's_pamph_class_unused'    => $s_pamph_class_unused,
                                's_pamph_class_used'      => $s_pamph_class_used,
                                's_pamph_cus_id'          => $s_pamph_cus_id,
                                's_pamph_cus_name'        => $s_pamph_cus_name,
                                's_pamph_send_none'       => $s_pamph_send_none,
                                's_pamph_send_yes'        => $s_pamph_send_yes,
                                's_pamph_bunya_id'        => $s_pamph_bunya_id,
                                's_pamph_bunya_name'      => $s_pamph_bunya_name,
                                's_pamph_pref'            => $s_pamph_pref,
                                's_pamph_area'            => $s_pamph_area,
                                's_pamph_sex_unspecified' => $s_pamph_sex_unspecified,
                                's_pamph_sex_men'         => $s_pamph_sex_men,
                                's_pamph_sex_women'       => $s_pamph_sex_women
                              ])->render(new App\Pagination\SimplePagination($pamphlets))  !!}
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 text-center">
      <input name="button7" value="再検索（条件を引き継ぐ）" type="submit" class="btn btn-sm btn-primary form-control--mar-right" onclick="location.href='{{ route('backend.pamphlets.search', array(
        's_pamph_number'          => $s_pamph_number,
        's_pamph_name'            => $s_pamph_name,
        's_pamph_kind_school'     => $s_pamph_kind_school,
        's_pamph_kind_reserve'    => $s_pamph_kind_reserve,
        's_pamph_kind_bundle'     => $s_pamph_kind_bundle,
        's_pamph_class_unused'    => $s_pamph_class_unused,
        's_pamph_class_used'      => $s_pamph_class_used,
        's_pamph_cus_id'          => $s_pamph_cus_id,
        's_pamph_cus_name'        => $s_pamph_cus_name,
        's_pamph_send_none'       => $s_pamph_send_none,
        's_pamph_send_yes'        => $s_pamph_send_yes,
        's_pamph_bunya_id'        => $s_pamph_bunya_id,
        's_pamph_bunya_name'      => $s_pamph_bunya_name,
        's_pamph_pref'            => $s_pamph_pref,
        's_pamph_area'            => $s_pamph_area,
        's_pamph_sex_unspecified' => $s_pamph_sex_unspecified,
        's_pamph_sex_men'         => $s_pamph_sex_men,
        's_pamph_sex_women'       => $s_pamph_sex_women
      )) }}'">
      <input name="button5" value="再検索（条件をクリアする）" type="reset" class="btn btn-sm btn-primary" onclick="location.href='{{ route('backend.pamphlets.search') }}'">
    </div>
  </div>
</div>
@endsection