<?php

return array(
    // Default Zip file to fetch.
    'DefaultZip' => 'http://kore1server.com/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist'    => '指定されたディレクトリーは既に存在しています。',
    'ProjectDirectoryNotExist' => '指定されたディレクトリーが存在していません。',
    'DuplicateRemoveOptions'   => '--minifyと--remove-commentsは一緒に指定できません。',

    // Notice Messages
    'Fetching'            => 'インストール中...',
    'SetPermissions'      => 'app/storage下のディレクトリーに757パーミッションを設定しました。',
    'RemoveComments'      => '設定ファイルと言語ファイルからコメントを取り除きました。',
    'KeyGenerated'        => 'アプリケーションキーを生成しました。',
    'ComplitedInstall'    => '準備ができました！すごいものを作って下さい！',
    'Minified'            => 'vendor下以外のPHPファイルからコメントを除去しました。Markdownファイルを削除しました。',
    'StartSelfUpdate'     => '取得中...',
    'SelfUpdateComplited' => '最新版へ置き換えました。',

    // Error Messages
    'FaildToFetch'        => 'ZIPファイルが取得できません。',
    'FaildToGenerateKey'  => 'アプリケーションキーを生成できませんでした。',
    'DownloadUpdataFaild' => 'pharファイルの取得ができませんでした。',
);
