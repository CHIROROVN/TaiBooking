<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Modal delete confirm
    |--------------------------------------------------------------------------
    */
    'modal_header_delete'				                   => '削除の確認',
    'modal_content_delete'				                   => '削除してよろしいですか？',
    'modal_btn_delete'					                   => '削除する(確認済)',
    'modal_btn_cancel'					                   => '削除しない',
    'modal_header_popup_edit_clinic_booking_template'      => '複数治療枠選択',
    'modal_btn_ok'                                         => '保存する',

    /*
    |--------------------------------------------------------------------------
    | Message notice success or danger: common
    |--------------------------------------------------------------------------
    */
    'message_regist_success'                => '登録が完了しました。',
    'message_regist_danger'                 => '登録できませんでした。',
    'message_edit_success'                  => '編集箇所を保存しました。',
    'message_edit_danger'                   => '編集箇所を保存できませんでした。',
    'message_delete_success'                => '削除しました。',
    'message_delete_danger'                 => '削除できませんでした。',

    'message_time_danger'                   => '予約可能な予約枠より長い予約時間の予約のため登録できませんでした。',

    /*
    |--------------------------------------------------------------------------
    | Permission: access to function, controller
    / if don't have permisstion, return to menu page
    |--------------------------------------------------------------------------
    */
    'message_permission_no_access'          => 'アクセス権がありません。',

    /*
    |--------------------------------------------------------------------------
    | Message No Data Correspond
    |--------------------------------------------------------------------------
    */
    'no_data_correspond'                => '該当するデータがありません。',

    /*
    |--------------------------------------------------------------------------
    | Message user login fail and login
    |--------------------------------------------------------------------------
    */
    'message_login_fail'                => 'ログインIDまたはパスワードが間違ってます。',

    /*
    |--------------------------------------------------------------------------
    | Message user change password
    |--------------------------------------------------------------------------
    */
    'message_change_password_wrong'                => '現在のパスワードが違います。',


    /*
    |--------------------------------------------------------------------------
    | Text in page booking template set
    |--------------------------------------------------------------------------
    */
    'text_not_yet'                      => '未登録',


    /*
    |--------------------------------------------------------------------------
    | Text popup select doctor, hygienist
    |--------------------------------------------------------------------------
    */
    'popup_header'                      => 'ポップアップ',
    'select_reset'                      => 'リセットする',


    /*
    |--------------------------------------------------------------------------
    | Text set some boxs
    |--------------------------------------------------------------------------
    */
    'set_some_box'                      => '複数治療枠選択',
    'set'                               => 'セットする',
    'start_time'                        => '開始時刻',
    'end_time'                          => '終了時刻'
];
