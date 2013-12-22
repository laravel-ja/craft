<?php

namespace Laravel\Services;

use ZipArchive;
use Illuminate\Filesystem\Filesystem;

class UnZipper
{
    /**
     *
     * @var ZipArchive
     */
    private $archive;

    public function __construct( Filesystem $file, ZipArchive $archive )
    {
        $this->file = $file;
        $this->archive = $archive;
    }

    function unzip( $zipFile, $directory )
    {
        // Create the application directory...
        $this->file->makeDirectory( $directory );

        // Unzip the Laravel archive into the application directory...
        if( $this->archive->open( $zipFile ) === true )
        {
            @$this->archive->extractTo( $directory );
            $this->archive->close();
        }
        else
        {
            $this->file->deleteDirectory( $directory );

            return 1;
        }

        return 0;
    }

}