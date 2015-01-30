<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class AgreementStatusUpdateResponse
 * @package Echosign\Responses
 */
class AgreementStatusUpdateResponse implements ApiResponse
{
    /**
     * @var string
     */
    protected $result;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response = $response;
        $this->result   = Util::array_get( $response, 'result' );
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}