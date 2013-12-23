<?php

namespace Laravel\Craft;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Laravel\Services\Container\Container;

class SelfupdateCommand extends BaseCommand
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

        $this->updater = $this->container->make( 'Laravel\Services\SelfUpdater' );
    }

    /**
     * Configure the console command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName( 'selfupdate' )
            ->setDescription( 'Update this command itself' )
            ->addOption( 'lang', 'l', InputOption::VALUE_OPTIONAL, 'Display language.', 'en');
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        return $this->updater->update( $input, $output ); 
    }

}