<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class AgreementAssetEventGetResponse
 * @package Echosign\Responses
 */
class AgreementAssetEventGetResponse implements ApiResponse
{
    /**
     * @var array
     */
    protected $response;

    /**
     * @var array
     */
    protected $events;

    /**
     * @var string
     */
    protected $nextPageCursor;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response       = $response;
        $this->nextPageCursor = Util::array_get( $response, 'nextPageCursor' );
        $this->events         = Util::array_get( $response, 'events' );
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return string
     */
    public function getNextPageCursor()
    {
        return $this->nextPageCursor;
    }

}