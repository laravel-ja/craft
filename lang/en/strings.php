<?php

return array(
    // Default Zip file to fetch.
    'DefaultZip' => 'http://192.241.224.13/laravel-craft.zip',

    // Validation messages
    'ProjectDirectoryExist' => 'Application already exists!',

    // Notice Messages
    'Fetching' => 'Crafting application...',
    'SetPermissions' => 'Set 757 permisssion to files under app/storage.',
    'RemoveComments' => 'Remove all comments from files on config/lang directories.',
    'KeyGenerated' => 'Application key have been generated.',
    'ComplitedInstall' => 'Application ready! Build something amazing.',
    'Minified' => 'Removed all comments from PHP files without vendor. Also removed md files.',

    // Error Messages
    'FaildToFetch' => 'Faild to fetch ZIP file!',
    'FaildToGenerateKey' => 'Faild to generate new application key.',
    'DuplicateRemoveOptions' => 'Specify only --minify or --remove-comments.',
);
