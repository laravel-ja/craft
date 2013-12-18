<?php

namespace Laravel\Services;

use Illuminate\Filesystem\Filesystem;

class Translator
{
    /**
     * Laravel Filesystem class.
     *
     * @var Filesystem;
     */
    private $file;

    public function __construct( $file = null )
    {
        $this->file = $file ? : new Filesystem;
    }

    public function get( $key, $lang, $replace = array() )
    {
        $filePath = __DIR__.'/../../../lang/'.$lang.'/strings.php';

        if( !$this->file->exists( $filePath ) )
        {
            return $key;
        }

        $strings = require $filePath;

        if( key_exists( $key, $strings ) )
        {
            return $strings[$key];
        }

        return $key;
    }

}