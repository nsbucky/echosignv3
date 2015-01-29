<?php
namespace Echosign\Abstracts;

use Echosign\Interfaces\HttpTransport;

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
     * @var string like 2AAABLblqZHAOTq69TB7lw_5rx_oac1yvBWb0bAYSMFANpqivZmuGyu6qOA6WY8PV1AZ3Rnyg0jY*
     */
    protected $oAuthToken;

    /**
     * @var mixed
     */
    protected $responseReceived;

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
        return $this->getApiEndPoint() .'/' . $this->getApiRequestUrl();
    }
}