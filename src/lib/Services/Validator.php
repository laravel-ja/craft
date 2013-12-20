<?php

namespace Laravel\Services;

use Laravel\Services\Translator;
use Illuminate\Filesystem\Filesystem;

class Validator
{
    /**
     * Laravel Filesystem class
     *
     * @var Filesystem
     */
    private $file;

    public function __construct( $file = null, $trans = null )
    {
        $this->file = $file ? : new Filesystem;
        $this->trans = $trans ? : new Translator;
    }

    public function getErrorMessage( $path, $arguments, $options, $lang )
    {
        $args = array_merge( $arguments, $options );

        // Check specified project dirctory is already exist.
        if( $this->file->isDirectory( $path ) )
        {
            return $this->trans->get( 'ProjectDirectoryExist', $lang );
        }

        // Check specifed both --minify and --remove-comments option at once.
        if( $args['minify'] and $args['remove-comments'] )
        {
            return $this->trans->get( 'DuplicateRemoveOptions', $lang );
        }

        return '';
    }

}