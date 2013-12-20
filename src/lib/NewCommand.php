<?php

namespace Laravel\Craft;

use ZipArchive;
use Guzzle\Http\Client as HttpClient;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Illuminate\Filesystem\Filesystem;
use Laravel\Services\Validator;
use Laravel\Services\Translator;
use Laravel\Services\CommentRemover;
use Laravel\Services\ModeSetter;
use Laravel\Services\CommandExecutor;

class NewCommand extends BaseCommand
{
    /**
     *
     * @var Filesystem
     */
    private $file;

    public function __construct( $name = null, $file = null, $validator = null,
                                 $trans = null, $remover = null, $setter = null,
                                 $executor = null )
    {
        parent::__construct( $name );

        $this->file = $file ? : new Filesystem;
        $this->validator = $validator ? : new Validator;
        $this->trans = $trans ? : new Translator;
        $this->remover = $remover ? : new CommentRemover;
        $this->setter = $setter ? : new ModeSetter;
        $this->executor = $executor ? : new CommandExecutor;
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
                         'Set 757 permission to files under app/storage.', null );
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
        if( ($errorMessage = $this
            ->validator->getErrorMessage(
            $directory, $input->getArguments(), $input->getOptions(), $lang )) != '' )
        {
            $output->writeln( '<error>'.$errorMessage.'</error>' );
            return 1;
        }

        $output->writeln( '<info>'.$this
            ->trans->get( 'Fetching', $lang ).'</info>' );

        // Creaqte the ZIP file name...
        $zipFile = getcwd().'/laravel_'.md5( time().uniqid() ).'.zip';

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
        $client = new HttpClient;
        try
        {
            $client->get( $craftZip )->setResponseBody( $zipFile )->send();
        }
        catch( Exception $e )
        {
            // Delete the Laravel archive...
            $this->setter->setMode( $zipFile, 0777 );
            $this->file->delete( $zipFile );

            $output->writeln( '<error>'.$this
                ->trans->get( 'FaildToFetch' ).'</error>' );
            return 1;
        }

        // Create the application directory...
        $this->file->makeDirectory( $directory );

        // Unzip the Laravel archive into the application directory...
        $archive = new ZipArchive;
        if( $archive->open( $zipFile ) === TRUE )
        {
            @$archive->extractTo( $directory );
            $archive->close();
        }
        else
        {
            $output->writeln( $this->trans->get( 'FaildToOpenZipFie', $lang ) );
            $this->file->deleteDirectory( $directory );
        }

        // Delete the Laravel archive...
        $this->setter->setMode( $zipFile, 0777 );
        $this->file->delete( $zipFile );

        // Set permissions to directories under app/storage directory.
        if( $input->getOption( 'set-mode' ) )
        {
            $this->setter->setModeToDirectories( $directory.'/app/storage', 0757 );

            $output->writeln( '<comment>'.$this
                ->trans->get( 'SetPermissions', $lang ).'</comment>' );
        }

        // Remove Comments.
        if( $input->getOption( 'remove-comments' ) )
        {
            $this->remover->removeFromFiles( $directory.'/app/config' );
            $this->remover->removeFromFiles( $directory.'/app/lang' );
            $this->remover->remove( $directory.'/app/routes.php' );
            $this->remover->remove( $directory.'/app/filters.php' );

            $output->writeln( '<comment>'.$this
                ->trans->get( 'RemoveComments', $lang ).'</comment>' );
        }

        // Minify file system.
        if( $input->getOption( 'minify' ) )
        {
            // Delete md files.
            foreach( $this->file->glob( $directory.'/*.md' ) as $mdFile )
            {
                $this->file->delete( $mdFile );
            }

            // Delete comments.
            $this->remover->removeFromFiles( $directory.'/app' );
            $this->remover->removeFromFiles( $directory.'/bootstrap' );
            $this->remover->removeFromFiles( $directory.'/public' );
            $this->remover->remove( $directory.'/artisan' );
            $this->remover->remove( $directory.'/server.php' );

            $output->writeln( '<comment>'.$this
                ->trans->get( 'Minified', $lang ).'</comment>' );
       }

        // Execute key generation command.
        $result = $this->executor
            ->execute( 'php '.$directory.'/artisan key:generate' );


        if( $result != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'FaildToGenerateKey', $lang ).'</error>' );
            $output->writeln( $this->executor->getMessage() );

            return 1;
        }

        $output->writeln( '<comment>'.$this
            ->trans->get( 'KeyGenerated', $lang ).'</comment>' );


        $output->writeln( '<comment>'.$this
            ->trans->get( 'ComplitedInstall', $lang ).'</comment>' );
    }

}