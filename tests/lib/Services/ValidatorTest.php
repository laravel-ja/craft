<?php

use Mockery as M;
use Laravel\Services\Validator;

class ValidatorTest extends TestCase
{

    function testValidateNewCommand()
    {
        $testPath = "+)(D&7d676";
        $expected = "ASOD0D~6%d";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'isDirectory' )
            ->with( $testPath )
            ->andReturn( false );

        $transMock = M::mock( 'Laravel\Services\Translator' );

        $validator = M::mock( 'Laravel\Services\Validator', [$fileMock, $transMock ] )
            ->makePartial();
        $validator->shouldReceive( 'validateCommon' )
            ->once()
            ->andReturn( $expected );

        $this->assertEquals( $expected,
                             $validator->validateNewCommand( $testPath, [ ], [ ], 'lang' ) );
    }

    function testFailValidateNewCommand()
    {
        $testPath = "Bdk211d";
        $testLang = "YDUgoi";
        $expected = "POD0-99e";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'isDirectory' )
            ->with( $testPath )
            ->andReturn( true );

        $transMock = M::mock( 'Laravel\Services\Translator' );
        $transMock->shouldReceive( 'get' )
            ->with( 'ProjectDirectoryExist', $testLang )
            ->andReturn( $expected );

        $validator = new Validator( $fileMock, $transMock );

        $this->assertEquals( $expected,
                             $validator->validateNewCommand( $testPath, [ ], [ ],
                                                             $testLang ) );
    }

    function testValidateSetCommand()
    {
        $testPath = "WQDWKDI8";
        $expected = "P@flsoj";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'isDirectory' )
            ->with( $testPath )
            ->andReturn( true );

        $transMock = M::mock( 'Laravel\Services\Translator' );

        $validator = M::mock( 'Laravel\Services\Validator', [$fileMock, $transMock ] )
            ->makePartial();
        $validator->shouldReceive( 'validateCommon' )
            ->once()
            ->andReturn( $expected );

        $this->assertEquals( $expected,
                             $validator->validateSetCommand( $testPath, [ ], [ ], 'lang' ) );
    }

    function testFailValidateSetCommand()
    {
        $testPath = "Ni8d7e3k";
        $testLang = "xc9af8";
        $expected = "+*doihd";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'isDirectory' )
            ->with( $testPath )
            ->andReturn( false );

        $transMock = M::mock( 'Laravel\Services\Translator' );
        $transMock->shouldReceive( 'get' )
            ->with( 'ProjectDirectoryNotExist', $testLang )
            ->andReturn( $expected );

        $validator = new Validator( $fileMock, $transMock );

        $this->assertEquals( $expected,
                             $validator->validateSetCommand( $testPath, [ ], [ ],
                                                             $testLang ) );
    }

    function testFailValidateCommonWithMinifyOption()
    {
        $testOptions = ['minify' => true, 'remove-comments' => false ];

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );

        $transMock = M::mock( 'Laravel\Services\Translator' );

        $validator = new Validator( $fileMock, $transMock );

        $this->assertEquals( '', $validator->validateCommon( [ ], $testOptions, 'lang' ) );
    }

    function testFailValidateCommonWithRemoveCommentOption()
    {
        $testOptions = ['minify' => false, 'remove-comments' => true ];

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );

        $transMock = M::mock( 'Laravel\Services\Translator' );

        $validator = new Validator( $fileMock, $transMock );

        $this->assertEquals( '', $validator->validateCommon( [ ], $testOptions, 'lang' ) );
    }

    function testFailValidateCommonWithMinifyAndRemoveCommentOption()
    {
        $testOptions = ['minify' => true, 'remove-comments' => true ];
        $testLang = "Gfj9&d99";
        $expected = "I98d&#dk09";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );

        $transMock = M::mock( 'Laravel\Services\Translator' );
        $transMock->shouldReceive( 'get' )
            ->with( 'DuplicateRemoveOptions', $testLang )
            ->once()
            ->andReturn( $expected );

        $validator = new Validator( $fileMock, $transMock );

        $this->assertEquals( $expected,
                             $validator->validateCommon( [ ], $testOptions, $testLang ) );
    }

}