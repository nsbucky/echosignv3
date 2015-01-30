<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class AgreementDocuments
 * @package Echosign\Responses
 */
class AgreementDocuments implements ApiResponse
{
    /**
     * @var array
     */
    protected $supportingDocuments = [ ];

    /**
     * @var array
     */
    protected $documents = [ ];

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response            = $response;
        $this->supportingDocuments = Util::array_get( $response, 'supportingDocuments' );
        $this->documents           = Util::array_get( $response, 'documents' );
    }

    /**
     * @return array|mixed
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return array|mixed
     */
    public function getSupportingDocuments()
    {
        return $this->supportingDocuments;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}