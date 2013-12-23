<?php

use Mockery as M;

class SelfUpdaterTest extends TestCase
{

    function testUpdate()
    {
        $testSelfCommandName = '1dDkix,vbol';
        $testDownloadFileName = 'Eef8(&&dflgfj';
        $testLang = 'AER6S8&sh';

        $downloaderMock = M::mock( 'Laravel\Services\FileDownloader' );
        $downloaderMock->shouldReceive( 'download' )
            ->with( 'http://kore1server.com/laravelja.phar' )
            ->andReturn( 0 );
        $downloaderMock->shouldReceive( 'getFilename' )
            ->andReturn( $testDownloadFileName );

        $transMock = M::mock( 'Laravel\Services\Translator' );
        $transMock->shouldReceive( 'get' )
            ->once()
            ->with( 'StartSelfUpdate', $testLang );
        $transMock->shouldReceive( 'get' )
            ->once()
            ->with( 'SelfUpdateComplited', $testLang );


        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'move' )
            ->with( $testDownloadFileName, $testSelfCommandName );

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->twice()
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->twice();


        $updater = M::mock( 'Laravel\Services\SelfUpdater',
                            [ $downloaderMock, $transMock, $fileMock ] )->makePartial();
        $updater->shouldReceive( 'getSelfName' )
            ->andReturn( $testSelfCommandName );

        $this->assertEquals( 0, $updater->update( $input, $output ) );
    }

    function testFailUpdate()
    {
        $testLang = 'c98dfl;g';

        $downloaderMock = M::mock( 'Laravel\Services\FileDownloader' );
        $downloaderMock->shouldReceive( 'download' )
            ->with( 'http://kore1server.com/laravelja.phar' )
            ->andReturn( 1 );

        $transMock = M::mock( 'Laravel\Services\Translator' );
        $transMock->shouldReceive( 'get' )
            ->once()
            ->with( 'StartSelfUpdate', $testLang );
        $transMock->shouldReceive( 'get' )
            ->once()
            ->with( 'DownloadUpdataFaild', $testLang );

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->twice()
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->twice();


        $updater = new Laravel\Services\SelfUpdater( $downloaderMock, $transMock,
                                                     $fileMock );

        $this->assertEquals( 1, $updater->update( $input, $output ) );
    }

}