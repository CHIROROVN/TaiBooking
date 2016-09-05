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
    'error_area_name_required'                             => '地域名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Belong
    |--------------------------------------------------------------------------
    */
    'error_belong_name_required'                           => '所属名を入力してください。',
    'error_belong_kind_required'                           => '所属区分を選択してください。',

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
    'error_clinic_ownername_required'                       => '院長名を入力してください。',
    'error_clinic_tel_required'                             => 'TELを入力してください。',
    'error_clinic_email_required'                           => 'E-mailを入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Inspection
    |--------------------------------------------------------------------------
    */
    'error_inspection_name_required'                          => '検査名を入力してください。',

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
    'error_p_no_unique'                                     => 'このカルテNoはすでにシステムに存在しています。',
    'error_p_no_required'                                   => 'カルテNoを入力してください。',
    'error_p_dr_required'                                   => '担当を選択してください。',
    'error_p_hos_memo_required'                             => 'HOSを入力してください。',
    'error_p_hos_required'                                  => 'HOSを選択してください。',
    'error_p_name_f_required'                               => '氏名を入力してください。',
    'error_p_name_g_required'                               => '氏名を入力してください。',
    'error_p_name_f_kana_required'                          => '氏名（よみ）を入力してください。',
    'error_p_name_g_kana_required'                          => '氏名（よみ）を入力してください。',
    'error_p_name_f_kana_regex'                             => 'ひらがなで入力してください。',
    'error_p_name_g_kana_regex'                             => 'ひらがなで入力してください。',
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

    /*
    |--------------------------------------------------------------------------
    | Model 3dct
    |--------------------------------------------------------------------------
    */
    'error_ct_date_required'                                => '撮影日を選択してください。',
    'error_ct_u_id_required'                                => '撮影者を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Facility
    |--------------------------------------------------------------------------
    */
    'error_facility_name_required'                          => '施設名を入力してください。',
    'error_facility_kind_required'                          => '治療の種類を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Interview
    |--------------------------------------------------------------------------
    */
    'error_q1_1_sei_required'                               => 'せいを入力してください。',
    'error_q1_1_sei_regex'                                  => 'ひらがなで入力してください。',
    'error_q1_1_mei_required'                               => 'めいを入力してください。',
    'error_q1_1_mei_regex'                                  => 'ひらがなで入力してください。',
    'error_q1_2_sei_required'                               => '姓を入力してください。',
    'error_q1_2_mei_required'                               => '名を入力してください。',
    'error_q1_6_required'                                   => '電話番号を入力してください。',
    'error_q1_9_required'                                   => 'メールアドレスを入力してください。',
    'error_q1_9_email'                                      => 'メールアドレスのメールアドレスを正しく入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model ServiceTemplate
    |--------------------------------------------------------------------------
    */
    'error_service_facility_1_required'                     => '治療-1を選択してください。',
    'error_service_facility_2_required'                     => '治療-2を選択してください。',
    'error_service_facility_3_required'                     => '治療-3を選択してください。',
    'error_service_facility_4_required'                     => '治療-4を選択してください。',
    'error_service_facility_5_required'                     => '治療-5を選択してください。',

    'error_service_time_1_required'                         => '時間-1を選択してください。',
    'error_service_time_2_required'                         => '時間-2を選択してください。',
    'error_service_time_3_required'                         => '時間-3を選択してください。',
    'error_service_time_4_required'                         => '時間-4を選択してください。',
    'error_service_time_5_required'                         => '時間-5を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model BookingTemplate
    |--------------------------------------------------------------------------
    */
    'error_mbt_name_required'                               => '雛形名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Ddr
    |--------------------------------------------------------------------------
    */
    'error_ddr_start_date_required'                         => '開始日時を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Result
    |--------------------------------------------------------------------------
    */
    'error_result_result_date_required'                         => '日付を選択してください。',
    'error_result_result_start_time_required'                   => '時間を選択してください。',
    'error_result_clinic_id_required'                           => '医院を選択してください。',
    'error_result_doctor_id_required'                           => 'ドクターを選択してください。',
    'error_result_service_1_required'                           => '実施業務-1を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Memo
    |--------------------------------------------------------------------------
    */
    'error_memo_date_required'                                  => '内容を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Forum
    |--------------------------------------------------------------------------
    */
    'error_forum_title_required'                                => 'タイトルを入力してください。',
    'error_forum_contents_required'                             => '内容を入力してください。',
    'error_forum_file_path_max'                                 => 'ファイルは 15MB 未満にしてください。',
    'error_forum_file_path_mimes'                               => 'ファイル形式は .jpeg, .bmp, .png, .gif, .pdf, .doc, .docx, .dxf, .xlsx のいずれかにしてください。',
    'error_forum_file_name_required'                            => 'ファイル名を入力してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Booking
    |--------------------------------------------------------------------------
    */
    'error_service_1_required'                               => '業務内容-1を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Model Hiyarihatto
    |--------------------------------------------------------------------------
    */
    'error_year_required'                               => '年を入力してください。',
    'error_month_required'                              => '月を入力してください。',
    'error_day_required'                                => '日を入力してください。',
    'error_hour_required'                               => '時間を入力してください。',
    'error_place_required'                              => '場所を入力してください。',
    'error_age_required'                                => '数値でなければなりません。',
    'error_discoverer_required'                         => '発見者か当事者か選択してください。',
    'error_dentist_required'                            => '職種を選択してください。',
    'error_hygienist_required'                          => '職種を選択してください。',
    'error_technician_required'                         => '職種を選択してください。',
    'error_nurse_required'                              => '職種を選択してください。',
    'error_secretary_required'                          => '職種を選択してください。',
    'error_other_input_job_required'                    => '職種を選択してください。',

    'error_scene_required'                              => '発生した場面を入力してください。',
    'error_contents_required'                           => '内容を入力してください。',

    'error_party_required'                              => '発生要因を入力してください。',
    'error_confirm_required'                            => '発生要因を入力してください。',
    'error_observation_required'                        => '発生要因を入力してください。',
    'error_judgment_required'                           => '発生要因を入力してください。',
    'error_knowledge_required'                          => '発生要因を入力してください。',
    'error_technology_required'                         => '発生要因を入力してください。',
    'error_corners_required'                            => '発生要因を入力してください。',
    'error_occurrence_required'                         => 'Please enter occurrence.',
    'error_affect_env_required'                         => 'Please enter 当事者に影響を及ぼした環境等.',
    'error_contact_required'                            => 'Please enter 報告連絡の不備 .',
    'error_transmission_required'                       => 'Please enter 指示伝達の不備.',
    'error_manual_required'                             => 'Please enter マニュアルの不備.',
    'error_cooperation_required'                        => 'Please enter スタッフ間の連携不適切.',
    'error_mistake_required'                            => 'Please enter 記録ミス.',
    'error_misreading_required'                         => 'Please enter 読み間違い.',
    'error_affect_text_required'                        => 'Please enter 記録ミス.',

    'error_medical_device_required'                     => 'Please enter 医療用具・機器・薬剤・設備等.',
    'error_defect_required'                             => 'Please enter 欠陥不良品',
    'error_fault_required'                              => 'Please enter 故障 .',
    'error_handle_required'                             => 'Please enter 扱いが難しい.',
    'error_placement_required'                          => 'Please enter 配置が悪い.',
    'error_quantity_required'                           => 'Please enter 数量不足.',
    'error_inappropriate_required'                      => 'Please enter 管理不適切 .',
    'error_malfunction_required'                        => 'Please enter 機器誤作動 .',
    'error_medical_error_required'                      => 'Please enter 処方投薬ミス .',
    'error_medical_text_required'                       => 'Please enter medical other.',
    
    'error_education_required'                          => 'Please enter 教育・訓練や説明・対応.',
    'error_edu_training_required'                       => 'Please enter 教育・練習不足　.',
    'error_explan_patient_required'                     => 'Please enter 患者様への説明不足 .',
    'error_understand_patient_required'                 => 'Please enter 患者様の理解不十分.',
    'error_edu_text_required'                           => 'Please enter education other.',

    'error_other_chk_required'                          => 'Please enter その他.',
    'error_other_required'                              => 'Please enter other.',

    'error_impact_required'                             => '影響を入力してください。',
    'error_impact_affect_required'                      => '影響のあり、なしを選択してください。',

];
