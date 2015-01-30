<?php

use Echosign\Widgets;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class WidgetsTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $json = '{
          "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/widget?f=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
          "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*",
          "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $widget = new Widgets( '1234', $transport );

        $fileInfo = new \Echosign\RequestBuilders\Widget\WidgetFileInfo();
        $fileInfo->setLibraryDocumentId( "balls" );

        $docCreationinfo = new \Echosign\RequestBuilders\Widget\WidgetCreationInfo( 'test',
            'SENDER_SIGNATURE_NOT_REQUIRED', $fileInfo );

        $docCreate = new \Echosign\RequestBuilders\WidgetCreationRequest( $docCreationinfo,
            new \Echosign\RequestBuilders\Agreement\InteractiveOptions() );
        $response  = $widget->create( $docCreate );

        $this->assertInstanceOf( 'Echosign\Responses\WidgetCreationResponse', $response );
        $this->assertEquals( "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*",
            $response->getWidgetId() );
    }

    public function testListAll()
    {
        $json = '{
          "userWidgetList": [
            {
              "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*",
              "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/embeddedWidget?wid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
              "modifiedDate": "2015-01-30T09:05:28-08:00",
              "name": "TEST WIDGET",
              "status": "ENABLED",
              "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*"
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

        $widget   = new Widgets( '1234', $transport );
        $response = $widget->listAll();

        $this->assertInstanceOf( 'Echosign\Responses\UserWidgets', $response );

        $widgets = $response->getUserWidgetList();

        $this->assertEquals( 1, count( $widgets ) );
        $this->assertEquals( "TEST WIDGET", $widgets[0]['name'] );

    }

    public function testDetails()
    {
        $json = '{
          "events": [
            {
              "actingUserEmail": "test@test.com",
              "actingUserIpAddress": "209.242.146.10",
              "date": "2015-01-30T09:05:28-08:00",
              "description": "Document created by Ttest Performance",
              "participantEmail": "test@test.com",
              "type": "CREATED",
              "versionId": "2AAABLblqZhCZVCQyhWW1Pc0YaRw0ElYA8A-0P9yTuDRqrEc_WwpQ9vz0Vc576pNXyasT9HSCiGY*"
            }
          ],
          "latestVersionId": "2AAABLblqZhBpy1Q2UcFG_YwW4jDl4kQ4lOj8ypiu-LMby649buLqlRqYm5X0mOisA135Y42qiVM*",
          "locale": "en_US",
          "name": "TEST WIDGET",
          "participants": [
            {
              "email": "",
              "name": "",
              "status": "HIDDEN",
              "roles": [
                "WIDGET_SIGNER"
              ]
            },
            {
              "company": "Specific Performance, LLC",
              "email": "test@test.com",
              "name": "Test Performance",
              "status": "WIDGET",
              "title": "IT",
              "roles": [
                "SENDER"
              ]
            }
          ],
          "status": "ENABLED",
          "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*",
          "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/widget?f=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
          "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $widget   = new Widgets( '1234', $transport );
        $response = $widget->details( '123' );

        $this->assertInstanceOf( 'Echosign\Responses\WidgetInfo', $response );

        $this->assertEquals( 'ENABLED', $response->getStatus() );
        $this->assertEquals( 1, count( $response->getEvents() ) );
        $this->assertEquals( 2, count( $response->getParticipants() ) );
        $this->assertEquals( 'test@test.com', $response->getParticipants()[1]['email'] );
    }

    public function testDocuments()
    {
        $json = '{
          "documents": [
            {
              "documentId": "2AAABLblqZhDsxB3jgRpXuKSx7EZpAlAUroxi9XkYjPfZ59QHT-n9uf0L7-gDXlmLc__l866Ti9Y*",
              "mimeType": "application/pdf",
              "name": "jg mesh retainer ttv1.pdf",
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

        $widget   = new Widgets( '1234', $transport );
        $response = $widget->documents( '12312' );

        $this->assertInstanceOf( 'Echosign\Responses\WidgetDocuments', $response );

        $this->assertEquals( 1, count( $response->getDocuments() ) );
        $this->assertEquals( 2, $response->getDocuments()[0]['numPages'] );
    }

    public function testAgreements()
    {
        $json = '{
            "userAgreementList":[
                {
                    "displayDate": "2014-01-01T23:59:59",
                    "status": "EXPIRED",
                    "name": "Big balls Jones",
                    "agreementId": "2AAABLblqZhDsxB3jgRpXuKSx7EZpAlAUroxi9XkYjPfZ59QHT-n9uf0L7-gDXlmLc__l866Ti9Y*",
                    "displayUserInfo": {
                        "company": "Johnson",
                        "fullNameOrEmail": "Big Face"
                    },
                    "esign":true,
                    "latestVersionId": "123face"
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

        $widget = new Widgets( '1234', $transport );

        $response = $widget->agreements( '1234' );
        $this->assertInstanceOf( 'Echosign\Responses\WidgetAgreements', $response );
        $agreements = $response->getUserAgreementList();
        $this->assertEquals( 1, count( $agreements ) );
        $this->assertEquals( "EXPIRED", $agreements[0]['status'] );
    }

    public function testPersonalize()
    {
        $json = '{
          "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/widget?f=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
          "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*",
          "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $widget      = new Widgets( '1234', $transport );
        $personalize = new \Echosign\RequestBuilders\WidgetPersonalizationInfo( 'test@test.com' );
        $response    = $widget->personalize( '1234', $personalize );

        $this->assertInstanceOf( 'Echosign\Responses\WidgetPersonalizeResponse', $response );

        $this->assertEquals( "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*",
            $response->getWidgetId() );
    }

    public function testUpdateStatus()
    {
        $json = '{
            "message": "none",
            "code": "OK"
        }';

        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();
        $stream    = Stream::factory( $json );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $widget = new Widgets( '1234', $transport );

        $updateInfo = new \Echosign\RequestBuilders\WidgetStatusUpdateInfo( 'ENABLE', 'donkey balls',
            'http://www.yahoo.com' );
        $response   = $widget->updateStatus( '1234', $updateInfo );
        $this->assertInstanceOf( 'Echosign\Responses\WidgetStatusUpdateResponse', $response );

        $this->assertEquals( "none", $response->getMessage() );
        $this->assertEquals( "OK", $response->getCode() );
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

        $agreement = new Widgets( '12335', $transport );

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

        $agreement = new Widgets( '12335', $transport );

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

        $agreement = new Widgets( '12335', $transport );

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

        $widget = new Widgets( '12335', $transport );

        file_put_contents( $file, $stream->__toString() );

        $response = $widget->formData( '123kf', $file );

        $this->assertTrue( $response );
    }
}