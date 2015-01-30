<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

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
        $this->documentPagesInfo = Util::array_get( $response, 'documentPagesInfo' );
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