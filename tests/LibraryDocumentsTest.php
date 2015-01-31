<?php

use Echosign\LibraryDocuments;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class LibraryDocumentsTest extends PHPUnit_Framework_TestCase
{

    public function testCreate()
    {
        $json = '{
          "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://poweresq.echosign.com/embed/account/sendProgress?aid=XJ28WY42H5E2T6M&noChrome=true\'></script>",
          "libraryDocumentId": "2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*",
          "url": "https://test.echosign.com/account/sendProgress?aid=XJ28WY42H5E2T6M"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $doc = new LibraryDocuments( '1234', $transport );

        $fileInfo = new \Echosign\RequestBuilders\Agreement\FileInfo();
        $fileInfo->setLibraryDocumentId( "balls" );

        $docCreationinfo = new \Echosign\RequestBuilders\LibraryDocument\LibraryDocumentCreationInfo(
            'test',
            'DOCUMENT',
            $fileInfo,
            'USER'
        );

        $docCreate = new \Echosign\RequestBuilders\LibraryCreationInfo( $docCreationinfo,
            new \Echosign\RequestBuilders\Agreement\InteractiveOptions() );
        $response  = $doc->create( $docCreate );

        $this->assertInstanceOf( 'Echosign\Responses\LibraryDocumentCreationResponse', $response );
        $this->assertEquals( "2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*",
            $response->getLibraryDocumentid() );
    }

    public function testDocumentsInfo()
    {
        $json = '{
          "documents": [
            {
              "documentId": "2AAABLblqZhBEy7YAWLZmg7hhAsZli2engOfwifncWCbQUt3__xoYxBEEuSrJIDgHsMxLihk3liI*",
              "mimeType": "application/pdf",
              "name": "sample.pdf",
              "numPages": 2
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $doc = new LibraryDocuments( '1234', $transport );

        $response = $doc->documentsInfo( '1234' );
        $this->assertInstanceOf( 'Echosign\Responses\Documents', $response );
        $this->assertEquals( 1, count( $response->getDocuments() ) );
        $this->assertEquals( 2, $response->getDocuments()[0]['numPages'] );
        $this->assertEquals( 'sample.pdf', $response->getDocuments()[0]['name'] );
    }

    public function testDocumentDetails()
    {
        $json = '{
          "events": [
            {
              "actingUserEmail": "test@test.com",
              "actingUserIpAddress": "104.130.151.28",
              "date": "2014-10-28T15:00:31-07:00",
              "description": "Document created by Test Performance",
              "participantEmail": "test@gmail.com",
              "type": "CREATED",
              "versionId": "2AAABLblqZhCwrhreW0TKaPW6jAlHIk_dilIPgVaFgSoDSurWdHwVuT_xU6CtWGU58XR8OI5iszY*"
            }
          ],
          "latestVersionId": "2AAABLblqZhCwrhreW0TKaPW6jAlHIk_dilIPgVaFgSoDSurWdHwVuT_xU6CtWGU58XR8OI5iszY*",
          "locale": "en_US",
          "name": "Medical Authorization Legal 022014.pdf",
          "participants": [
            {
              "company": "Attorney At Law",
              "email": "test@gmail.com",
              "name": "Attorney At Law",
              "status": "FORM",
              "title": "IT",
              "roles": [
                "SENDER"
              ]
            }
          ],
          "status": "DOCUMENT_LIBRARY",
          "libraryDocumentId": "2AAABLblqZhDmk9KVLo-495oBazcKdqoOJ5L6iDrrTYzc_aaRODbY5Z9apzIgy_mIizYDy8uevwc*"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $doc = new LibraryDocuments( '1234', $transport );

        $response = $doc->documentDetails( '1234' );
        $this->assertInstanceOf( 'Echosign\Responses\LibraryDocumentInfo', $response );
        $this->assertEquals( 1, count( $response->getEvents() ) );
        $this->assertEquals( "DOCUMENT_LIBRARY", $response->getStatus() );
        $this->assertEquals( 1, count( $response->getParticipants() ) );
        $this->assertEquals( 'test@gmail.com', $response->getParticipants()[0]['email'] );

    }

    public function testListAll()
    {
        $json = '{
          "libraryDocumentList": [
            {
              "libraryDocumentId": "2AAABLblqZhDmk9KVLo-495oBazcKdqoOJ5L6iDrrTYzc_aaRODbY5Z9apzIgy_mIizYDy8uevwc*",
              "libraryTemplateTypes": [
                "DOCUMENT"
              ],
              "modifiedDate": "2014-10-28T15:00:31-07:00",
              "name": "Medical Authorization for BN & Stratos Legal 022014.pdf",
              "scope": "SHARED"
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $doc = new LibraryDocuments( '1234', $transport );

        $response = $doc->listAll();

        $this->assertInstanceof( 'Echosign\Responses\DocumentLibraryItems', $response );

        $docs = $response->getLibraryDocumentList();

        $this->assertEquals( 1, count( $docs ) );
        $this->assertEquals( 'SHARED', $docs[0]['scope'] );
        $this->assertEquals( "2AAABLblqZhDmk9KVLo-495oBazcKdqoOJ5L6iDrrTYzc_aaRODbY5Z9apzIgy_mIizYDy8uevwc*",
            $docs[0]['libraryDocumentId'] );
    }

    public function testDownloadDocuments()
    {
        $documentId = substr( md5( time() ), 8 ) . '.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

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

        $sampleFile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock( [
            new Response( 200, [
                'Content-Type'   => 'application/pdf',
                'Content-Length' => filesize( $sampleFile ),
            ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new LibraryDocuments( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->downloadDocument( '123kf', '234df', $file );

        $this->assertTrue( $response );
    }

    public function testAuditTrail()
    {
        $documentId = substr( md5( time() ), 8 ) . '.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

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

        $sampleFile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock( [
            new Response( 200, [
                'Content-Type'   => 'application/pdf',
                'Content-Length' => filesize( $sampleFile ),
            ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new LibraryDocuments( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->auditTrail( '123kf', $file );

        $this->assertTrue( $response );
    }

    public function testCombinedDocument()
    {
        $documentId = substr( md5( time() ), 8 ) . '.pdf';

        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $documentId;

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

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

        $sampleFile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'files/sample.pdf';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock( [
            new Response( 200, [
                'Content-Type'   => 'application/pdf',
                'Content-Length' => filesize( $sampleFile ),
            ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new LibraryDocuments( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->combinedDocument( '123kf', $file );

        $this->assertTrue( $response );
    }
}