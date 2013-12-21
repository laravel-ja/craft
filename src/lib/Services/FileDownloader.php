<?php

namespace Laravel\Services;

use Guzzle\Http\Client as HttpClient;
use Illuminate\Filesystem\Filesystem;
use Laravel\Services\ModeSetter;

class FileDownloader
{
    private $filename;

    public function __construct( Filesystem $file, ModeSetter $setter )
    {
        $this->file = $file;
        $this->setter = $setter;

        $this->generateTemporaryName();
    }

    public function download( $fetchFile )
    {
        // Download the latest Laravel archive...
        $client = new HttpClient;
        try
        {
            $client->get( $fetchFile )->setResponseBody( $this->filename )->send();
        }
        catch( Exception $e )
        {
            // Delete the Laravel archive...
            $this->terminate();

            return 1;
        }

        return 0;
    }

    public function terminate()
    {
        $this->setter->setMode( $this->filename, 0777 );
        $this->file->delete( $this->filename );
    }

    public function getFilename()
    {
        return $this->filename;
    }

    private function generateTemporaryName()
    {
        // Creaqte the ZIP file name...
        $this->filename = getcwd().'/laravel_'.md5( time().uniqid() ).'.zip';
    }

}