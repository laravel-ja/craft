<?php

use Laravel\Services\ConfigReplacer;

class ConfigReplacerTest extends TestCase
{

    function testReplaceConfigWithFirstLevelKey()
    {
        $content = "return array(\n"
            ."  'key1' => 'value1',\n"
            ."  'key2' => array(\n"
            ."    'key2-1' => 'value2-1',\n"
            ."    'key2-2' => 'vaule2-2',\n"
            ."   ),\n"
            .');\n';

        $target = ['key1' ];
        $replace = 'PvBT6$Dik5';
        $expected = str_replace( 'value1', $replace, $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

    function testReplaceConfigWithSecondLevelKey()
    {
        $content = "return array(\n"
            ."  'key1' => 'value1',\n"
            ."  'key2' => array(\n"
            ."    'key2-1' => 'value2-1',\n"
            ."    'key2-2' => 'vaule2-2',\n"
            ."   ),\n"
            .');\n';

        $target = ['key2', 'key2-1' ];
        $replace = 'Dd58Hbx06Q';
        $expected = str_replace( 'value2-1', $replace, $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

    function testReplaceConfigMultipleReplaceOnEmptyString()
    {
        $content = "return array(\n"
            ."  'connection' => array(\n"
            ."    'mysql' => array(\n"
            ."      'database' => 'database',\n"
            ."      'password' => '',\n"
            ."    ),\n"
            ."    'sqlite' => array(\n"
            ."      'database' => 'database',\n"
            ."      'password' => '',\n"
            ."    ),\n"
            ."  ),\n"
            .');\n';

        $target = ['password' ];
        $replace = 'Tr80ywQ2ox';
        $expected = str_replace( "''", "'".$replace."'", $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

    function testReplaceConfigMultipleReplaceWithString()
    {
        $content = "return array(\n"
            ."  'connection' => array(\n"
            ."    'mysql' => array(\n"
            ."      'database' => 'database',\n"
            ."      'password' => '',\n"
            ."    ),\n"
            ."    'sqlite' => array(\n"
            ."      'database' => 'database',\n"
            ."      'password' => '',\n"
            ."    ),\n"
            ."  ),\n"
            .');\n';

        $target = ['database' ];
        $replace = 'Iy(Bdf#5d';
        $expected = str_replace( "=> 'database'", "=> '".$replace."'", $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

    function testReplaceConfigForNumericItems()
    {
        $content = "return array(\n"
            ."  'connection' => array(\n"
            ."    'mysql' => array(\n"
            ."      'retry' => 0,\n"
            ."      'autoconnect' => false,\n"
            ."    ),\n"
             ."  ),\n"
            .');\n';

        $target = ['retry'];
        $replace = '7843';
        $expected = str_replace( "0", $replace, $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

function testReplaceConfigForBooleanItems()
    {
        $content = "return array(\n"
            ."  'connection' => array(\n"
            ."    'mysql' => array(\n"
            ."      'retry' => 0,\n"
            ."      'autoconnect' => false,\n"
            ."    ),\n"
             ."  ),\n"
            .');\n';

        $target = ['autoconnect'];
        $replace = 'true';
        $expected = str_replace( "false", $replace, $content );

        $replacer = new ConfigReplacer;

        $this->assertEquals( $expected,
                             $replacer->replaceConfig( $target, $replace, $content ) );
    }

}