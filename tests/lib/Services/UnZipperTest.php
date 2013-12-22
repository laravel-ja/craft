<?php

use Mockery as M;
use Laravel\Services\UnZipper;

class UnZipperTest extends TestCase
{

    function testUnzip()
    {
        $testPath = "Buyd8421";
        $testZipPath = "ZPOD9ID";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'makeDirectory' )
        ->once()
        ->with( $testPath );

        $archiveMock = M::mock( 'ZipArchive' );
        $archiveMock->shouldReceive( 'open' )
            ->with( $testZipPath )
            ->once()
            ->andReturn( true );
        $archiveMock->shouldReceive( 'extractTo' )
            ->with( $testPath )
            ->once();
        $archiveMock->shouldReceive( 'close' )
            ->once();

        $unzipper = new UnZipper( $fileMock, $archiveMock );

        $this->assertEquals( 0, $unzipper->unzip( $testZipPath, $testPath ) );
    }

    function testFailUnzip()
    {
        $testPath = "PGJdiiow8";
        $testZipPath = "eioOId3256";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'makeDirectory' )
            ->once()
            ->with( $testPath );
        $fileMock->shouldReceive( 'deleteDirectory' )
            ->once();

        $archiveMock = M::mock( 'ZipArchive' );
        $archiveMock->shouldReceive( 'open' )
            ->with( $testZipPath )
            ->once()
            ->andReturn( false );

        $unzipper = new UnZipper( $fileMock, $archiveMock );

        $this->assertEquals( 1, $unzipper->unzip( $testZipPath, $testPath ) );
    }

}