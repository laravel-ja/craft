<?php

use Mockery as M;
use Laravel\Services\KeyGenerator;

class KeyGeneratorTest extends TestCase
{

    function testGenerate()
    {
        $testPath = "vL+O#)DI";
        $testLang = "Ghi836do";

        $executorMock = M::mock( 'Laravel\Services\CommandExecutor' );
        $transMock = M::mock( 'Laravel\Services\Translator' );

        $executorMock->shouldReceive( 'execute' )
            ->with( 'php '.$testPath.'/artisan key:generate' )
            ->once()
            ->andReturn( 0 );

        $transMock->shouldReceive( 'get' )
            ->with( 'KeyGenerated', $testLang )
            ->once();

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->once();

        $generator = new KeyGenerator( $executorMock, $transMock );

        $this->assertEquals( 0, $generator->generate( $input, $output, $testPath ) );
    }

    function testFailGenerate()
    {
        $testPath = "Ko08d7s";
        $testLang = "20d99z";

        $executorMock = M::mock( 'Laravel\Services\CommandExecutor' );
        $transMock = M::mock( 'Laravel\Services\Translator' );

        $executorMock->shouldReceive( 'execute' )
            ->with( 'php '.$testPath.'/artisan key:generate' )
            ->once()
            ->andReturn( 1 );
        $executorMock->shouldReceive( 'getMessage' )
            ->once();

        $transMock->shouldReceive( 'get' )
            ->with( 'FaildToGenerateKey', $testLang )
            ->once();

        $input = M::mock();
        $input->shouldReceive( 'getOption' )
            ->with( 'lang' )
            ->andReturn( $testLang );

        $output = M::mock();
        $output->shouldReceive( 'writeln' )
            ->twice();

        $generator = new KeyGenerator( $executorMock, $transMock );

        $this->assertEquals( 1, $generator->generate( $input, $output, $testPath ) );
    }

}