<?php

use Echosign\Search;
use Echosign\RequestBuilders\AgreementAssetEventRequest;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class SearchTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        // mock the request
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

        $jsonArray = json_decode( $json, true );

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $search = new Search('123465', $transport);

        $assetRequest = new AgreementAssetEventRequest( new DateTime(), new DateTime(), 2, true);

        $response = $search->create( $assetRequest );

        $this->assertInstanceOf('Echosign\Responses\AgreementAssetEventPostResponse', $response);

        $events = $response->getEvents();

        $this->assertEquals(1, count( $events ) );
        $this->assertEquals( $jsonArray['currentPageCursor'], $response->getCurrentPageCursor() );
        $this->assertEquals( $jsonArray['searchId'], $response->getSearchId() );
    }

    public function testResult()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        // mock the request
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

        $jsonArray = json_decode( $json, true );

        $stream = Stream::factory($json);

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        #$log = new Monolog\Logger('test');
        #$handler = new Monolog\Handler\TestHandler();
        #$log->pushHandler( $handler );

        $search = new Search('123465', $transport);
        #$search->setLogger( $log );

        $response = $search->result( 'search_id_doesnt_matter', 'lame_page_cursor' );

        $this->assertInstanceOf('Echosign\Responses\AgreementAssetEventGetResponse', $response);

        $events = $response->getEvents();

        $this->assertEquals(1, count( $events ) );
        $this->assertEquals( $jsonArray['nextPageCursor'], $response->getNextPageCursor() );

        //print_r( $handler->getRecords() );
    }
}

