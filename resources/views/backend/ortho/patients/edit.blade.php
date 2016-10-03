@extends('backend.ortho.ortho')

@section('content')

{!! Form::open(array('route' => ['ortho.patients.edit', $patient->p_id], 'enctype'=>'multipart/form-data')) !!}
<section id="page">
  <div class="container">
    <div class="row content-page">
      <h3>患者管理　＞　登録済み患者情報の編集</h3>
        <div class="table-responsive">
          <table class="table table-bordered">
            <input type="hidden" name="cur_p_no" value="{{$patient->p_no}}" />
            <!-- p_no -->
            <tr>
              <td class="col-title"><label for="p_no">カルテNo</label></td>
              <td>
                @if ( old('p_no') )
                <input type="text" name="p_no" id="p_no" class="form-control" maxlength="8" value="{{ old('p_no') }}" />
                @else
                <input type="text" name="p_no" id="p_no" class="form-control" maxlength="8" value="{{ $patient->p_no }}" />
                @endif

                <span class="error-input">@if ($errors->first('p_no')) {!! $errors->first('p_no') !!} @endif</span>
              </td>
            </tr>

            <!-- p_dr: user id only doctor -->
            <tr>
              <td class="col-title"><label for="p_dr">担当</label></td>
              <td>
                <select name="p_dr" title="▼選択" id="p_dr" class="form-control">
                  <option data-hidden="true"></option>
                  @foreach ( $user_doctors as $user_doctor )
                    @if ( old('p_dr') )
                    <option value="{{ $user_doctor->id }}" @if(old('p_dr') == $user_doctor->id) selected="" @endif >{{ $user_doctor->u_name }}</option>
                    @else
                    <option value="{{ $user_doctor->id }}" @if($patient->p_dr == $user_doctor->id) selected="" @endif >{{ $user_doctor->u_name }}</option>
                    @endif
                  @endforeach
                </select>
                <span class="error-input">@if ($errors->first('p_dr')) {!! $errors->first('p_dr') !!} @endif</span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="p_hos_memo">HOS</label></td>
              <td>
                <!-- p_hos_memo -->
                <div class="mar-bottom">
                  @if ( old('p_hos_memo') )
                  <input type="text" name="p_hos_memo" id="p_hos_memo" class="form-control" value="{{ old('p_hos_memo') }}" />
                  @else
                  <input type="text" name="p_hos_memo" id="p_hos_memo" class="form-control" value="{{ $patient->p_hos_memo }}" />
                  @endif
                  <span class="error-input">@if ($errors->first('p_hos_memo')) {!! $errors->first('p_hos_memo') !!} @endif</span>
                </div>

                <!-- p_hos: clinic name, id -->
                <div>
                  <select  name="p_hos" class="form-control" title="▼選択">
                    <option data-hidden="true"></option>
                    @foreach ( $clinics as $clinic )
                      @if ( old('p_hos') )
                      <option value="{{ $clinic->clinic_id }}" @if(old('p_hos') == $clinic->clinic_id) selected="" @endif >{{ $clinic->clinic_name }}</option>
                      @else
                      <option value="{{ $clinic->clinic_id }}" @if($patient->p_hos == $clinic->clinic_id) selected="" @endif >{{ $clinic->clinic_name }}</option>
                      @endif
                    @endforeach
                  </select>
                  <span class="error-input">@if ($errors->first('p_hos')) {!! $errors->first('p_hos') !!} @endif</span>
                </div>
              </td>
            </tr>

            <!-- p_name -->
            <tr>
              <td class="col-title"><label for="p_name_f">氏名 <span class="note_required">※</span></label></td>
              <td>
                @if ( old('p_name_f') )
                <input type="text" name="p_name_f" id="p_name_f" class="form-control form-control--medium" value="{{ old('p_name_f') }}" />
                @else
                <input type="text" name="p_name_f" id="p_name_f" class="form-control form-control--medium" value="{{ $patient->p_name_f }}" />
                @endif
                @if ( old('p_name_g') )
                <input type="text" name="p_name_g" id="p_name_g" class="form-control form-control--medium" value="{{ old('p_name_g') }}" />
                @else
                <input type="text" name="p_name_g" id="p_name_g" class="form-control form-control--medium" value="{{ $patient->p_name_g }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_name_f')) {!! $errors->first('p_name_f') !!} @endif</span>
                <span class="error-input">@if ($errors->first('p_name_g')) {!! $errors->first('p_name_g') !!} @endif</span>
              </td>
            </tr>

            <!-- p_name_kana -->
            <tr>
              <td class="col-title"><label for="p_name_f_kana">氏名（よみ） <span class="note_required">※</span></label></td>
              <td>
                @if ( old('p_name_f_kana') )
                <input type="text" name="p_name_f_kana" id="p_name_f_kana" class="form-control form-control--medium" value="{{ old('p_name_f_kana') }}" />
                @else
                <input type="text" name="p_name_f_kana" id="p_name_f_kana" class="form-control form-control--medium" value="{{ $patient->p_name_f_kana }}" />
                @endif
                @if ( old('p_name_g_kana') )
                <input type="text" name="p_name_g_kana" id="p_name_g_kana" class="form-control form-control--medium" value="{{ old('p_name_g_kana') }}" />
                @else
                <input type="text" name="p_name_g_kana" id="p_name_g_kana" class="form-control form-control--medium" value="{{ $patient->p_name_g_kana }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_name_f_kana')) ※{!! $errors->first('p_name_f_kana') !!} @endif</span>
                <span class="error-input">@if ($errors->first('p_name_g_kana')) ※{!! $errors->first('p_name_g_kana') !!} @endif</span>
              </td>
            </tr>

            <!-- p_sex -->
            <tr>
              <td class="col-title">性別 <span class="note_required">※</span></td>
              <td>
                @if ( old('p_sex') )
                <input type="radio" name="p_sex" value="1" @if(old('p_sex') == 1) checked="" @endif /> 男　　　
                <input type="radio" name="p_sex" value="2" @if(old('p_sex') == 2) checked="" @endif /> 女
                @else
                <input type="radio" name="p_sex" value="1" @if($patient->p_sex == 1) checked="" @endif /> 男　　　
                <input type="radio" name="p_sex" value="2" @if($patient->p_sex == 2) checked="" @endif /> 女
                @endif
                <span class="error-input">@if ($errors->first('p_sex')) ※{!! $errors->first('p_sex') !!} @endif</span>
              </td>
            </tr>

            <!-- p_birthday -->
            <tr>
              <td class="col-title"><label for="p_birthday">生年月日 <span class="note_required">※</span></label></td>
              <td>
                @if ( old('p_birthday') )
                <input type="text" name="p_birthday" id="p_birthday" class="form-control" value="{{ old('p_birthday') }}" placeholder="YYYY/mm/dd" />
                @else
                <input type="text" name="p_birthday" id="p_birthday" class="form-control" value="{{ date('Y/m/d', strtotime($patient->p_birthday)) }}" placeholder="YYYY/mm/dd" />
                @endif
                <span class="error-input">@if ($errors->first('p_sex')) ※{!! $errors->first('p_sex') !!} @endif</span>
              </td>
            </tr>

            <!-- p_family_dr -->
            <tr>
              <td class="col-title"><label for="p_family_dr">かかりつけ</label></td>
              <td>
                @if ( old('p_family_dr') )
                <input type="text" name="p_family_dr" id="p_family_dr" class="form-control" value="{{ old('p_family_dr') }}" />
                @else
                <input type="text" name="p_family_dr" id="p_family_dr" class="form-control" value="{{ $patient->p_family_dr }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_family_dr')) ※{!! $errors->first('p_family_dr') !!} @endif</span>
              </td>
            </tr>

            <!-- p_introduce -->
            <tr>
              <td class="col-title"><label for="p_introduce">紹介先</label></td>
              <td>
                @if ( old('p_introduce') )
                <input type="text" name="p_introduce" id="p_introduce" class="form-control" value="{{ old('p_introduce') }}" />
                @else
                <input type="text" name="p_introduce" id="p_introduce" class="form-control" value="{{ $patient->p_introduce }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_introduce')) ※{!! $errors->first('p_introduce') !!} @endif</span>
              </td>
            </tr>

            <!-- p_start -->
            <tr>
              <td class="col-title"><label for="p_start">治療開始</label></td>
              <td>
                @if( old('p_start') )
                <input type="text" name="p_start" id="p_start" class="form-control" value="{{ old('p_start') }}" />
                @else
                <input type="text" name="p_start" id="p_start" class="form-control" value="{{ $patient->p_start }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_start')) ※{!! $errors->first('p_start') !!} @endif</span>
              </td>
            </tr>

            <!-- p_start2 -->
            <tr>
              <td class="col-title"><label for="p_start2">2期開始</label></td>
              <td>
                @if ( old('p_start2') )
                <input type="text" name="p_start2" id="p_start2" class="form-control" value="{{ old('p_start2') }}" />
                @else
                <input type="text" name="p_start2" id="p_start2" class="form-control" value="{{ $patient->p_start2 }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_start2')) ※{!! $errors->first('p_start2') !!} @endif</span>
              </td>
            </tr>

            <!-- p_place: clicnic id,name -->
            <tr>
              <td class="col-title"><label for="p_place">撮影場所</label></td>
              <td>
                <select  name="p_place" id="p_place" title="▼選択" class="form-control">
                  <option data-hidden="true"></option>
                  @foreach ( $clinics as $clinic )
                    @if ( old('p_place') )
                    <option value="{{ $clinic->clinic_id }}" @if(old('p_place') == $clinic->clinic_id) selected="" @endif >{{ $clinic->clinic_name }}</option>
                    @else
                    <option value="{{ $clinic->clinic_id }}" @if($patient->p_place == $clinic->clinic_id) selected="" @endif >{{ $clinic->clinic_name }}</option>
                    @endif
                  @endforeach
                </select>
                <span class="error-input">@if ($errors->first('p_place')) ※{!! $errors->first('p_place') !!} @endif</span>
              </td>
            </tr>

            <!-- p_xray -->
            <tr>
              <td class="col-title"><label for="p_xray">xray</label></td>
              <td>
                @if ( old('p_xray') )
                <input type="text" name="p_xray" id="p_xray" class="form-control" value="{{ old('p_xray') }}" />
                @else
                <input type="text" name="p_xray" id="p_xray" class="form-control" value="{{ $patient->p_xray }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_xray')) ※{!! $errors->first('p_xray') !!} @endif</span>
              </td>
            </tr>

            <!-- p_clinic_memo -->
            <tr>
              <td class="col-title"><label for="p_clinic_memo">医院関連メモ</label></td>
              <td>
                @if ( old('p_clinic_memo') )
                <input type="text" name="p_clinic_memo" id="p_clinic_memo" class="form-control" value="{{ old('p_clinic_memo') }}" />
                @else
                <input type="text" name="p_clinic_memo" id="p_clinic_memo" class="form-control" value="{{ $patient->p_clinic_memo }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_clinic_memo')) ※{!! $errors->first('p_clinic_memo') !!} @endif</span>
              </td>
            </tr>

            <!-- p_personal_memo -->
            <tr>
              <td class="col-title"><label for="p_personal_memo">個人情報メモ</label></td>
              <td>
                @if ( old('p_personal_memo') )
                <input type="text" name="p_personal_memo" id="p_personal_memo" class="form-control" value="{{ old('p_personal_memo') }}" />
                @else
                <input type="text" name="p_personal_memo" id="p_personal_memo" class="form-control" value="{{ $patient->p_personal_memo }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_personal_memo')) ※{!! $errors->first('p_personal_memo') !!} @endif</span>
              </td>
            </tr>

            <!-- p_used -->
            <tr>
              <td class="col-title"><label for="p_used">使用装置</label></td>
              <td>
                @if ( old('p_used') )
                <input type="text" name="p_used" id="p_used" class="form-control" value="{{ old('p_used') }}" />
                @else
                <input type="text" name="p_used" id="p_used" class="form-control" value="{{ $patient->p_used }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_used')) ※{!! $errors->first('p_used') !!} @endif</span>
              </td>
            </tr>

            <!-- p_payment -->
            <tr>
              <td class="col-title"><label for="p_payment">入金状況</label></td>
              <td>
                @if ( old('p_payment') )
                <input type="text" name="p_payment" id="p_payment" class="form-control" value="{{ old('p_payment') }}" />
                @else
                <input type="text" name="p_payment" id="p_payment" class="form-control" value="{{ $patient->p_payment }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_payment')) ※{!! $errors->first('p_payment') !!} @endif</span>
              </td>
            </tr>

            <!-- p_amount -->
            <tr>
              <td class="col-title"><label for="p_amount">契約金</label></td>
              <td>
                @if ( old('p_amount') )
                <input type="text" name="p_amount" id="p_amount" class="form-control" value="{{ old('p_amount') }}" />
                @else
                <input type="text" name="p_amount" id="p_amount" class="form-control" value="{{ $patient->p_amount }}" />
                @endif
                <span class="error-input">@if ($errors->first('p_amount')) ※{!! $errors->first('p_amount') !!} @endif</span>
              </td>
            </tr>

            <tr>
              <td class="col-title"><label for="p_zip">住所</label></td>
              <td>
                <!-- p_zip -->
                <div class="mar-bottom">
                  @if ( old('p_zip') )
                  <input type="text" name="p_zip" id="p_zip" class="form-control" placeholder="郵便番号を入力して下さい。　例)100-0000" value="{{ old('p_zip') }}" />
                  @else
                  <input type="text" name="p_zip" id="p_zip" class="form-control" placeholder="郵便番号を入力して下さい。　例)100-0000" value="{{ $patient->p_zip }}" />
                  @endif
                  <span class="error-input">@if ($errors->first('p_zip')) ※{!! $errors->first('p_zip') !!} @endif</span>
                </div>
                <!-- p_pref -->
                <div class="mar-bottom">
                  <select name="p_pref" title="▼都道府県" class="form-control">
                    <option data-hidden="true"></option>
                    @foreach ( $prefs as $key => $value )
                      @if ( old('p_pref') )
                      <option value="{{ $key }}" @if(old('p_pref') == $key) selected="" @endif >{{ $value }}</option>
                      @else
                      <option value="{{ $key }}" @if($patient->p_pref == $key) selected="" @endif >{{ $value }}</option>
                      @endif
                    @endforeach
                  </select>
                  <span class="error-input">@if ($errors->first('p_pref')) {!! $errors->first('p_pref') !!} @endif</span>
                </div>
                <!-- p_address1 -->
                <div class="mar-bottom">
                  @if ( old('p_address1') )
                  <input type="text" name="p_address1" id="p_address1" class="form-control" placeholder="例）岡山市北区1-2-3" value="{{ old('p_address1') }}" />
                  @else
                  <input type="text" name="p_address1" id="p_address1" class="form-control" placeholder="例）岡山市北区1-2-3" value="{{ $patient->p_address1 }}" />
                  @endif
                  <span class="error-input">@if ($errors->first('p_address1')) ※{!! $errors->first('p_address1') !!} @endif</span>
                </div>
                <!-- p_address_2 -->
                <div class="mar-bottom">
                  @if ( old('p_address_2') )
                  <input type="text" name="p_address_2" id="p_address_2" class="form-control" placeholder="マンション名などをご記入ください" value="{{ old('p_address_2') }}" />
                  @else
                  <input type="text" name="p_address_2" id="p_address_2" class="form-control" placeholder="マンション名などをご記入ください" value="{{ $patient->p_address_2 }}" />
                  @endif
                  <span class="error-input">@if ($errors->first('p_address_2')) ※{!! $errors->first('p_address_2') !!} @endif</span>
                </div>
              </td>
            </tr>

            <!-- p_tel -->
            <tr>
              <td class="col-title"><label for="p_tel">TEL</label></td>
              <td>
                @if ( old('p_tel') )
                <input class="form-control" name="p_tel" value="{{ old('p_tel') }}" type="text" id="p_tel" />
                @else
                <input class="form-control" name="p_tel" value="{{ $patient->p_tel }}" type="text" id="p_tel" />
                @endif
                <span class="error-input">@if ($errors->first('p_tel')) ※{!! $errors->first('p_tel') !!} @endif</span>
              </td>
            </tr>

            <!-- p_fax -->
            <tr>
              <td class="col-title"><label for="p_fax">FAX</label></td>
              <td>
                @if ( old('p_fax') )
                <input class="form-control" name="p_fax" value="{{ old('p_fax') }}" type="text" id="p_fax" />
                @else
                <input class="form-control" name="p_fax" value="{{ $patient->p_fax }}" type="text" id="p_fax" />
                @endif
                <span class="error-input">@if ($errors->first('p_fax')) ※{!! $errors->first('p_fax') !!} @endif</span>
              </td>
            </tr>

            <!-- p_mobile -->
            <tr>
              <td class="col-title"><label for="p_mobile">携帯電話</label></td>
              <td>
                @if ( old('p_mobile') )
                <input class="form-control" name="p_mobile" value="{{ old('p_mobile') }}" type="text" id="p_mobile" />
                @else
                <input class="form-control" name="p_mobile" value="{{ $patient->p_mobile }}" type="text" id="p_mobile" />
                @endif
                <span class="error-input">@if ($errors->first('p_mobile')) ※{!! $errors->first('p_mobile') !!} @endif</span>
              </td>
            </tr>

            <!-- p_mobile_owner -->
            <tr>
              <td class="col-title"><label for="p_mobile_owner">携帯電話所有者</label></td>
              <td>
                <select name="p_mobile_owner" title="▼所有者" class="form-control" id="p_mobile_owner">
                  <option data-hidden="true"></option>
                  @if ( old('p_mobile_owner') )
                  <option value="1" @if(old('p_mobile_owner') == 1) selected="" @endif >本人</option>
                  <option value="2" @if(old('p_mobile_owner') == 2) selected="" @endif >父</option>
                  <option value="3" @if(old('p_mobile_owner') == 3) selected="" @endif >母</option>
                  <option value="4" @if(old('p_mobile_owner') == 4) selected="" @endif >祖父</option>
                  <option value="5" @if(old('p_mobile_owner') == 5) selected="" @endif >祖母</option>
                  @else
                  <option value="1" @if($patient->p_mobile_owner == 1) selected="" @endif >本人</option>
                  <option value="2" @if($patient->p_mobile_owner == 2) selected="" @endif >父</option>
                  <option value="3" @if($patient->p_mobile_owner == 3) selected="" @endif >母</option>
                  <option value="4" @if($patient->p_mobile_owner == 4) selected="" @endif >祖父</option>
                  <option value="5" @if($patient->p_mobile_owner == 5) selected="" @endif >祖母</option>
                  @endif
                </select>
                <span class="error-input">@if ($errors->first('p_mobile_owner')) ※{!! $errors->first('p_mobile_owner') !!} @endif</span>
              </td>
            </tr>

            <!-- p_email -->
            <tr>
              <td class="col-title"><label for="p_email">e-mail</label></td>
              <td>
                @if ( old('p_email') )
                <input class="form-control" placeholder="例）example@domain.co.jp" name="p_email" value="{{ old('p_email') }}" type="text" id="p_email" />
                @else
                <input class="form-control" placeholder="例）example@domain.co.jp" name="p_email" value="{{ $patient->p_email }}" type="text" id="p_email" />
                @endif
                <span class="error-input">@if ($errors->first('p_email')) ※{!! $errors->first('p_email') !!} @endif</span>
              </td>
            </tr>

            <!-- p_company -->
            <tr>
              <td class="col-title"><label for="p_company">学校・勤務先</label></td>
              <td>
                @if ( old('p_company') )
                <input class="form-control" placeholder="学校・勤務先をご記入ください" name="p_company" value="{{ old('p_company') }}" type="text" id="p_company" />
                @else
                <input class="form-control" placeholder="学校・勤務先をご記入ください" name="p_company" value="{{ $patient->p_company }}" type="text" id="p_company" />
                @endif
                <span class="error-input">@if ($errors->first('p_company')) ※{!! $errors->first('p_company') !!} @endif</span>
              </td>
            </tr>

            <!-- p_parent_name -->
            <tr>
              <td class="col-title"><label for="p_parent_name">保護者氏名</label></td>
              <td>
                @if ( old('p_parent_name') )
                <input class="form-control" name="p_parent_name" value="{{ old('p_parent_name') }}" type="text" id="p_parent_name" />
                @else
                <input class="form-control" name="p_parent_name" value="{{ $patient->p_parent_name }}" type="text" id="p_parent_name" />
                @endif
                <span class="error-input">@if ($errors->first('p_parent_name')) ※{!! $errors->first('p_parent_name') !!} @endif</span>
              </td>
            </tr>

            <!-- p_parent_company -->
            <tr>
              <td class="col-title"><label for="p_parent_company">保護者勤務先</label></td>
              <td>
                @if ( old('p_parent_company') )
                <input class="form-control" name="p_parent_company" value="{{ old('p_parent_company') }}" type="text" id="p_parent_company" />
                @else
                <input class="form-control" name="p_parent_company" value="{{ $patient->p_parent_company }}" type="text" id="p_parent_company" />
                @endif
                <span class="error-input">@if ($errors->first('p_parent_company')) ※{!! $errors->first('p_parent_company') !!} @endif</span>
              </td>
            </tr>

            <!-- p_parent_tel -->
            <tr>
              <td class="col-title"><label for="p_parent_tel">保護者連絡先</label></td>
              <td>
                @if ( old('p_parent_tel') )
                <input class="form-control" name="p_parent_tel" value="{{ old('p_parent_tel') }}" type="text" id="p_parent_tel" />
                @else
                <input class="form-control" name="p_parent_tel" value="{{ $patient->p_parent_tel }}" type="text" id="p_parent_tel" />
                @endif
                <span class="error-input">@if ($errors->first('p_parent_tel')) ※{!! $errors->first('p_parent_tel') !!} @endif</span>
              </td>
            </tr>

            <!-- p_parent_kind -->
            <tr>
              <td class="col-title"><label for="p_parent_kind">保護者連絡先種別</label></td>
              <td>
                <select name="p_parent_kind" class="form-control" title="▼所有者" id="p_parent_kind">
                  <option data-hidden="true"></option>
                  @if ( old('p_parent_kind') )
                  <option value="1" @if(old('p_parent_kind') == 1) selected="" @endif >自宅</option>
                  <option value="2" @if(old('p_parent_kind') == 2) selected="" @endif >父</option>
                  <option value="3" @if(old('p_parent_kind') == 3) selected="" @endif >母</option>
                  <option value="4" @if(old('p_parent_kind') == 4) selected="" @endif >祖父</option>
                  <option value="5" @if(old('p_parent_kind') == 5) selected="" @endif >祖母</option>
                  @else
                  <option value="1" @if($patient->p_parent_kind == 1) selected="" @endif >自宅</option>
                  <option value="2" @if($patient->p_parent_kind == 2) selected="" @endif >父</option>
                  <option value="3" @if($patient->p_parent_kind == 3) selected="" @endif >母</option>
                  <option value="4" @if($patient->p_parent_kind == 4) selected="" @endif >祖父</option>
                  <option value="5" @if($patient->p_parent_kind == 5) selected="" @endif >祖母</option>
                  @endif
                </select>
                <span class="error-input">@if ($errors->first('p_parent_kind')) ※{!! $errors->first('p_parent_kind') !!} @endif</span>
              </td>
            </tr>

            <!-- p_memo -->
            <tr>
              <td class="col-title"><label for="p_memo">備考</label></td>
              <td>
                @if ( old('p_memo') )
                <textarea class="form-control" rows="2" name="p_memo" id="p_memo">{{ old('p_memo') }}</textarea>
                @else
                <textarea class="form-control" rows="2" name="p_memo" id="p_memo">{{ $patient->p_memo }}</textarea>
                @endif
              </td>
            </tr>
          </table>
        </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="submit" name="" id="" value="保存する" class="btn btn-sm btn-page">
      </div>
    </div>

    <div class="row margin-bottom">
      <div class="col-md-12 text-center">
        <input type="button" onClick="location.href='{{ route('ortho.patients.index') }}'" value="登録済み患者一覧に戻る" class="btn btn-sm btn-page">
      </div>
    </div>
  </div>
</section>
{!! Form::close() !!}

@stop


@section('script')
  <script>
    $(document).ready(function(){
      $('#p_birthday').mask('0000/00/00');
    });
  </script>
@stop