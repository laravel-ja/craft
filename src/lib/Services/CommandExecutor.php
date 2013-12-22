<?php

namespace Laravel\Services;

class CommandExecutor
{
    private $output;

    public function execute( $command )
    {
        $this->output = '';

        $fd = array(
            1 => array( "pipe", "w" ),
            2 => array( "pipe", "w" ),
        );
        $pipes = array();

        $process = proc_open( $command, $fd, $pipes );

        $this->output = array();
        $this->errorOutput = array();

        if( is_resource( $process ) )
        {
            // Get stdin.
            while( !feof( $pipes[1] ) ) $this->output[] = fgets( $pipes[1] );
            fclose( $pipes[1] );

            // Delete last 'false' item.
            array_pop( $this->output );

            // Get stderr.
            while( !feof( $pipes[2] ) ) $this->errorOutput[] = fgets( $pipes[2] );
            fclose( $pipes[2] );

            // Delete last 'false' item.
            array_pop( $this->errorOutput );

            $result = proc_close( $process );
        }
        else
        {
            // todo : Need internationalize.
            $this->errorOutput[] = array( 'Faild to Execute : '.$command );
            return 1;
        }

        return $result;
    }

    public function getMessage()
    {
        return implode('', array_merge($this->output, $this->errorOutput));
    }

}