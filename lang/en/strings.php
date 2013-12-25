<?php

return array(
    // Default Zip file to fetch.
    'DefaultZip' => 'http://192.241.224.13/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist'    => 'Application already exists!',
    'ProjectDirectoryNotExist' => 'Application dose not exists!',
    'DuplicateRemoveOptions'   => 'Specify only --minify or --remove-comments.',

    // Notice Messages
    'Fetching'              => 'Crafting application...',
    'SetPermissions'        => 'Set 757 permisssion to files under app/storage.',
    'RemoveComments'        => 'Remove all comments from files on config/lang directories.',
    'KeyGenerated'          => 'Application key have been generated.',
    'ComplitedInstall'      => 'Application ready! Build something amazing.',
    'Minified'              => 'Removed all comments from PHP files without vendor. Also removed md files.',
    'StartSelfUpdate'       => 'Getting phar file...',
    'SelfUpdateComplited'   => 'Replaced to latest vesion.',
    'ConfigSetSuccessfully' => 'Replaced config/lang files from .laravel.install.conf.php',
    'NoConfigSetFile'       => 'Setting file : .laravel.install.conf.php is not there. So not change configs.',

    // Error Messages
    'FaildToFetch'        => 'Faild to fetch ZIP file!',
    'FaildToGenerateKey'  => 'Faild to generate new application key.',
    'DownloadUpdataFaild' => 'Faild to download phar file.',
    'ConfigSetFaild'      => 'Faild to replace config/lang files from .laravel.install.conf.php',
);
