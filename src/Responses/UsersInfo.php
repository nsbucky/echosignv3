<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class UsersInfo implements ApiResponse
{
    protected $userInfoList = [];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
        $this->userInfoList = array_get( $response, 'userInfoList');
    }

    /**
     * @return array|mixed
     */
    public function getUserInfoList()
    {
        return $this->userInfoList;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}