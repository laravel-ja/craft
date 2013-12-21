<?php

namespace Laravel\Services;

use ZipArchive;
use Illuminate\Filesystem\Filesystem;

class UnZipper
{

    public function __construct( Filesystem $file )
    {
        $this->file = $file;
    }

    function unzip( $zipFile, $directory )
    {
        // Create the application directory...
        $this->file->makeDirectory( $directory );

        // Unzip the Laravel archive into the application directory...
        $archive = new ZipArchive;
        if( $archive->open( $zipFile ) === TRUE )
        {
            @$archive->extractTo( $directory );
            $archive->close();
        }
        else
        {
            $this->file->deleteDirectory( $directory );

            return 1;
        }

        return 0;
    }

}