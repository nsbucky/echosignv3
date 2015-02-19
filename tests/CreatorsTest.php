<?php

use Echosign\Creators\Agreement;
use Echosign\Creators\LibraryDocument;
use Echosign\Creators\Reminder;
use Echosign\Creators\Search;
use Echosign\Creators\TransientDocument;
use Echosign\Creators\User;
use Echosign\Creators\Widget;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;
use Echosign\Transports\GuzzleTransport;

class CreatorsTest extends PHPUnit_Framework_TestCase
{
    public $token = 'myOauthToken';

    public function getMockTransport( $json )
    {
        $transport = new GuzzleTransport();
        $client    = $transport->getClient();
        $responses = [];

        if( is_array( $json ) ) {
            foreach( $json as $j ) {
                $responses[] = new Response( 200, [ 'content-type' => 'application/json' ], Stream::factory( $j ) );
            }
        } else {
            $responses[] = new Response( 200, [ 'content-type' => 'application/json' ], Stream::factory( $json ) );
        }

        $mock = new Mock( $responses );

        $client->getEmitter()->attach( $mock );

        return $transport;
    }

    public function testCreateFromLibraryDocumentId()
    {
        $json = '{
            "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
            "expiration": "2014-07-07T08:39:24-07:00",
            "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        }';

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createFromLibraryDocumentId('test@test.com','Hello','some-library-id','test agreement');

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateFromLibraryDocumentName()
    {
        $json = '{
            "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
            "expiration": "2014-07-07T08:39:24-07:00",
            "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        }';

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createFromLibraryDocumentName('test@test.com','Hello','some-library-id','test agreement');

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateFromUrl()
    {
        $json = '{
            "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
            "expiration": "2014-07-07T08:39:24-07:00",
            "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        }';

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createFromUrl('test@test.com','Hello','filename.pdf','http://remote.com','test agreement');

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateFromTransientDocumentId()
    {
        $json = '{
            "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
            "expiration": "2014-07-07T08:39:24-07:00",
            "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
            "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
        }';

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createFromTransientDocumentId('test@test.com','Hello','some-trans-library-id','test agreement');

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateTransientAgreement()
    {
        $json = [
            '{ "transientDocumentId":"123asdf809"}',
            '{
                "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
                "expiration": "2014-07-07T08:39:24-07:00",
                "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
                "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
            }',
        ];

        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createTransientAgreement('test@test.com','Hello',$file,'test agreement');

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateLibraryDocumentAgreement()
    {
        $json = [
            '{ "transientDocumentId":"123asdf809"}',
                '{
              "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://poweresq.echosign.com/embed/account/sendProgress?aid=XJ28WY42H5E2T6M&noChrome=true\'></script>",
              "libraryDocumentId": "2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*",
              "url": "https://test.echosign.com/account/sendProgress?aid=XJ28WY42H5E2T6M"
            }',
            '{
                "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/embed/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*&noChrome=true\'></script>",
                "expiration": "2014-07-07T08:39:24-07:00",
                "agreementId": "2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*",
                "url": "https://secure.echosign.com/public/apiLogin?aalc=2AAABLblqZhCLSCUdCzl12KADeV4p7qZdJGbvZxslHruG00s8isauKjnQGAWd1jHq2d67jT_A8nI1Rha9ijWRxjBcIUZuL3m5dPAPyFKBD8wAB0goNmv1E-NVtpSgKhuZ2PBiVp6BlNI*"
            }',
        ];

        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $agreement = new Agreement( $this->token, $this->getMockTransport($json));

        $agreementId = $agreement->createLibraryDocumentAgreement('test@test.com','Hello',$file,'test agreement');

        if( $agreementId === false) {
            print_r($agreement->getErrorMessages());
        }

        $this->assertEquals("2AAABLblqZhBXIFwsI6hzV5IzticsCNYH2wZFgfEdo8mhhpOMZR261g3d5tR9RHpg6ckTZFftG2o*", $agreementId);
    }

    public function testCreateFromLocalFile()
    {
        $json = [
            '{ "transientDocumentId":"123asdf809"}',
            '{
              "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://poweresq.echosign.com/embed/account/sendProgress?aid=XJ28WY42H5E2T6M&noChrome=true\'></script>",
              "libraryDocumentId": "2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*",
              "url": "https://test.echosign.com/account/sendProgress?aid=XJ28WY42H5E2T6M"
            }',
        ];

        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $libraryDocument = new LibraryDocument( $this->token, $this->getMockTransport($json));

        $libraryDocumentId = $libraryDocument->createFromLocalFile( $file, 'test', 'DOCUMENT');


        $this->assertEquals("2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*", $libraryDocumentId);
    }

    public function testCreateTransientWidgetFromLocalFile()
    {
        $json = [
            '{ "transientDocumentId":"123asdf809"}',
            '{
          "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/widget?f=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
          "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*",
          "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*"
        }',
        ];

        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $widget = new Widget( $this->token, $this->getMockTransport( $json ) );

        $widgetId = $widget->createTransientWidgetFromLocalFile($file, 'test widget');

