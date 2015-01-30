<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

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
        $this->currentPageCursor = Util::array_get( $response, 'currentPageCursor' );
        $this->searchId          = Util::array_get( $response, 'searchId' );
        $this->nextPageCursor    = Util::array_get( $response, 'nextPageCursor' );
        $this->events            = Util::array_get( $response, 'events' );
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