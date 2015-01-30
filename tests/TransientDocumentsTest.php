<?php

use Echosign\TransientDocuments;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class TransientDocumentsTest extends PHPUnit_Framework_TestCase
{
    public function testCreateDocument()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        $docId = md5( time() );

        $json = [ 'transientDocumentId' => $docId ];

        $stream = Stream::factory( json_encode( $json ) );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $td = new TransientDocuments( '12345', $transport );

        // create a crap sample file.
        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $response = $td->create( $file );

        $this->assertInstanceOf( 'Echosign\Responses\TransientDocumentResponse', $response );

        $this->assertEquals( $docId, $response->getTransientDocumentId() );
    }
}