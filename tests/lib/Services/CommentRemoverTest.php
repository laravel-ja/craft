<?php

use Mockery as M;
use Laravel\Services\CommentRemover;

class CommentRemoverTest extends TestCase
{

    function testRemoveComments()
    {
        $original = "\n\n\n<?php\n// Line1\n//Line2\n//Line3\nNormal1\nNormal2\n/* Block comment in a line */\n/* Comment in a few lines\n still comment \n End of comment */\nNromal3\n/** PHPDoc style comment */\nNormal4\n\n\n?>\n\n\n\n";
        $changeTo = "<?php\nNormal1\nNormal2\nNromal3\nNormal4\n?>\n";
        $filePath = "Test/File/Path";

        $fileMock = M::mock( 'Illuminate\Filesystem\Filesystem' );
        $fileMock->shouldReceive( 'get' )
            ->with( $filePath )
            ->andReturn( $original );
        $fileMock->shouldReceive( 'put' )
            ->with( $filePath, $changeTo );

        $remover = new CommentRemover( $fileMock );
        $remover->remove( $filePath );
    }

}