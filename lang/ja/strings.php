<?php

return array(
// Default Zip file to fetch.
    'DefaultZip'             => 'http://kore1server.com/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist'  => '指定されたディレクトリーは既に存在しています',

    // Notice Messages
    'Fetching'               => 'インストール中...',
    'SetPermissions'         => 'app/storage下のディレクトリーに757パーミッションを設定しました。',
    'RemoveComments'         => '設定ファイルと言語ファイルからコメントを取り除きました。',
    'KeyGenerated'           => 'アプリケーションキーを生成しました。',
    'ComplitedInstall'       => '準備ができました！すごいものを作って下さい！',
    'Minified'               => 'vendor下以外のPHPファイルからコメントを除去しました。Markdownファイルを削除しました。',
    
    // Error Messages
    'FaildToFetch'           => 'ZIPファイルが取得できません。',
    'FaildToGenerateKey'     => 'アプリケーションキーを生成できませんでした。',
    'DuplicateRemoveOptions' => '--minifyと--remove-commentsは一緒に指定できません。',
);
