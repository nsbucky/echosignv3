<?php
namespace Echosign\Abstracts;

use Echosign\Interfaces\HttpTransport;
use Echosign\Abstracts\HttpRequest;
use Psr\Log\LoggerInterface;

abstract class Resource
{
    /**
     * @var HttpTransport
     */
    protected $transport;

    /**
     * @var string
     */
    protected $apiEndPoint = 'https://api.echosign.com/api/rest/v3';

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
    public function getApiEndPoint()
    {
        return $this->apiEndPoint;
    }

    /**
     * @param string $apiEndPoint
     */
    public function setApiEndPoint( $apiEndPoint )
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
    public function setApiRequestUrl( $url )
    {
        $this->apiRequestUrl = $url;
    }

    /**
     * @return string
     */
    public function getApiRequestUrl()
    {
        return $this->apiRequestUrl;
    }

    /**
     * @return string
     */
    public function getRequestUrl()
    {
        $paths = [
            $this->getApiEndPoint(),
            $this->getBaseApiPath(),
            $this->getApiRequestUrl()
        ];

        return implode('/', array_filter( $paths ) );
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
    public function logDebug( $message, array $data = [] )
    {
        $logger = $this->getLogger();

        if( ! $logger ) {
            return;
        }

        $logger->debug( $message, $data );
    }

    /**
     * @return string
     */
    public function getBaseApiPath()
    {
        return $this->baseApiPath;
    }

    /**
     * @param string $baseApiPath
     */
    public function setBaseApiPath( $baseApiPath )
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
    public function setRequest( $request )
    {
        $this->request = $request;
    }

}