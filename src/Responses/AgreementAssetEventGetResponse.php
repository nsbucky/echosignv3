<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

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
        $this->nextPageCursor = array_get( $response, 'nextPageCursor' );
        $this->events         = array_get( $response, 'events' );
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