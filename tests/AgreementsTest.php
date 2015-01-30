<?php

use Echosign\Agreements;
use Echosign\RequestBuilders\Agreement\DocumentCreationInfo;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class AgreementsTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        $json = '{
            "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
            "expiration": "2014-07-07T08:39:24-07:00",
            "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        }';

        $stream = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        $fileInfo = new \Echosign\RequestBuilders\Agreement\FileInfo();
        $fileInfo->setDocumentURL( 'test.pdf', 'http://www.yahoo.com', 'application/pdf' );

        $doc = new DocumentCreationInfo( $fileInfo, 'test', 'ESIGN', 'SENDER_SIGNATURE_NOT_REQUIRED' );
        $doc->setCallBackInfo( 'http://localhost' );

        $creation = new \Echosign\RequestBuilders\AgreementCreationInfo( $doc,
            new \Echosign\RequestBuilders\Agreement\InteractiveOptions() );

        $response = $agreement->create( $creation );

        $this->assertInstanceOf( 'Echosign\Responses\AgreementCreationResponse', $response );

        $this->assertEquals( "2014-07-07T08:39:24-07:00", $response->getExpiration() );
        $this->assertEquals( "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            $response->getAgreementId() );
    }

    public function testListAll()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        $returnJson = '{
              "userAgreementList": [
                {
                  "displayDate": "2014-07-07T08:39:24-07:00",
                  "displayUserInfo": {
                    "fullNameOrEmail": "recipient@gmail.com"
                  },
                  "esign": true,
                  "agreementId": "2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*",
                  "latestVersionId": "2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*",
                  "name": "[DEMO USE ONLY] Sign Up Proposal",
                  "status": "OUT_FOR_SIGNATURE"
                }
              ]
            }';

        $stream = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        $response = $agreement->listAll();

        $this->assertInstanceof( 'Echosign\Responses\UserAgreements', $response );

        $agreements = $response->getUserAgreementList();

        $this->assertEquals( 1, count( $agreements ) );

        $this->assertEquals( "2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*",
            $agreements[0]['agreementId'] );
    }

    public function testStatus()
    {
        $returnJson = '{
          "events": [
            {
              "actingUserEmail": "test@test.com",
              "actingUserIpAddress": "192.168.1.1",
              "date": "2014-07-07T08:39:24-07:00",
              "description": "Document created by Kenrick Buchanan",
              "participantEmail": "test@test.com",
              "type": "CREATED",
              "versionId": "2AAABLblqZhAAdfp0sUOyP1LUeq8K3WeWS_FHKZufymxkEuGvXgtdJT3pXhNvazcGnwa10N1o8gY*"
            },
            {
              "actingUserEmail": "test@test.com",
              "date": "2014-07-07T08:39:27-07:00",
              "description": "Sent out for signature to recipient@gmail.com",
              "participantEmail": "recipient@gmail.com",
              "type": "SIGNATURE_REQUESTED"
            }
          ],
          "latestVersionId": "2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*",
          "locale": "en_US",
          "message": "Please sign this test document.",
          "name": "[DEMO USE ONLY] Sign Up Proposal",
          "participants": [
            {
              "email": "recipient@gmail.com",
              "name": "",
              "roles": [
                "SIGNER"
              ],
              "status": "WAITING_FOR_MY_SIGNATURE"
            },
            {
              "company": "Specific Performance, LLC",
              "email": "test@test.com",
              "name": "Kenrick Buchanan",
              "roles": [
                "SENDER"
              ],
              "status": "OUT_FOR_SIGNATURE",
              "title": "IT"
            }
          ],
          "status": "OUT_FOR_SIGNATURE",
          "agreementId": "2AAABLblqZhCU0Zea2YWCvcXJFU6qsNOGG83nofmmdNsjVIfJEJ_mqJArenO9-WtZMxoHbueS9mk*",
          "nextParticipantInfos": [
            {
              "email": "recipient@gmail.com",
              "name": "",
              "waitingSince": "2014-07-07T08:39:24-07:00"
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );
        $response  = $agreement->status( '1233f5' );

        $this->assertInstanceOf( 'Echosign\Responses\AgreementInfo', $response );

        $events = $response->getEvents();
        $this->assertEquals( 2, count( $events ) );

        $this->assertEquals( "2AAABLblqZhBRyo_vwhJWPKtajf1t0onWqB3hYhwMwvS9a4yo5yVevqo2yHrKmg7fo6dkdItE3DA*",
            $response->getLatestVersionId() );

        $participants = $response->getParticipants();
        $this->assertEquals( 2, count( $participants ) );
        $this->assertEquals( "recipient@gmail.com", $participants[0]['email'] );

        $this->assertEquals( "OUT_FOR_SIGNATURE", $response->getStatus() );

    }

    public function testDocuments()
    {
        $returnJson = '{
          "documents": [
            {
              "documentId": "2AAABLblqZhBEsJow3IswASHPCt74o33MTcMKvaqnH1sbZEyh18WYqB8DoKkUrlemBsVyIhuSOhI*",
              "mimeType": "application/pdf",
              "name": "May 5.pdf"
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        $response = $agreement->documents( '12345' );

        $this->assertInstanceOf( 'Echosign\Responses\AgreementDocuments', $response );

        $documents = $response->getDocuments();

        $this->assertEquals( 1, count( $documents ) );

        $this->assertEquals( "application/pdf", $documents[0]['mimeType'] );
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

        $agreement = new Agreements( '12335', $transport );

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

        $agreement = new Agreements( '12335', $transport );

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

        $agreement = new Agreements( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->combinedDocument( '123kf', $file );

        $this->assertTrue( $response );
    }

    public function testFormData()
    {
        $documentId = substr( md5( time() ), 8 ) . '.csv';

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

        $sampleFile = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'files/sample.csv';

        $stream = Stream::factory( file_get_contents( $sampleFile ) );

        $mock = new Mock( [
            new Response( 200, [
                'Content-Type'   => 'text/csv',
                'Content-Length' => filesize( $sampleFile ),
            ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $agreement->formData( '123kf', $file );

        $this->assertTrue( $response );
    }

    public function testSigningUrls()
    {
        $returnJson = '{
          "signingUrls": [
            {
              "email": "kb@gmail.com",
              "esignUrl": "https://secure.echosign.com/public/apiesign?spm=ZlRy5JswjlWd8QXO4EvgJw**.cGlkPTE3MzY4Mzc0NDE*",
              "simpleEsignUrl": "https://secure.echosign.com/public/apiesign?spm=8W3gTaXB3omaJUNwQKBxkQ**.c2ltcGxlPXRydWUmcGlkPTE3MzY4Mzc0NDE*"
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        $response = $agreement->signingUrls( '1234' );

        $this->assertInstanceOf( 'Echosign\Responses\SigningUrls', $response );

        $urls = $response->getSigningUrls();

        $this->assertEquals( 1, count( $urls ) );
        $this->assertEquals( "kb@gmail.com", $urls[0]['email'] );
        $this->assertEquals( "https://secure.echosign.com/public/apiesign?spm=ZlRy5JswjlWd8QXO4EvgJw**.cGlkPTE3MzY4Mzc0NDE*",
            $urls[0]['esignUrl'] );
        $this->assertEquals( "https://secure.echosign.com/public/apiesign?spm=8W3gTaXB3omaJUNwQKBxkQ**.c2ltcGxlPXRydWUmcGlkPTE3MzY4Mzc0NDE*",
            $urls[0]['simpleEsignUrl'] );

    }

    public function testPagesInfo()
    {
        $returnJson = '{
          "documentPagesInfo": [
            {
              "height":"12.34",
              "rotation":"23.43",
              "width":"45.12",
              "pageNumber":"3"
            }
          ]
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );

        $response = $agreement->pagesInfo( '1234' );

        $this->assertInstanceOf( 'Echosign\Responses\CombinedDocumentPagesInfo', $response );

        $pages = $response->getDocumentPagesInfo();

        $this->assertEquals( 1, count( $pages ) );
        $this->assertEquals( 3, $pages[0]['pageNumber'] );
        $this->assertEquals( 23.43, $pages[0]['rotation'] );
        $this->assertEquals( 12.34, $pages[0]['height'] );
        $this->assertEquals( 45.12, $pages[0]['width'] );
    }

    public function testCancel()
    {
        $returnJson = '{
          "result": "CANCELLED"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $returnJson );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $agreement = new Agreements( '12335', $transport );
        $info      = new \Echosign\RequestBuilders\AgreementStatusUpdateInfo();

        $response = $agreement->cancel( '12345', $info );

        $this->assertInstanceOf( 'Echosign\Responses\AgreementStatusUpdateResponse', $response );

        $this->assertEquals( 'CANCELLED', $response->getResult() );
    }
}