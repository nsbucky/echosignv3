<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class CombinedDocumentPagesInfo
 * @package Echosign\Responses
 */
class CombinedDocumentPagesInfo implements ApiResponse
{
    /**
     * @var array
     */
    protected $documentPagesInfo = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response          = $response;
        $this->documentPagesInfo = array_get( $response, 'documentPagesInfo' );
    }

    /**
     * @return array
     */
    public function getDocumentPagesInfo()
    {
        return $this->documentPagesInfo;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}