<?php

use Echosign\BaseUris;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class BaseUrisTest extends PHPUnit_Framework_TestCase
{
    public function testApiRequestUrl()
    {
        $transport   = new \Echosign\Transports\GuzzleTransport();
        $baseUris    = new BaseUris( '12345', $transport );
        $url         = $baseUris->getRequestUrl();
        $expectedUrl = $baseUris->getApiEndPoint() . '/' . $baseUris->getBaseApiPath();

        $this->assertEquals( $expectedUrl, $url );

        $url = $baseUris->getRequestUrl( [ 'test' => 'baz' ] );

        $this->assertEquals( $expectedUrl . '?test=baz', $url );

    }

    public function testGetBaseUris()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        // mock the request
        $json = [
            "api_access_point" => "https://api.echosign.com",
            "web_access_point" => "https://secure.echosign.com"
        ];

        $stream = Stream::factory( json_encode( $json ) );

        $mock = new Mock( [
            new Response( 200, [ 'content-type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $baseUris = new BaseUris( '12345', $transport );

        $baseUriInfo = $baseUris->getBaseUris();

        $this->assertInstanceOf( 'Echosign\Responses\BaseUriInfo', $baseUriInfo );

        $this->assertEquals( $json["api_access_point"], $baseUriInfo->getApiAccessPoint() );
        $this->assertEquals( $json["web_access_point"], $baseUriInfo->getWebAccessPoint() );
    }
}