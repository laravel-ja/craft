<?php

use Mockery as M;
use Laravel\Services\FilesSetupper;

class FilesSettupperTest extends TestCase
{

    function testSetPermission()
    {
        $testPath = "KODMC+LDPOSIOI9087F";
        $testLang = "oisfn";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $transMock = M::mock( 'Laravel\Services\Translator' );
        $removerMock = M::mock( 'Laravel\Services\CommentRemover' );

        $setterMock->shouldReceive( 'setModeToDirectories' )
            ->with( $testPath.'/app/storage', 0757 )
            ->once();
        $transMock->shouldReceive( 'get' )
            ->with( 'SetPermissions', $testLang );

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->once();

        $setupper = new FilesSetupper( $fileMock, $setterMock, $transMock, $removerMock );

        $setupper->setPermissions( $input, $output, $testPath );
    }

    function testRemoveComments()
    {
        $testPath = "oDPOpd08fk@sdg";
        $testLang = "9dpjcs";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $transMock = M::mock( 'Laravel\Services\Translator' );
        $removerMock = M::mock( 'Laravel\Services\CommentRemover' );

        $removerMock->shouldReceive( 'removeFromFiles' )
            ->with( $testPath.'/app/config' )
            ->once();
        $removerMock->shouldReceive( 'removeFromFiles' )
            ->with( $testPath.'/app/lang' )
            ->once();
        $removerMock->shouldReceive( 'remove' )
            ->with( $testPath.'/app/routes.php' )
            ->once();
        $removerMock->shouldReceive( 'remove' )
            ->with( $testPath.'/app/filters.php' )
            ->once();

        $transMock->shouldReceive( 'get' )
            ->with( 'RemoveComments', $testLang );

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->once();

        $setupper = new FilesSetupper( $fileMock, $setterMock, $transMock, $removerMock );

        $setupper->removeComments( $input, $output, $testPath );
    }

    function testMinifyFileSystem()
    {
        $testPath = "Kldhi8938ZX";
        $testLang = "899do2x";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $transMock = M::mock( 'Laravel\Services\Translator' );
        $removerMock = M::mock( 'Laravel\Services\CommentRemover' );

        $fileMock->shouldReceive( 'glob' )
            ->once()
            ->andReturn( ['Path1', 'Path2' ] );
        $fileMock->shouldReceive( 'delete' )
            ->twice();

        $removerMock->shouldReceive( 'removeFromFiles' )
            ->with( $testPath.'/app' )
            ->once();
        $removerMock->shouldReceive( 'removeFromFiles' )
            ->with( $testPath.'/bootstrap' )
            ->once();
        $removerMock->shouldReceive( 'removeFromFiles' )
            ->with( $testPath.'/public' )
            ->once();
        $removerMock->shouldReceive( 'remove' )
            ->with( $testPath.'/artisan' )
            ->once();
        $removerMock->shouldReceive( 'remove' )
            ->with( $testPath.'/server.php' )
            ->once();

        $transMock->shouldReceive( 'get' )
            ->with( 'Minified', $testLang );

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->once();

        $setupper = new FilesSetupper( $fileMock, $setterMock, $transMock, $removerMock );

        $setupper->minifyFileSystem( $input, $output, $testPath );
    }

    function testSetupApplicationWithSMOptions()
    {
        $testPath = "Vid830di'()9";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $transMock = M::mock( 'Laravel\Services\Translator' );
        $removerMock = M::mock( 'Laravel\Services\CommentRemover' );


        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'set-mode' )
            ->once()
            ->andReturn( true );
        $input->shouldReceive( 'getOption' )
            ->with( 'remove-comments' )
            ->once()
            ->andReturn( false );
        $input->shouldReceive( 'getOption' )
            ->with( 'minify' )
            ->once()
            ->andReturn( true );

        $output = M::mock();

        $setupper = M::mock( 'Laravel\Services\FilesSetupper',
                             [ $fileMock, $setterMock, $transMock, $removerMock ] )
            ->makePartial();

        $setupper->shouldReceive( 'setPermissions' )
            ->once();
        $setupper->shouldReceive( 'minifyFileSystem' )
            ->once();

        $setupper->setupApplication( $input, $output, $testPath );
    }

    function testSetupApplicationWithROptions()
    {
        $testPath = "Vid830di'()9";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $setterMock = M::mock( 'Laravel\Services\ModeSetter' );
        $transMock = M::mock( 'Laravel\Services\Translator' );
        $removerMock = M::mock( 'Laravel\Services\CommentRemover' );


        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'set-mode' )
            ->once()
            ->andReturn( false );
        $input->shouldReceive( 'getOption' )
            ->with( 'remove-comments' )
            ->once()
            ->andReturn( true );
        $input->shouldReceive( 'getOption' )
            ->with( 'minify' )
            ->once()
            ->andReturn( false );

        $output = M::mock();

        $setupper = M::mock( 'Laravel\Services\FilesSetupper',
                             [ $fileMock, $setterMock, $transMock, $removerMock ] )
            ->makePartial();

        $setupper->shouldReceive( 'removeComments' )
            ->once();

        $setupper->setupApplication( $input, $output, $testPath );
    }

}