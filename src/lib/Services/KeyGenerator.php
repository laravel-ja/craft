<?php

namespace Laravel\Services;

use Laravel\Services\CommandExecutor;
use Laravel\Services\Translator;

class KeyGenerator
{

    public function __construct( CommandExecutor $executor, Translator $trans )
    {
        $this->executor = $executor;
        $this->trans = $trans;
    }

    public function generate( $input, $output, $directory )
    {
        // Execute key generation command.
        $result = $this->executor
            ->execute( 'php '.$directory.'/artisan key:generate' );

        if( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'FaildToGenerateKey', $input->getOption( 'lang' ) ).'</error>' );
            $output->writeln( $this->executor->getMessage() );

            return 1;
        }

        $output->writeln( '<comment>'.$this
            ->trans->get( 'KeyGenerated', $input->getOption( 'lang' ) ).'</comment>' );

        return 0;
    }

}