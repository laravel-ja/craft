<?php

namespace Laravel\Services;

class ConfigReplacer
{

    public function replaceConfig( $keys, $itemValue, $configString )
    {
        // Generate reglex to find config item.
        $reglex = '/(';

        foreach( $keys as $key )
        {
            $escapedKey = preg_quote( $key );
            $reglex .= ".*['\"]${escapedKey}['\"]\s*=>";
        }

        $reglex .= "\s*)(\S+?)(\s*,)/sU";
        $matches = [ ];

        if( preg_match( $reglex, $configString, $matches ) )
        {
            $bracket = [ ];
            if( preg_match( "/^(['\"]).*(['\"])$/", $matches[2], $bracket ) )
            {
                return preg_replace( $reglex,
                                     '${1}'.$bracket[1].$itemValue.$bracket[2].'${3}',
                                     $configString );
            }
            return preg_replace( $reglex, '${1}'.$itemValue.'${3}', $configString );
        }
        return $configString;
    }

}