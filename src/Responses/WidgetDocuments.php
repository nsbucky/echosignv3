<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class WidgetDocuments
 * @package Echosign\Responses
 */
class WidgetDocuments implements ApiResponse
{
    protected $documents = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response  = $response;
        $this->documents = Util::array_get( $response, 'documents' );
    }

    /**
     * @return array|mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}