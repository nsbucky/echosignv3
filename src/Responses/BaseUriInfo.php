<?php
namespace Echosign\Responses;

/**
 * Class BaseUriInfo
 * @package Echosign\Responses
 */
class BaseUriInfo
{
    /**
     * @var string
     */
    public $api_access_point;

    /**
     * @var string
     */
    public $web_access_point;

    public function __construct( array $response )
    {
        foreach( [ 'api_access_point', 'web_access_point' ] as $f ) {
            if( array_found( $response, $f ) ) {
                $this->$f = $response[$f];
            }
        }
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

}