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

    public function __construct( Filesystem $file, Translator $trans )
    {
        $this->file = $file;
        $this->trans = $trans;
    }

    public function validateNewCommand( $path, $arguments, $options, $lang )
    {
        // Check specified project dirctory is already exist.
        if( $this->file->isDirectory( $path ) )
        {
            return $this->trans->get( 'ProjectDirectoryExist', $lang );
        }

        $message = $this->validateCommon( $arguments, $options, $lang );

        return $message;
    }

    public function validateSetCommand( $path, $arguments, $options, $lang )
    {
        // Check specified project dirctory is exist.
        if( !$this->file->isDirectory( $path ) )
        {
            return $this->trans->get( 'ProjectDirectoryNotExist', $lang );
        }

        $message = $this->validateCommon( $arguments, $options, $lang );

        return $message;
    }

    public function validateCommon( $arguments, $options, $lang )
    {
        $args = array_merge( $arguments, $options );

        // Check specifed both --minify and --remove-comments option at once.
        if( $args['minify'] and $args['remove-comments'] )
        {
            return $this->trans->get( 'DuplicateRemoveOptions', $lang );
        }

        return '';
    }

}