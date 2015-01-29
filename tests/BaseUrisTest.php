<?php

use Echosign\BaseUris;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;

class BaseUrisTest extends PHPUnit_Framework_TestCase
{
    public function testGetBaseUris()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client = $transport->getClient();

        // mock the request
        $json   = [
            "api_access_point" => "https://api.echosign.com",
            "web_access_point" => "https://secure.echosign.com"
        ];

        $stream = Stream::factory(json_encode($json));

        $mock = new Mock([
            new Response(200, ['content-type'=>'application/json'], $stream)
        ]);

        $client->getEmitter()->attach($mock);

        $baseUris = new BaseUris('12345', $transport);

        $baseUriInfo = $baseUris->getBaseUris();

        $this->assertInstanceOf('Echosign\Responses\BaseUriInfo', $baseUriInfo );

        $this->assertEquals( $json["api_access_point"], $baseUriInfo->getApiAccessPoint() );
        $this->assertEquals( $json["web_access_point"], $baseUriInfo->getWebAccessPoint() );
    }
}