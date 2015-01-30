<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class UserCreationResponse
 * @package Echosign\Responses
 */
class UserCreationResponse implements ApiResponse
{
    /**
     * @var
     */
    protected $userId;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
        $this->userId   = Util::array_get( $response, 'userId' );
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}