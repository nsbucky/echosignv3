<?php

use Echosign\Exceptions\JsonApiResponseException;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class GuzzleTransportTest extends PHPUnit_Framework_TestCase
{
    public function testCreateGetTransportGetOkResponse()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        $this->assertInstanceOf( '\GuzzleHttp\Client', $client );

        // mock the request
        $responseBody = "HTTP/1.1 202 OK\r\nContent-Length: 0\r\n\r\n";
        $mock         = new Mock( [ $responseBody ] );

        $client->getEmitter()->attach( $mock );

        $request = new \Echosign\Requests\GetRequest( '12345' );
        $request->setRequestUrl( 'http://localhost' );

        $response = $transport->handleRequest( $request );
        $this->assertEquals( 202, $response->getStatusCode() );
        //var_dump( $response );
    }

    public function testTransportReturnArray()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        // mock the request
        $json   = [ 'balls' => 'mouf' ];
        $stream = Stream::factory( json_encode( $json ) );

        $mock = new Mock( [
            new Response( 200, [ ], $stream )
        ] );
        $client->getEmitter()->attach( $mock );

        $request = new \Echosign\Requests\GetRequest( '12345' );
        $request->setRequestUrl( 'http://localhost' );

        $response = $transport->handleRequest( $request );

        $this->assertEquals( 200, $response->getStatusCode() );
        $this->assertEquals( $json, $response->json() );
    }

    /**
     * @expectedException \Echosign\Exceptions\JsonApiResponseException
     */
    public function testThrowsJsonException()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        // mock the request
        $json = [ 'code' => '12345', 'message' => 'failed' ];

        $stream = Stream::factory( json_encode( $json ) );

        $mock = new Mock( [
            new Response( 401, [ 'Content-Type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $request = new \Echosign\Requests\GetRequest( '12345' );
        $request->setRequestUrl( 'http://localhost' );
        $response = $transport->handleRequest( $request );
    }

    public function testHasGeneralHttpError()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        $mock = new Mock( [
            new Response( 401 )
        ] );

        $client->getEmitter()->attach( $mock );

        $request = new \Echosign\Requests\GetRequest( '12345' );
        $request->setRequestUrl( 'http://localhost' );
        $response = $transport->handleRequest( $request );

        $exception = $transport->getHttpException();
        $this->assertInstanceOf( 'GuzzleHttp\Exception\ClientException', $exception );
        $this->assertEquals( 401, $exception->getCode() );
    }

    public function testHandleError()
    {
        $transport = new \Echosign\Transports\GuzzleTransport();
        $client    = $transport->getClient();

        // mock the request
        $json = [ 'code' => 'INVALID_FACE', 'message' => 'failed' ];

        $stream = Stream::factory( json_encode( $json ) );

        $mock = new Mock( [
            new Response( 401, [ 'Content-Type' => 'application/json' ], $stream )
        ] );

        $client->getEmitter()->attach( $mock );

        $request = new \Echosign\Requests\GetRequest( '12345' );
        $request->setRequestUrl( 'http://localhost' );

        try {
            $response = $transport->handleRequest( $request );
        } catch( JsonApiResponseException $e ) {
            $this->assertEquals( 401, $e->getCode() );
            $this->assertEquals( 'INVALID_FACE', $e->getApiCode() );
            $this->assertEquals( 'failed', $e->getMessage() );
        }

    }
}