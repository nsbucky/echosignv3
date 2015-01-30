<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class Documents
 * @package Echosign\Responses
 */
class Documents implements ApiResponse
{
    /**
     * @var array
     */
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
     * @return array
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