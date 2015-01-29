<?php
namespace Echosign\Responses;

/**
 * Class TransientDocumentResponse
 * @package Echosign\Responses
 */
class TransientDocumentResponse
{
    /**
     * @var string
     */
    protected $transientDocumentId;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->transientDocumentId = array_get( $response, 'transientDocumentId');
    }

    /**
     * @return string
     */
    public function getTransientDocumentId()
    {
        return $this->transientDocumentId;
    }
}