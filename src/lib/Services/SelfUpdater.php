<?php

namespace Laravel\Services;

use Laravel\Services\FileDownloader;
use Laravel\Services\Translator;
use Illuminate\Filesystem\Filesystem;

class SelfUpdater
{

    public function __construct( FileDownloader $downloader, Translator $trans,
                                 Filesystem $file )
    {
        $this->downloader = $downloader;
        $this->trans = $trans;
        $this->file = $file;
    }

    public function update( $input, $output )
    {
        $output->writeln( '<comment>'.$this
            ->trans->get( 'StartSelfUpdate', $input->getOption( 'lang' ) ).'</comment>' );

        // Feach phar file
        if( $this->downloader->download( 'http://laravel4.qanxen.info/laravelja.phar' ) != 0 )
        {
            $output->writeln( '<error>'.$this
                ->trans->get( 'DownloadUpdataFaild', $input->getOption( 'lang' ) ).'</error>' );

            return 1;
        }

        $this->file->move( $this->downloader->getFilename(), $this->getSelfName() );

        $output->writeln( '<comment>'.$this
            ->trans->get( 'SelfUpdateComplited', $input->getOption( 'lang' ) ).'</comment>' );

        return 0;
    }

    public function getSelfName()
    {
        return $_SERVER['PHP_SELF'];
    }

}