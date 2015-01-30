<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class AgreementAssetEventPostResponse
 * @package Echosign\Responses
 */
class AgreementAssetEventPostResponse implements ApiResponse
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
    protected $currentPageCursor;

    /**
     * @var string
     */
    protected $searchId;

    /**
     * @var string
     */
    protected $nextPageCursor;

    /**
     * @param array $response
     */
    public function __construct( array $response )
    {
        $this->response          = $response;
        $this->currentPageCursor = array_get( $response, 'currentPageCursor' );
        $this->searchId          = array_get( $response, 'searchId' );
        $this->nextPageCursor    = array_get( $response, 'nextPageCursor' );
        $this->events            = array_get( $response, 'events' );
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return string
     */
    public function getCurrentPageCursor()
    {
        return $this->currentPageCursor;
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

    /**
     * @return string
     */
    public function getSearchId()
    {
        return $this->searchId;
    }
}