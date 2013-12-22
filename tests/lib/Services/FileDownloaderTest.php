<?php

use Mockery as M;
use Laravel\Services\FileDownloader;

class FileDownloaderTest extends TestCase
{

    function testDownload()
    {
        $fileName = 'O-@(90(DNPVjp3#IJ';

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $clientMock = M::mock( 'Guzzle\Http\Client' );

        // Guzzle\Http\Client mothod does not return it's instance. So, make dummy.
        $returnMock = M::mock();

        $clientMock->shouldReceive( 'get' )
            ->with( $fileName )
            ->once()
            ->andReturn( $returnMock );

        $returnMock->shouldReceive( 'setResponseBody' )
            ->once()
            ->andReturn( $returnMock );
        $returnMock->shouldReceive( 'send' )
            ->once();

        $downloader = new FileDownloader( $fileMock, $setterMock, $clientMock );

        $this->assertEquals( 0, $downloader->download( $fileName ) );
    }

    function testFailDownload()
    {
        $fileName = 'Eiolkcl;DL+KFL';

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $clientMock = M::mock( 'Guzzle\Http\Client' );

        $clientMock->shouldReceive( 'get' )
            ->with( $fileName )
            ->once()
            ->andThrow( 'BadMethodCallException' );

        $setterMock->shouldReceive( 'setMode' )
            ->once();
        $fileMock->shouldReceive( 'delete' )
            ->once();

        $downloader = new FileDownloader( $fileMock, $setterMock, $clientMock );

        $this->assertEquals( 1, $downloader->download( $fileName ) );
    }

    function testTerminate()
    {
        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $clientMock = M::mock( 'Guzzle\Http\Client' );

        $setterMock->shouldReceive( 'setMode' )
            ->with( M::any(), 0777 )
            ->once();
        $fileMock->shouldReceive( 'delete' )
            ->with( M::any() )
            ->once();

        $downloader = new FileDownloader( $fileMock, $setterMock, $clientMock );

        $downloader->terminate();
    }

}