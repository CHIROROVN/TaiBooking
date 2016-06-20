<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modal Enterprise
    |--------------------------------------------------------------------------
    */
    "error_ent_name_required"							=> "法人名を入力してください。",
    "error_ent_login_id_required"                       => "ログインIDを入力してください。",
    "error_ent_login_id_exist"                          => "ログインIDがすでに存在しています。",
    "error_ent_passwd_required"                         => "パスワードを入力してください。",
    "error_ent_cus_required"                            => "顧客を選択してください。",

    /*
    |--------------------------------------------------------------------------
    | Validation Customer
    |--------------------------------------------------------------------------
    */
    'error_cus_code_required'							=> '学校コードを入力してください。',
    'error_cus_code_unique'								=> 'その学校コードは既に使用されています。',
    'error_cus_name_required'							=> '学校名を入力してください。',
    'error_cus_name_kana_regex'							=> 'ひらがなで入力してください。',		/*	common	*/
    'error_cus_name_kana_required'						=> '学校名(かな)を入力してください。',
    'error_cus_title_required'							=> '見出しを入力してください。',
    'error_cus_old_name_required'						=> 'Please enter customer old name.',	/* NULL is OK	*/
    'error_cus_pay_required'							=> '有料・無料区分を選択してください。',
    'error_cus_pay_must_num'							=> 'Customer pay must be numeric.',		/* ???	Maybe not need	*/
    'error_cus_kind_required'							=> '学校区分を選択してください。',
    'error_cus_owner_required'							=> '親法人を選択してください。',		/* NULL"なし" is OK	*/
    'error_cus_sex_required'							=> 'Please choose customer sex.',		/* No choose is OK	*/
    'error_cus_login_required'							=> 'ログインIDを入力してください。',
    'error_cus_passwd_required'							=> 'パスワードを入力してください。',
    'error_cus_staff1_belong_required'					=> '担当者①の所属を入力してください。',
    'error_cus_staff1_name_required'					=> '担当者①の名前を入力してください。',
    'error_cus_staff1_name_kana_required'				=> '担当者①の名前(かな)を入力してください。',
    'error_cus_staff1_name_kana_must_kana'				=> 'ひらがなで入力してください。',		/*	common	*/
    'error_cus_staff1_phone_required'					=> '担当者①のTELを入力してください。',
    'error_cus_staff1_fax_required'						=> '担当者①のFAXを入力してください。',
    'error_cus_staff1_email_required'					=> '担当者①のメールアドレスを入力してください。',
    'error_cus_staff1_email_format'						=> '担当者①のメールアドレスを正しく入力してください。',
    'error_cus_staff2_name_kana_must_kana'				=> 'ひらがなで入力してください。',
    'error_cus_staff2_email_format'						=> '担当者②のメールアドレスを正しく入力してください。',
    'error_cus_staff3_name_kana_must_kana'				=> 'ひらがなで入力してください。',
    'error_cus_staff3_email_format'						=> '担当者③のメールアドレスを正しく入力してください。',

    
    
    /*
    |--------------------------------------------------------------------------
    | Model Baitai
    |--------------------------------------------------------------------------
    */
    'error_baitai_code_required'						=> '媒体コードを入力してください。',
    'error_baitai_name_required'						=> '媒体名を入力してください。',
    'error_baitai_kind_required'						=> '性別を選択してください。',
    // 'error_baitai_year_required'						=> '発行年を入力してください。',
    'error_baitai_code_numeric'							=> '発行年は半角数字で入力してください。',


    /*
    |--------------------------------------------------------------------------
    | Model Bunya
    |--------------------------------------------------------------------------
    */
    'error_bunya_code_required'							=> '分野コードを入力してください。',
    'error_bunya_code_unique'							=> 'その分野コードは既に使用されています。',
    'error_bunya_name_required'							=> '分野名を入力してください。',
    'error_bunya_kind_required'							=> '種類を選択してください。',
    'error_bunya_class_required'						=> '区分を選択してください。',


    /*
    |--------------------------------------------------------------------------
    | Model Campaign
    |--------------------------------------------------------------------------
    */
    'error_campaign_name_required'						=> 'キャンペーン名を入力してください。',
    'error_baitai_id_required'							=> 'プレゼント名を入力してください。',
    'error_presentlist_id_required'						=> '媒体名を入力してください。',


    /*
    |--------------------------------------------------------------------------
    | Model Group Pamphlet
    |--------------------------------------------------------------------------
    */
    'error_gpamph_number_required'						=> '一括資料請求番号を入力してください。',
    'error_pamph_id_required'							=> '一括資料請求番号を入力してください。',	/*	???	*/


    /*
    |--------------------------------------------------------------------------
    | Model Pamphlet
    |--------------------------------------------------------------------------
    */
    'error_pamph_number_required'						=> '資料請求番号を入力してください。',
    'error_pamph_name_required'							=> '資料名を入力してください。',
    'error_pamph_kind_required'							=> '種別を選択してください。',
    'error_pamph_class_required'						=> '使用区分を選択してください。',
    //'error_pamph_cus_id_required'						=> '学校名を選択してください。',
    'error_pamph_send_required'							=> '発送の有無を選択してください。',
    //'error_pamph_bunya_id_required'						=> '分野を選択してください。',
    'error_pamph_area_required'							=> '都道府県 または エリア を選択してください。',
    'error_pamph_pref_required'							=> '都道府県 または エリア を選択してください。',
    'error_pamph_sex_required'							=> '対象を選択してください。',


    /*
    |--------------------------------------------------------------------------
    | Model Present
    |--------------------------------------------------------------------------
    */
    'error_present_code_required'						=> 'プレゼントコードを入力してください。',
    'error_present_name_required'						=> 'プレゼント名を入力してください。',


    /*
    |--------------------------------------------------------------------------
    | Model User
    |--------------------------------------------------------------------------
    */
    'error_u_name_required'								=> '名前を入力してください。',
    'error_u_login_required'							=> 'ユーザーIDを入力してください。',
    'error_u_passwd_required'							=> 'パスワードを入力してください。',
    'error_u_passwd_min'								=> 'パスワードは6文字以上で指定してください。',
    'error_u_belong_required'							=> '所属を入力してください。',
    'error_u_power_required'							=> '権限を選択してください。',
    'error_u_login_unique'								=> 'そのログインIDは既に使用されています。',
    'error_currpasswd_required'							=> '現在のパスワードを入力してください。',
    'error_newpasswd_required'							=> '新しいパスワードを入力してください。',
    'error_newpasswd_alpha_num'							=> 'パスワードは英数字を指定してください。',
    'error_newpasswd_min'								=> 'パスワードは6文字以上で指定してください。',
    'error_confnewpasswd_same'							=> '新しいパスワードが一致しません。',


    /*
    |--------------------------------------------------------------------------
    | Model University
    |--------------------------------------------------------------------------
    */
    'error_univ_code_required'                             => '大学コードを入力してください。',
    'error_univ_code_unique'                               => 'そのCODEは既に使用されています。',
    'error_univ_name_required'                             => '大学名を入力してください。',
    'error_univ_name_kana_required'                        => '大学名かなを入力してください。',
    'error_univ_name_kana_regex'                           => 'ひらがなで入力してください。',
    'error_univ_pref_id_required'                          => '都道府県を選択してください。',

    /*
    |--------------------------------------------------------------------------
    | Student Contact
    |--------------------------------------------------------------------------
    */
    

];