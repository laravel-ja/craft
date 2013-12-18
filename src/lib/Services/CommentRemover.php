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

    public function removeFromFiles( $directoryPath )
    {
        $files = $this->file->allFiles( $directoryPath );

        foreach( $files as $file )
        {
            $this->remove( $file );
        }
    }

    public function remove( $filePath )
    {
        $content = $this->file->get( $filePath );

        // Delete line comments.
        $noLineComment = preg_replace( '/^\/\/.*/', '', $content );

        // Delete block comments.
        $noBlockComment = preg_replace( '/\/\*.+\*\//sU', '', $noLineComment );

        // Delete PHPDoc format comments.
        $noDocComment = preg_replace( '/\/\*\*.+\*\//sU', '', $noBlockComment );

        // Delete Space lines.
        $noSpaceLine = preg_replace( '/\n\s*\n/', "\n", $noDocComment );

        $this->file->put( $filePath, $noSpaceLine );
    }

}