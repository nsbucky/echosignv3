<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class WidgetCreationResponse
 * @package Echosign\Responses
 */
class WidgetCreationResponse implements ApiResponse
{
    protected $javascript;
    protected $widgetId;
    protected $url;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response   = $response;
        $this->javascript = array_get( $response, 'javascript' );
        $this->widgetId   = array_get( $response, 'widgetId' );
        $this->url        = array_get( $response, 'url' );
    }

    /**
     * @return mixed
     */
    public function getJavascript()
    {
        return $this->javascript;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getWidgetId()
    {
        return $this->widgetId;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}