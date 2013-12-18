<?php

namespace Laravel\Services;

use Illuminate\Filesystem\Filesystem;

class ModeSetter
{
    /**
     * Laravel Filesytem class.
     *
     * @var Filesystem
     */
    private $file;

    public function __construct( $file = null )
    {
        $this->file = $file ? : new Filesystem;
    }

    public function setModeToDirectories( $directoryPath, $mode )
    {
        $direcories = $this->file->directories( $directoryPath );

        foreach( $direcories as $directory )
        {
            $this->setMode( $directory, $mode );
        }
    }

    public function setMode( $path, $mode )
    {
        chmod( $path, $mode );
    }

}