<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class DocumentLibraryItems implements ApiResponse
{
    /**
     * @var array
     */
    protected $libraryDocumentList = [];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
        $this->libraryDocumentList = array_get( $response, 'libraryDocumentList' );
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