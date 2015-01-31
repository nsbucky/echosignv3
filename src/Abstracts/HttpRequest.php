<?php
namespace Echosign\Abstracts;

use Echosign\Interfaces\RequestEntity;

/**
 * Class HttpRequest
 * @package Echosign\Abstracts
 */
abstract class HttpRequest implements RequestEntity
{
    protected $headers = [ ];
    protected $body = [ ];
    protected $oAuthToken;
    protected $fileSavePath;
    protected $requestUrl;
    protected $jsonRequest = true;

    /**
     * @param $oAuthToken
     */
    public function __construct( $oAuthToken, $requestUrl = null )
    {
        $this->setOAuthToken( $oAuthToken );
        $this->requestUrl = $requestUrl;
    }

    /**
     * @param $url
     * @return void
     */
    public function setRequestUrl( $url )
    {
        $this->requestUrl = $url;
    }

    /**
     * @return string|null
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        // just trying to make sure that the Access-Token header is always there.
        // its needed for every request.
        $this->setOAuthToken( $this->getOAuthToken() );

        if( $this->isJsonRequest() ) {
            $this->setHeader('Content-Type', 'application/json');
        }

        return array_unique( $this->headers );
    }

    /**
     * @param array $headers
     */
    public function setHeaders( array $headers )
    {
        $this->headers = $headers;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setHeader( $key, $value )
    {
        $this->headers[$key] = $value;
    }

    /**
     * @param $oAuthToken
     */
    public function setOAuthToken( $oAuthToken )
    {
        $this->oAuthToken = $oAuthToken;
        $this->setHeader( 'Access-Token', $oAuthToken );
    }

    /**
     * @return mixed
     */
    public function getOAuthToken()
    {
        return $this->oAuthToken;
    }

    /**
     * @return string
     */
    abstract public function getRequestMethod();

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param array $body
     */
    public function setBody( array $body )
    {
        $this->body = $body;
    }

    /**
     * @return null|string
     */
    public function getFileSavePath()
    {
        return $this->fileSavePath;
    }

    /**
     * @param $saveFilePath
     */
    public function setFileSavePath( $saveFilePath )
    {
        $path = pathinfo( $saveFilePath, PATHINFO_DIRNAME );

        if (!is_writable( $path )) {
            throw new \RuntimeException( $path . ' must be writable' );
        }

        $this->fileSavePath = $saveFilePath;
    }

    /**
     * @return bool
     */
    public function saveResponseToFile()
    {
        $path = $this->getFileSavePath();

        return !empty( $path );
    }

    /**
     * @return boolean
     */
    public function isJsonRequest()
    {
        return (bool) $this->jsonRequest;
    }

    /**
     * @param boolean $jsonRequest
     */
    public function setJsonRequest( $jsonRequest )
    {
        $this->jsonRequest = (bool) $jsonRequest;
    }

}