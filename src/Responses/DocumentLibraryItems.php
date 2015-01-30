<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class DocumentLibraryItems
 * @package Echosign\Responses
 */
class DocumentLibraryItems implements ApiResponse
{
    /**
     * @var array
     */
    protected $libraryDocumentList = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response            = $response;
        $this->libraryDocumentList = Util::array_get( $response, 'libraryDocumentList' );
    }

    /**
     * @return array
     */
    public function getLibraryDocumentList()
    {
        return $this->libraryDocumentList;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}