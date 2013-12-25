<?php

namespace Laravel\Craft;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Laravel\Services\Container\Container;

class SetCommand extends BaseCommand
{
    /**
     *
     * @var Illuminate\Container\Container
     */
    private $container;

    public function __construct( $name = null )
    {
        parent::__construct( $name );

        $this->container = Container::get();

        $this->validator = $this->container->make( 'Laravel\Services\Validator' );
        $this->setupper = $this->container->make( 'Laravel\Services\FilesSetupper' );
        $this->configsetter = $this->container->make( 'Laravel\Services\ConfigSetter' );
        $this->trans = $this->container->make( 'Laravel\Services\Translator' );
    }

    /**
     * Configure the console command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName( 'set' )
            ->setDescription( 'Set up Laravel application' )
            ->addArgument( 'name', InputArgument::REQUIRED, 'The name of the application' )
            ->addOption( 'lang', 'l', InputOption::VALUE_OPTIONAL,
                         'Display language, also set Zip file if avilable.', 'en' )
            ->addOption( 'remove-comments', 'r', InputOption::VALUE_NONE,
                         'Remove comments from config and language files.', null )
            ->addOption( 'minify', 'm', InputOption::VALUE_NONE,
                         'Remove md files and comments from PHP files.' )
            ->addOption( 'set-mode', 's', InputOption::VALUE_NONE,
                         'Set 757 permission to files under app/storage.', null )
        ;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $directory = getcwd().'/'.rtrim( $input->getArgument( 'name' ), '/' );

        // Validate command line args.
        $errorMessage = $this->validator->validateSetCommand( $directory,
                                                              $input->getArguments(),
                                                              $input->getOptions(),
                                                              $input->getOption( 'lang' ) );

        if( $errorMessage != '' )
        {
            $output->writeln( '<error>'.$errorMessage.'</error>' );
            return 1;
        }

        // Remove many things.
        $this->setupper->setupApplication( $input, $output, $directory );

        // Set config / lang items from ~/.laravel.config.php
        $result = $this->configsetter->set( $directory );

        if( $result == -1 )
        {
            $output->writeln( '<comment>'.$this->trans->get( 'NoConfigSetFile',
                                                             $input->getOption( 'lang' ) ).'</comment>' );
        }
        elseif( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'ConfigSetFaild', $input->getOption( 'lang' ) ).'</error>' );

            return 1;
        }
        else
        {
            $output->writeln( '<comment>'.$this
                ->trans->get( 'ConfigSetSuccessfully', $input->getOption( 'lang' ) ).'</comment>' );
        }
        return 0;
    }

}