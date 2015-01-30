<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class BaseUriInfo
 * @package Echosign\Responses
 */
class BaseUriInfo implements ApiResponse
{
    /**
     * @var string
     */
    public $api_access_point;

    /**
     * @var string
     */
    public $web_access_point;

    /**
     * @var array
     */
    protected $response;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        foreach ([ 'api_access_point', 'web_access_point' ] as $f) {
            if (array_found( $response, $f )) {
                $this->$f = $response[$f];
            }
        }

        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getApiAccessPoint()
    {
        return $this->api_access_point;
    }

    /**
     * @return string
     */
    public function getWebAccessPoint()
    {
        return $this->web_access_point;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}