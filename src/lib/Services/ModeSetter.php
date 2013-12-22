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

    public function __construct( Filesystem $file )
    {
        $this->file = $file;
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