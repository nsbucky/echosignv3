<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class WidgetStatusUpdateResponse
 * @package Echosign\Responses
 */
class WidgetStatusUpdateResponse implements ApiResponse
{
    protected $message;
    protected $code;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
        $this->message  = array_get( $response, 'message' );
        $this->code     = array_get( $response, 'code' );
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}