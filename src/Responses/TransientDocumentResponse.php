<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class TransientDocumentResponse
 * @package Echosign\Responses
 */
class TransientDocumentResponse implements ApiResponse
{
    /**
     * @var string
     */
    protected $transientDocumentId;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->transientDocumentId = array_get( $response, 'transientDocumentId');
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getTransientDocumentId()
    {
        return $this->transientDocumentId;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }
}