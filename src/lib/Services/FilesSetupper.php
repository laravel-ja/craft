<?php

namespace Laravel\Services;

use Illuminate\Filesystem\Filesystem;
use Laravel\Services\ModeSetter;
use Laravel\Services\Translator;
use Laravel\Services\CommentRemover;

class FilesSetupper
{

    public function __construct( Filesystem $file, ModeSetter $setter, Translator $trans,
                                 CommentRemover $remover )
    {
        $this->file = $file;
        $this->setter = $setter;
        $this->trans = $trans;
        $this->remover = $remover;
    }

    public function setupApplication( $input, $output, $directory )
    {
        // Set permissions to directories under app/storage directory.
        if( $input->getOption( 'set-mode' ) )
        {
            $this->setPermissions( $input, $output, $directory );
        }

        // Remove Comments.
        if( $input->getOption( 'remove-comments' ) )
        {
            $this->removeComments( $input, $output, $directory );
        }

        // Minify file system.
        if( $input->getOption( 'minify' ) )
        {
            $this->minifyFileSystem( $input, $output, $directory );
        }
    }

    public function setPermissions( $input, $output, $directory )
    {
        $this->setter->setModeToDirectories( $directory.'/app/storage', 0757 );

        $output->writeln( '<comment>'.$this
            ->trans->get( 'SetPermissions', $input->getOption( 'lang' ) ).'</comment>' );
    }

    public function removeComments( $input, $output, $directory )
    {

        $this->remover->removeFromFiles( $directory.'/app/config' );
        $this->remover->removeFromFiles( $directory.'/app/lang' );
        $this->remover->remove( $directory.'/app/routes.php' );
        $this->remover->remove( $directory.'/app/filters.php' );

        $output->writeln( '<comment>'.$this
            ->trans->get( 'RemoveComments', $input->getOption( 'lang' ) ).'</comment>' );
    }

    public function minifyFileSystem( $input, $output, $directory )
    {

        // Delete md files under installed root. (Not recursively)
        foreach( $this->file->glob( $directory.'/*.md' ) as $mdFile )
        {
            $this->file->delete( $mdFile );
        }

        // Delete comments. (Recursively)
        $this->remover->removeFromFiles( $directory.'/app' );
        $this->remover->removeFromFiles( $directory.'/bootstrap' );
        $this->remover->removeFromFiles( $directory.'/public' );
        $this->remover->remove( $directory.'/artisan' );
        $this->remover->remove( $directory.'/server.php' );

        $output->writeln( '<comment>'.$this
            ->trans->get( 'Minified', $input->getOption( 'lang' ) ).'</comment>' );
    }

}