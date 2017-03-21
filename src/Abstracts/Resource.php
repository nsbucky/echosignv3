<?php
namespace Echosign\Abstracts;

use Echosign\Interfaces\HttpTransport;
use Echosign\Requests\GetRequest;
use Echosign\Requests\PostRequest;
use Psr\Log\LoggerInterface;

/**
 * Class Resource
 * @package Echosign\Abstracts
 */
abstract class Resource
{
    /**
     * @var HttpTransport
     */
    protected $transport;

    /**
     * @var string
     */
    protected $apiEndPoint = 'https://api.na1.echosign.com:443/api/rest/v3';

    /**
     * @var string
     */
    protected $apiRequestUrl;

    /**
     * @var
     */
    protected $baseApiPath;

    /**
     * @var string like 2AAABLblqZHAOTq69TB7lw_5rx_oac1yvBWb0bAYSMFANpqivZmuGyu6qOA6WY8PV1AZ3Rnyg0jY*
     */
    protected $oAuthToken;

    /**
     * @var mixed
     */
    protected $responseReceived;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var HttpRequest
     */
    protected $request;

    /**
     * @param $oAuthToken
     * @param HttpTransport $transport
     */
    public function __construct( $oAuthToken, HttpTransport $transport )
    {
        $this->oAuthToken = $oAuthToken;
        $this->setTransport( $transport );
    }

    /**
     * @return string
     */
    protected function getApiEndPoint()
    {
        return $this->apiEndPoint;
    }

    /**
     * @param string $apiEndPoint
     */
    protected function setApiEndPoint( $apiEndPoint )
    {
        $this->apiEndPoint = $apiEndPoint;
    }

    /**
     * @return HttpTransport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @param HttpTransport $transport
     */
    public function setTransport( HttpTransport $transport )
    {
        $this->transport = $transport;
    }

    /**
     * @return string
     */
    public function getOAuthToken()
    {
        return $this->oAuthToken;
    }

    /**
     * @param string $oAuthToken
     */
    public function setOAuthToken( $oAuthToken )
    {
        $this->oAuthToken = $oAuthToken;
    }

    /**
     * @return mixed
     */
    public function getResponseReceived()
    {
        return $this->responseReceived;
    }

    /**
     * @param $url
     */
    protected function setApiRequestUrl( $url )
    {
        $this->apiRequestUrl = $url;
    }

    /**
     * @return string
     */
    protected function getApiRequestUrl()
    {
        return $this->apiRequestUrl;
    }

    /**
     * @param array $queryString
     * @return string
     */
    protected function getRequestUrl( array $queryString = [ ] )
    {
        $paths = [
            $this->getApiEndPoint(),
            $this->getBaseApiPath(),
            $this->getApiRequestUrl()
        ];

        return rtrim( implode( '/', array_filter( $paths ) ) . '?' . http_build_query( $queryString ), '?' );
    }

    /**
     * @return LoggerInterface
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger( LoggerInterface $logger )
    {
        $this->logger = $logger;
    }

    /**
     * add a debug level log message
     * @param $message
     * @param $data
     */
    protected function logDebug( $message, array $data = [ ] )
    {
        $logger = $this->getLogger();

        if (!$logger) {
            return;
        }

        $logger->debug( $message, $data );
    }

    /**
     * @return string
     */
    protected function getBaseApiPath()
    {
        return $this->baseApiPath;
    }

    /**
     * @param string $baseApiPath
     */
    protected function setBaseApiPath( $baseApiPath )
    {
        $this->baseApiPath = $baseApiPath;
    }

    /**
     * @return HttpRequest
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param HttpRequest $request
     */
    protected function setRequest( $request )
    {
        $this->request = $request;
    }

    /**
     * most requests to the GET based resources are simple an repetitive. If you need more then what this function does
     * just create your own request. It bases the url generation on calling $this->getRequestUrl() internally. So make sure
     * you set the api request path first. $this->setApiRequestUrl( 'agreementAssetEvents' ) for example.
     * @param array $queryString
     * @param $userId
     * @param $userEmail
     * @return array
     */
    protected function simpleGetRequest( array $queryString = [ ], $userId = null, $userEmail = null )
    {
        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl( $queryString ) );

        if ($userId && $userEmail) {
            $request->setHeader( 'x-user-id', $userId );
            $request->setHeader( 'x-user-email', $userEmail );
        }

        $this->setRequest( $request );
        $this->logDebug( "GET: " . $this->getRequestUrl( $queryString ) );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if (!is_array( $response )) {
            $this->responseReceived = $response;
            throw new \RuntimeException( 'Bad response received! Please inspect responseReceived' );
        }

        $this->logDebug( "response", $response );

        return $response;
    }

    /**
     * Save a response to a local from from request. Most of the API responses that return PDF or CSV files work with
     * this functionality. It bases the url generation on calling $this->getRequestUrl() internally. So make sure
     * you set the api request path first. $this->setApiRequestUrl( 'agreementAssetEvents' ) for example.
     * @param $saveToPath
     * @param array $query
     * @return bool
     */
    protected function saveFileRequest( $saveToPath, array $query = [ ] )
    {
        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl( $query ) );
        $request->setFileSavePath( $saveToPath );
        $request->setJsonRequest( false );

        $this->setRequest( $request );
        $this->logDebug( "GET: " . $this->getRequestUrl( $query ) );

        $transport = $this->getTransport();
        $transport->handleRequest( $request );

        $this->logDebug( "tried to write to file: " . $saveToPath );

        return file_exists( $saveToPath );
    }

    /**
     * assumes JSON request and JSON response. Most requests are like this, so this simplifies the whole process.It
     * bases the url generation on calling $this->getRequestUrl() internally. So make sure
     * you set the api request path first. $this->setApiRequestUrl( 'agreementAssetEvents' ) for example.
     * @param array $data
     * @param null $userId
     * @param null $userEmail
     * @return mixed
     */
    protected  function simplePostRequest( array $data, $userId = null, $userEmail = null )
    {
        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        if ($userId && $userEmail) {
            $request->setHeader( 'x-user-id', $userId );
            $request->setHeader( 'x-user-email', $userEmail );
        }

        $request->setBody( $data );

        $this->setRequest( $request );
        $this->logDebug( "POST: " . $this->getRequestUrl() );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if (!is_array( $response )) {
            $this->responseReceived = $response;
            throw new \RuntimeException( 'Bad response received! Please inspect responseReceived' );
        }

        $this->logDebug( "response", $response );

        return $response;
    }

}
