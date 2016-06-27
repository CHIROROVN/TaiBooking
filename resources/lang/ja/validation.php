<?php

return [

    /*
    |--------------------------------------------------------------------------
    | login
    |--------------------------------------------------------------------------
    */
    'error_u_login_required'                            => '※ログインIDを入力してください。',
    'error_password_required'                           => '※パスワードを入力してください。',

    /*
    |--------------------------------------------------------------------------
    | change password
    |--------------------------------------------------------------------------
    */
    // 'error_password_required'                               => '※パスワードを入力してください。',
    'error_new_password_required'                           => 'パスワードを入力してください。',//※パスワードを入力してください。
    'error_confim_new_password_required'                    => '新しいパスワードを入力してください。',
    'error_confim_new_password_same'                        => '新しいパスワードが一致しません。',

    /*
    |--------------------------------------------------------------------------
    | Model Area
    |--------------------------------------------------------------------------
    */
    'error_area_name_required'                           => '地域名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Belong
    |--------------------------------------------------------------------------
    */
    'error_belong_name_required'                           => '所属名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Clinic
    |--------------------------------------------------------------------------
    */
    'error_area_name_required'                              => '医院名を入力してください。',
    'error_clinic_name_yomi_required'                       => '医院名よみを入力してください。',
    'error_clinic_name_yomi_regex'                          => 'ひらがなで入力してください。',
    'error_clinic_display_name_required'                    => '（表示用）医院名を入力してください。',
    'error_clinic_zip3_required'                            => '郵便番号を入力してください。',
    'error_clinic_zip4_required'                            => '郵便番号を入力してください。',
    'error_clinic_address1_required'                        => '住所を入力してください。',
    'error_clinic_address2_required'                        => '住所（ビル名等）を入力してください。',
    'error_clinic_ownername_required'                       => '院長名を入力してください。',
    'error_clinic_tel_required'                             => 'TELを入力してください。',
    'error_clinic_email_required'                           => 'E-mailを入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Inspection
    |--------------------------------------------------------------------------
    */
    'error_inspection_name_required'                           => '検査名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Insurance
    |--------------------------------------------------------------------------
    */
    'error_insurance_name_required'                           => '保険診療名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model User
    |--------------------------------------------------------------------------
    */
    'error_u_name_required'                             => '氏名を入力してください。',
    'error_u_name_yomi_required'                        => '氏名よみを入力してください。',
    'error_u_name_yomi_regex'                           => 'ひらがなで入力してください。',
    'error_u_name_display_required'                     => '（表示用）氏名を入力してください。',
    'error_u_login_required'                            => 'ログインIDを入力してください。',
    'error_u_login_unique'                              => 'そのログインIDは既に使用されています。',
    'error_password_required'                           => 'パスワードを入力してください。',
    
        /*
    |--------------------------------------------------------------------------
    | Validation Services
    |--------------------------------------------------------------------------
    */
    'error_service_name_required'                          => 'サービス名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Validation Equipment
    |--------------------------------------------------------------------------
    */
    'error_equipment_name_required'                       => '機器を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Xray
    |--------------------------------------------------------------------------
    */
    'error_p_id_required'                                   => '撮影日を選択してください。',
    'error_xray_date_required'                              => '撮影場所を選択してください。',
    'error_xray_place_required'                             => '撮影者を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Patient
    |--------------------------------------------------------------------------
    */
    'error_p_no_required'                                   => 'カルテNoを入力してください。',
    'error_p_dr_required'                                   => '担当を選択してください。',
    'error_p_hos_memo_required'                             => 'HOSを入力してください。',
    'error_p_hos_required'                                  => 'HOSを選択してください。',
    'error_p_name_required'                                 => '氏名を入力してください。',
    'error_p_name_kana_required'                            => '氏名（よみ）を入力してください。',
    'error_p_name_kana_regex'                               => 'ひらがなで入力してください。',
    'error_p_sex_required'                                  => '性別を選択してください。',
    'error_p_birthday_required'                             => '生年月日を入力してください。',
    'error_p_family_dr_required'                            => 'かかりつけを入力してください。',
    'error_p_introduce_required'                            => '紹介先を入力してください。',
    'error_p_start_required'                                => '治療開始を入力してください。',
    'error_p_start2_required'                               => '2期開始を入力してください。',
    'error_p_place_required'                                => '撮影場所を選択してください。',
    'error_p_xray_required'                                 => 'xrayを入力してください。',
    'error_p_clinic_memo_required'                          => '医院関連メモを入力してください。',
    'error_p_personal_memo_required'                        => '個人情報メモを入力してください。',
    'error_p_used_required'                                 => '使用装置を入力してください。',
    'error_p_payment_required'                              => '入金状況を入力してください。',
    'error_p_amount_required'                               => '契約金を入力してください。',
    'error_p_zip_required'                                  => '住所を入力してください。',
    'error_p_pref_required'                                 => '都道府県を選択してください。',
    'error_p_address1_required'                             => 'Address1を入力してください。',
    'error_p_address_2_required'                            => 'Address2を入力してください。',
    'error_p_tel_required'                                  => 'TELを入力してください。',
    'error_p_fax_required'                                  => 'FAXを入力してください。',
    'error_p_mobile_required'                               => '携帯電話を入力してください。',
    'error_p_mobile_owner_required'                         => '携帯電話所有者を選択してください。',
    'error_p_email_required'                                => 'e-mailを入力してください。',
    'error_p_email_email'                                   => 'e-mailのメールアドレスを正しく入力してください。',
    'error_p_company_required'                              => '学校・勤務先を入力してください。',
    'error_p_parent_name_required'                          => '保護者氏名を入力してください。',
    'error_p_parent_company_required'                       => '保護者勤務先を入力してください。',
    'error_p_parent_tel_required'                           => '保護者連絡先を入力してください。',
    'error_p_parent_kind_required'                          => '保護者連絡先種別を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Brother
    |--------------------------------------------------------------------------
    */
    'error_p_relation_id_required'                          => '対象者の名前を入力してください。',
    'error_brother_relation_required'                       => '関係を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Communication
    |--------------------------------------------------------------------------
    */
    'error_com_title_required'                          => 'タイトルを入力してください。',
    'error_com_contents_required'                       => '詳細を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Treatment1
    |--------------------------------------------------------------------------
    */
    'error_treatment_name_required'                          => '治療の名前を入力してください。',
    'error_treatment_name_time'                              => '処置時間を選択してください。',
];