<?php

return array(
    // Default Zip file to fetch.
    'DefaultZip' => 'http://192.241.224.13/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist'    => 'Application already exists!',
    'ProjectDirectoryNotExist' => 'Application does not exist!',
    'DuplicateRemoveOptions'   => 'Specify only --minify or --remove-comments.',

    // Notice Messages
    'Fetching'              => 'Crafting application...',
    'SetPermissions'        => 'Set 757 permisssion to files under app/storage.',
    'RemoveComments'        => 'Remove all comments from files on config/lang directories.',
    'KeyGenerated'          => 'Application key have been generated.',
    'ComplitedInstall'      => 'Application ready! Build something amazing.',
    'Minified'              => 'Removed all comments from PHP files without vendor. Also removed md files.',
    'StartSelfUpdate'       => 'Getting phar file...',
    'SelfUpdateComplited'   => 'Updated to latest vesion.',
    'ConfigSetSuccessfully' => 'Replaced config/lang files from .laravel.install.conf.php',
    'NoConfigSetFile'       => 'Setting file .laravel.install.conf.php does not exist. Cannot change configs.',

    // Error Messages
    'FailedToFetch'        => 'Failed to fetch ZIP file!',
    'FailedToGenerateKey'  => 'Failed to generate new application key.',
    'DownloadUpdataFailed' => 'Failed to download phar file.',
    'ConfigSetFailed'      => 'Failed to replace config/lang files from .laravel.install.conf.php',
);
