<?php

use Echosign\Widgets;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class WidgetsTest extends PHPUnit_Framework_TestCase
{
    public function testListAll()
    {

    }

    public function testDownloadDocuments()
    {
        $documentId = substr( md5( time() ), 8).'.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        /*
        HTTP/1.1 200 OK
        Date: Fri, 30 Jan 2015 00:59:05 GMT
        Server: Apache/2.4.3 (Win32) OpenSSL/1.0.1c PHP/5.4.7
        Last-Modified: Fri, 21 Nov 2014 20:57:09 GMT
        ETag: "2265-50864b0336560"
        Accept-Ranges: bytes
        Content-Length: 8805
        Keep-Alive: timeout=5, max=100
        Connection: Keep-Alive
        Content-Type: application/pdf
        */

        $sampleFile = dirname(__FILE__ ).DIRECTORY_SEPARATOR.'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock([
            new Response(200, [
                'Content-Type'=>'application/pdf',
                'Content-Length'=>filesize( $sampleFile ),
            ], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $agreement = new Widgets( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->downloadDocument('123kf','234df', $file);

        $this->assertTrue( $response );
    }

    public function testAuditTrail()
    {
        $documentId = substr( md5( time() ), 8).'.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        /*
        HTTP/1.1 200 OK
        Date: Fri, 30 Jan 2015 00:59:05 GMT
        Server: Apache/2.4.3 (Win32) OpenSSL/1.0.1c PHP/5.4.7
        Last-Modified: Fri, 21 Nov 2014 20:57:09 GMT
        ETag: "2265-50864b0336560"
        Accept-Ranges: bytes
        Content-Length: 8805
        Keep-Alive: timeout=5, max=100
        Connection: Keep-Alive
        Content-Type: application/pdf
        */

        $sampleFile = dirname(__FILE__ ).DIRECTORY_SEPARATOR.'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock([
            new Response(200, [
                'Content-Type'=>'application/pdf',
                'Content-Length'=>filesize( $sampleFile ),
            ], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $agreement = new Widgets( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->auditTrail('123kf', $file);

        $this->assertTrue( $response );
    }

    public function testCombinedDocument()
    {
        $documentId = substr( md5( time() ), 8).'.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        /*
        HTTP/1.1 200 OK
        Date: Fri, 30 Jan 2015 00:59:05 GMT
        Server: Apache/2.4.3 (Win32) OpenSSL/1.0.1c PHP/5.4.7
        Last-Modified: Fri, 21 Nov 2014 20:57:09 GMT
        ETag: "2265-50864b0336560"
        Accept-Ranges: bytes
        Content-Length: 8805
        Keep-Alive: timeout=5, max=100
        Connection: Keep-Alive
        Content-Type: application/pdf
        */

        $sampleFile = dirname(__FILE__ ).DIRECTORY_SEPARATOR.'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock([
            new Response(200, [
                'Content-Type'=>'application/pdf',
                'Content-Length'=>filesize( $sampleFile ),
            ], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $agreement = new Widgets( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->combinedDocument('123kf', $file);

        $this->assertTrue( $response );
    }
}