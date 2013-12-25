<?php

return array(
    // Default Zip file to fetch.
    'DefaultZip' => 'http://laravel4.qanxen.info/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist'    => '指定されたディレクトリーは既に存在しています。',
    'ProjectDirectoryNotExist' => '指定されたディレクトリーが存在していません。',
    'DuplicateRemoveOptions'   => '--minifyと--remove-commentsは一緒に指定できません。',

    // Notice Messages
    'Fetching'              => 'インストール中...',
    'SetPermissions'        => 'app/storage下のディレクトリーに757パーミッションを設定しました。',
    'RemoveComments'        => '設定ファイルと言語ファイルからコメントを取り除きました。',
    'KeyGenerated'          => 'アプリケーションキーを生成しました。',
    'ComplitedInstall'      => '準備ができました！すごいものを作って下さい！',
    'Minified'              => 'vendor下以外のPHPファイルからコメントを除去しました。Markdownファイルを削除しました。',
    'StartSelfUpdate'       => '取得中...',
    'SelfUpdateComplited'   => '最新版へ置き換えました。',
    'ConfigSetSuccessfully' => 'config/langファイルを.laravel.install.conf.phpファイルの設定に従い置き換えました。',
    'NoConfigSetFile'       => 'ホームディレクトリーに.laravel.install.conf.phpファイルがありません。config/langの設定は行いません。',
    
    // Error Messages
    'FaildToFetch'        => 'ZIPファイルが取得できません。',
    'FaildToGenerateKey'  => 'アプリケーションキーを生成できませんでした。',
    'DownloadUpdataFaild' => 'pharファイルの取得ができませんでした。',
    'ConfigSetFaild'      => 'config/langファイルの置き換えに失敗しました。.laravel.install.conf.phpファイルを確認して下さい。',
);
