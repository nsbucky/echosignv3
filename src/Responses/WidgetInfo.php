<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class WidgetInfo implements ApiResponse
{
    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}