<?php
namespace Echosign\Exceptions;

/**
 * Class JsonApiResponseException
 * @package Echosign\Exceptions
 */
class JsonApiResponseException extends \Exception
{
    protected $apiCode;

    public function __construct( $httpCode, $message, $apiCode )
    {
        $this->apiCode = $apiCode;
        parent::__construct( $message, $httpCode );
    }

    /**
     * @return \Exception
     */
    public function getApiCode()
    {
        return $this->apiCode;
    }

}