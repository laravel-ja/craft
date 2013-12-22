<?php

use Mockery as M;

class ModeSetterTest extends TestCase
{

    function testSetModeToDirectories()
    {
        $testPath = "Buyd8421";
        $testMode = 0752;

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'directories' )
            ->with( $testPath )
            ->andReturn( ['TestDir1', 'TestDir2', 'TestDir3' ] );

        $setter = M::mock( 'Laravel\Services\ModeSetter', [ $fileMock ] )->makePartial();
        $setter->shouldReceive( 'setMode' )
            ->with( M::any(), $testMode )
            ->times( 3 );

        $setter->setModeToDirectories( $testPath, $testMode );
    }

}