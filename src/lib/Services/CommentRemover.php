<?php

namespace Laravel\Services;

use Illuminate\Filesystem\Filesystem;

class CommentRemover
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

    public function removeFromFiles( $directory )
    {
        foreach( $this->globAll( $directory, '*.php' ) as $file )
        {
            $this->remove( $file );
        }
    }

    public function remove( $filePath )
    {
        $content = $this->file->get( $filePath );

        // Delete line comments.
        $noLineComment = preg_replace( '#^\s*//.*$#m', "", $content );

        // Delete block comments.
        $noBlockComment = preg_replace( '#/\*.+\*/#sU', '', $noLineComment );

        // Delete Space lines.
        $noSpaceLine = preg_replace( '/^\s*\n/m', '', $noBlockComment );

        // Put an empty line to the tail.
        $addedEmptyLine = rtrim( $noSpaceLine, "\n" )."\n";

        $this->file->put( $filePath, $addedEmptyLine );
    }

    private function globAll( $path, $pattern )
    {
        $paths = $this->file->glob( rtrim( $path, '/' ).'/*',
                                           GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT );
        $files = $this->file->glob( rtrim( $path, '/' ).'/'.$pattern );

        foreach( $paths as $path )
        {
            $files = array_merge( $files, $this->globAll( $path, $pattern ) );
        }

        return $files;
    }

}