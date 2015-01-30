<?php
namespace Echosign\Transports;

use Echosign\Abstracts\HttpRequest;
use Echosign\Exceptions\JsonApiResponseException;
use Echosign\Interfaces\HttpTransport;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Client;

class GuzzleTransport implements HttpTransport
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var ClientException
     */
    protected $httpException;

    /**
     * @param array $config
     */
    public function __construct( $config = [ ] )
    {
        $this->client = new Client( $config );
    }

    /**
     * @param HttpRequest $httpRequest
     * @return array|mixed
     * @throws JsonApiResponseException
     * @throws \RuntimeException
     */
    public function handleRequest( HttpRequest $httpRequest )
    {
        if( $httpRequest->isJsonRequest() ) {
            $requestBody['json'] = $httpRequest->getBody();
        } else {
            $requestBody['body'] = $httpRequest->getBody();
        }

        if( method_exists( $httpRequest, 'saveResponseToFile') && $httpRequest->saveResponseToFile() ) {
            $requestBody['save_to'] = $httpRequest->getFileSavePath();
        }

        $url = $httpRequest->getRequestUrl();

        if( empty( $url ) ) {
            throw new \RuntimeException('request url is empty.');
        }

        $request = $this->client->createRequest(
            $httpRequest->getRequestMethod(),
            $url,
            $requestBody
        );

        $request->setHeaders( $httpRequest->getHeaders() );

        try {
            $response = $this->client->send( $request );
        } catch( ClientException $e ) {
            $this->httpException = $e;
            $response = $e->getResponse();
        }

        return $this->handleResponse( $response );
    }

    /**
     * @param Response $response
     * @return array|mixed
     * @throws JsonApiResponseException
     */
    public function handleResponse( $response )
    {
        $contentType = $response->getHeader( 'content-type' );

        // if its not json, then just return the response and handle it in your own object.
        if (stripos( $contentType, 'application/json' )  === false) {
            return $response;
        }

        $json = $response->json();

        // adobe says hey this didn't work!
        if ($response->getStatusCode() >= 400) {
            // oops an error with the response, from Adobe complaining about something in your code.
            throw new JsonApiResponseException( $response->getStatusCode(), $json['message'], $json['code'] );
        }

        return $json;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return ClientException
     */
    public function getHttpException()
    {
        return $this->httpException;
    }

}