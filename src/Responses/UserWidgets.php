<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class UserWidgets
 * @package Echosign\Responses
 */
class UserWidgets implements ApiResponse
{
    protected $userWidgetList = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response       = $response;
        $this->userWidgetList = Util::array_get( $response, 'userWidgetList' );
    }

    /**
     * @return array|mixed
     */
    public function getUserWidgetList()
    {
        return $this->userWidgetList;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}