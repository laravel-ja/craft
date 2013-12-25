<?php

namespace Laravel\Services;

use Illuminate\Filesystem\Filesystem;
use Laravel\Services\ConfigReplacer;
use Laravel\Services\Translator;
use Illuminate\Filesystem\FileNotFoundException;

class ConfigSetter
{
    /**
     * Laravel Filesystem class
     *
     * @var Filesystem
     */
    private $file;

    public function __construct( Filesystem $file, ConfigReplacer $replacer,
                                 Translator $trans )
    {
        $this->file = $file;
        $this->replacer = $replacer;
        $this->trans = $trans;
    }

    public function set( $directory )
    {
        $configs = $this->getConfigSetFile();

        if( empty( $configs ) )
        {
            return -1;
        }

        $this->faildFileName = '';

        foreach( $configs as $file => $config )
        {
            if( !$this->setConfig( $file, $config, $directory ) )
            {
                $this->faildFileName = $file;

                return 1;
            }
        }

        return 0;
    }

    public function setConfig( $file, $configs, $directory )
    {
        try
        {
            $content = $this->file->get( $directory.'/'.ltrim( $file, '/' ) );
        }
        catch( FileNotFoundException $e )
        {
            return false;
        }

        foreach( $configs as $keys => $value )
        {
            $content = $this
                ->replacer->replaceConfig( explode( '.', $keys ), $value, $content );
        }

        try
        {
            $this->file->put( $directory.'/'.ltrim( $file, '/' ), $content );
        }
        catch( FileNotFoundException $e )
        {
            return false;
        }

        return true;
    }

    public function getConfigSetFile()
    {
        $configFile = $this->getHomeDirectory().'/'.'.laravel.install.conf.php';

        if( $this->file->isFile( $configFile ) )
        {
            $conf = require $configFile;

            return $conf;
        }

        return array();
    }

    public function getHomeDirectory()
    {
        if( ($homeDir = getenv( 'HOMEDRIVE' ).getenv( 'HOMEPATH' )) != '' )
        {
            return $homeDir;
        }

        return getenv( 'HOME' );
    }

    public function getFaildFileName()
    {
        return $this->faildFileName;
    }

}