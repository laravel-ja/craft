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
    private $sentences = array();

    public function __construct( Filesystem $file )
    {
        $this->file = $file;
    }

    public function get( $key, $lang )
    {
        if( empty( $this->sentences ) )
        {
            $filePath = __DIR__.'/../../../lang/'.$lang.'/strings.php';

            if( !$this->file->exists( $filePath ) )
            {
                return $key;
            }

            $this->sentences = require $filePath;
        }

        if( key_exists( $key, $this->sentences ) )
        {
            return $this->sentences[$key];
        }

        return $key;
    }

}