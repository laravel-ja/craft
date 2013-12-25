<?php

namespace Laravel\Craft;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Laravel\Services\Container\Container;

class NewCommand extends BaseCommand
{

    public function __construct( $name = null )
    {
        parent::__construct( $name );

        $this->container = Container::get();

        $this->trans = $this->container->make( 'Laravel\Services\Translator' );
        $this->validator = $this->container->make( 'Laravel\Services\Validator' );
        $this->setupper = $this->container->make( 'Laravel\Services\FilesSetupper' );
        $this->generator = $this->container->make( 'Laravel\Services\KeyGenerator' );
        $this->downloader = $this->container->make( 'Laravel\Services\FileDownloader' );
        $this->unzipper = $this->container->make( 'Laravel\Services\UnZipper' );
        $this->configsetter = $this->container->make( 'Laravel\Services\ConfigSetter' );
    }

    /**
     * Configure the console command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName( 'new' )
            ->setDescription( 'Create a new Laravel application' )
            ->addArgument( 'name', InputArgument::REQUIRED, 'The name of the application' )
            ->addOption( 'lang', 'l', InputOption::VALUE_OPTIONAL,
                         'Display language, also set Zip file if avilable.', 'en' )
            ->addOption( 'remove-comments', 'r', InputOption::VALUE_NONE,
                         'Remove comments from config and language files.', null )
            ->addOption( 'minify', 'm', InputOption::VALUE_NONE,
                         'Remove md files and comments from PHP files.' )
            ->addOption( 'from', 'f', InputOption::VALUE_OPTIONAL,
                         'Specify Zip file to fech.', null )
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

        // Get language code, default is 'en'.
        $lang = $input->getOption( 'lang' );

        // Validate command line args.
        $errorMessage = $this->validator->validateNewCommand( $directory,
                                                              $input->getArguments(),
                                                              $input->getOptions(), $lang );
        if( $errorMessage != '' )
        {
            $output->writeln( '<error>'.$errorMessage.'</error>' );
            return 1;
        }

        // Display start download message.a
        $output->writeln( '<info>'.$this
            ->trans->get( 'Fetching', $lang ).'</info>' );


        // Detarmin which craft zip file will get.
        if( is_null( $input->getOption( 'from' ) ) )
        {
            if( $this->trans->get( 'DefaultZip', $lang ) == '' )
            {
                $craftZip = 'http://192.241.224.13/laravel-craft.zip';
            }
            else
            {
                $craftZip = $this->trans->get( 'DefaultZip', $lang );
            }
        }
        else
        {
            $craftZip = $input->getOption( 'from' );
        }

        // Download the latest Laravel archive...
        $result = $this->downloader->download( $craftZip );

        if( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'FaildToFetch', $lang ).'</error>' );

            return 1;
        }

        // Unzip the Laravel archive into the application directory...
        $result = $this->unzipper->unzip( $this->downloader->getFilename(), $directory );

        if( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'FaildToOpenZipFie', $lang ).'</error>' );

            return 1;
        }

        // Close download.
        $this->downloader->terminate();

        // Remove many things.
        $this->setupper->setupApplication( $input, $output, $directory );

        // Generate application key.
        if( $this->generator->generate( $input, $output, $directory ) != 0 )
        {
            return 1;
        }

        // Set config / lang items from ~/.laravel.install.conf.php
        $result = $this->configsetter->set( $directory );

        if( $result == -1 )
        {
            $output->writeln( '<comment>'.$this->trans->get( 'NoConfigSetFile',
                                                             $input->getOption( 'lang' ) ).'</comment>' );
        }
        elseif( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'ConfigSetFaild', $lang ).'</error>' );

            return 1;
        }
        else
        {
            $output->writeln( '<comment>'.$this
                ->trans->get( 'ConfigSetSuccessfully', $lang ).'</comment>' );
        }


        $output->writeln( '<comment>'.$this
            ->trans->get( 'ComplitedInstall', $lang ).'</comment>' );

        return 0;
    }

}