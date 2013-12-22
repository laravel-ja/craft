<?php

use Laravel\Services\CommandExecutor;

class CommandExecutorTest extends TestCase
{

    function testExecuteNormalTerminateCommand()
    {
        $executor = new CommandExecutor( );

        $this->assertEquals( 0,
                             $executor->execute( __DIR__.'/Stubs/CommandExecutorStubReturn0.sh' ) );
        $this->assertEquals( "Test String 038e9-3#8\nMgiso 89dk aodp dko()\n",
                             $executor->getMessage() );
    }

    function testExecuteNormalTerminateCommandWithoutMessage()
    {
        $executor = new CommandExecutor( );

        $this->assertEquals( 0,
                             $executor->execute( __DIR__.'/Stubs/CommandExecutorStubReturn0WithoutMessage.sh' ) );
        $this->assertEquals( "", $executor->getMessage() );
    }

    function testExecuteAbnormalTerminate()
    {
        $executor = new CommandExecutor( );

        $this->assertEquals( 1,
                             $executor->execute( __DIR__.'/Stubs/CommandExecutorStubReturn1.sh' ) );
        $this->assertEquals( "Ikdpo 0(7d0==~) Boodll,c\n", $executor->getMessage() );
    }

}