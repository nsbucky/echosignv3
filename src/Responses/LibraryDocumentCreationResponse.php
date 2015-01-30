<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class LibraryDocumentCreationResponse
 * @package Echosign\Responses
 */
class LibraryDocumentCreationResponse implements ApiResponse
{
    /**
     * @var string
     */
    protected $libraryDocumentid;

    /**
     * @var string
     */
    protected $embeddedCode;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response          = $response;
        $this->libraryDocumentid = Util::array_get( $response, 'libraryDocumentId' );
        $this->embeddedCode      = Util::array_get( $response, 'embeddedCode' );
        $this->url               = Util::array_get( $response, 'url' );
    }

    /**
     * @return string
     */
    public function getLibraryDocumentid()
    {
        return $this->libraryDocumentid;
    }

    /**
     * @return string
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}