<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementAssetEventRequest;
use Echosign\Responses\AgreementAssetEventGetResponse;
use Echosign\Responses\AgreementAssetEventPostResponse;

/**
 * Class Search
 * @package Echosign
 */
class Search extends Resource
{
    protected $baseApiPath = 'search';

    /**
     * Create a search object for agreement asset event . It will return the result for the first page and search Id
     * to fetch results for further pages.
     * @param AgreementAssetEventRequest $eventRequest
     * @param null $userId
     * @param null $userEmail
     * @return AgreementAssetEventPostResponse
     */
    public function create( AgreementAssetEventRequest $eventRequest, $userId = null, $userEmail = null)
    {
        $this->setApiRequestUrl( 'agreementAssetEvents' );
    }

    /**
     * Return the result for the page which is described inside the Page Cursor Info
     * @param $searchId
     * @param $pageCursor
     * @param null $pageSize
     * @param null $userId
     * @param null $userEmail
     * @return AgreementAssetEventGetResponse
     */
    public function result( $searchId, $pageCursor, $pageSize = null, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'agreementAssetEvents/'.$searchId );
    }
}