        $this->assertEquals("https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*", $widgetId);
    }

    public function testCreateLibraryDocumentWidgetFromLocalFile()
    {
        $json = [
            '{ "transientDocumentId":"123asdf809"}',
            '{
              "embeddedCode": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://poweresq.echosign.com/embed/account/sendProgress?aid=XJ28WY42H5E2T6M&noChrome=true\'></script>",
              "libraryDocumentId": "2AAABLblqZhCLqOm1s_gWpTxax3wK6csrs22iQOYyLOZHLLnOl2FeL3IxFEkgO09JYWczAt_57Lw*",
              "url": "https://test.echosign.com/account/sendProgress?aid=XJ28WY42H5E2T6M"
            }',
            '{
          "javascript": "<script type=\'text/javascript\' language=\'JavaScript\' src=\'https://secure.echosign.com/public/widget?f=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*\'></script>",
          "url": "https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*",
          "widgetId": "2AAABLblqZhCF9yZRdsh0_3RbujXEoIDbBC0PG9_BUT1sTEWC4xw7OCstLx4vKpqF9086p-lhcoI*"
        }',
        ];

        $file = tempnam( sys_get_temp_dir(), 'TMP' );
        $fp   = fopen( $file, 'w+' );
        fwrite( $fp, "hey look, I just work here okay?" );
        fclose( $fp );

        $widget = new Widget( $this->token, $this->getMockTransport( $json ) );

        $widgetId = $widget->createLibraryDocumentWidgetFromLocalFile($file, 'test widget');

        if( $widgetId === false ) {
            print_r( $widget->getErrorMessages() );
        }

        $this->assertEquals("https://poweresq.echosign.com/public/hostedForm?formid=2AAABLblqZhC8ueu0-qMHimIHkeGtB39bIneHcv5F5Kx0gbz21gQ27A3AnMlsKaKKrTKQYTXl8I0*", $widgetId);
    }

    public function testCreateReminder()
    {
        $json = '{
              "result": "SUCCESS",
              "recipientEmail": "test@test.com"
        }';

        $reminder = new Reminder( $this->token, $this->getMockTransport($json));
        $result = $reminder->create('some-id-balls');

        $this->assertEquals('SUCCESS', $result);
    }

    public function testUserCreate()
    {
        $json = '{"userId":"123446"}';

        $user = new User( $this->token, $this->getMockTransport( $json ) );

        $userId = $user->create( 'Fred', 'Flinstone', 'test@test.com','123456BALLS');

        $this->assertEquals('123446', $userId);
    }

    public function testSearchCreate()
    {
        $json = '{
          "events": [
            {
              "agreementAssetId": "2BAABLblqZhARJcIh9hAZIrdTii8G2wvQzCNPWf9x7Mb83vrC6TzIlBunHE2m9f-qenIfQ9Vl2aE*",
              "agreementAssetName": "grid math.pdf",
              "agreementAssetType": "agreement",
              "documentHistoryEvent": {
                "actingUserEmail": "test@test.com",
                "date": "2014-10-21T09:40:00-07:00",
                "description": "Sent out for signature to test@gmail.com",
                "participantEmail": "test@gmail.com",
                "type": "SIGNATURE_REQUESTED"
              }
            }
          ],
          "nextPageCursor": "",
          "currentPageCursor": "BwELAQYAAgEAAAICABC3ZbmoWj1h0-Yh4J_rTKgWDqg3GHWhshZTliKBxcTxfLM6jDjlKoH4Kg**",
          "searchId": "2ABAsBLblqZhD5AFD8c2jjh4rkc4Ljb6V0_2j_i2DFRfpnfI0C6nzsgStRyv7jBh1oDbbTD3QbhIgEJ8NtBcmcd0absBPfr5-AA5wf_WPVQcN-nNOK61RDU1qS96nqpLYupWJxdViVilM*"
        }';

        $search = new Search( $this->token, $this->getMockTransport($json));

        $events = $search->create( new DateTime(), new DateTime() );

        $this->assertEquals( 1, count( $events ));

        $this->assertEquals( 'grid math.pdf', $events[0]['agreementAssetName']);
    }

    public function testSearchResult()
    {
        $json = '{
          "events": [
            {
              "agreementAssetId": "2BAABLblqZhARJcIh9hAZIrdTii8G2wvQzCNPWf9x7Mb83vrC6TzIlBunHE2m9f-qenIfQ9Vl2aE*",
              "agreementAssetName": "grid math.pdf",
              "agreementAssetType": "agreement",
              "documentHistoryEvent": {
                "actingUserEmail": "test@test.com",
                "date": "2014-10-21T09:40:00-07:00",
                "description": "Sent out for signature to test@gmail.com",
                "participantEmail": "test@gmail.com",
                "type": "SIGNATURE_REQUESTED"
              }
            }
          ],
          "nextPageCursor": "BwELAQYAAgEAAAICABC3ZbmoWj1h0-Yh4J_rTKgWDqg3GHWhshZTliKBxcTxfLM6jDjlKoH4Kg**"
        }';

        $search = new Search( $this->token, $this->getMockTransport($json));

        $events = $search->create( new DateTime(), new DateTime() );

        $this->assertEquals( 1, count( $events ));

        $this->assertEquals( 'grid math.pdf', $events[0]['agreementAssetName']);
    }


}