<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class SigningUrls
 * @package Echosign\Responses
 */
class SigningUrls implements ApiResponse
{
    /**
     * @var array
     */
    protected $signingUrls = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response    = $response;
        $this->signingUrls = Util::array_get( $response, 'signingUrls' );
    }

    /**
     * @return array|mixed
     */
    public function getSigningUrls()
    {
        return $this->signingUrls;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}