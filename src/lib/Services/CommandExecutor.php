<?php

namespace Laravel\Services;

class CommandExecutor
{
    private $output;

    public function execute( $command )
    {
        $this->output = '';

        exec( $command, $output, $result );

        if( $result != 0 )
        {
            $this->output = $output;

            return $result;
        }

        return 0;
    }

    public function getMessage()
    {
        return $this->output;
    }

}