<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class ViewUrl implements ApiResponse
{
    protected $viewUrl;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
        $this->viewUrl = array_get( $response, 'viewUrl' );
    }

    /**
     * @return mixed
     */
    public function getViewUrl()
    {
        return $this->viewUrl;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}