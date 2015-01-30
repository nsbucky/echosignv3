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
     * @param string $userId
     * @param string $userEmail
     * @return AgreementAssetEventPostResponse
     */
    public function create( AgreementAssetEventRequest $eventRequest, $userId = null, $userEmail = null)
    {
        $this->setApiRequestUrl( 'agreementAssetEvents' );

        $response = $this->simplePostRequest( $eventRequest->toArray(), $userId, $userEmail );

        return new AgreementAssetEventPostResponse( (array) $response );
    }

    /**
     * Return the result for the page which is described inside the Page Cursor Info
     * @param $searchId
     * @param $pageCursor
     * @param int $pageSize
     * @param string $userId
     * @param string $userEmail
     * @return AgreementAssetEventGetResponse
     */
    public function result( $searchId, $pageCursor, $pageSize = 100, $userId = null, $userEmail = null )
    {
        $query = [
            'searchId'   => $searchId,
            'pageCursor' => $pageCursor,
            'pageSize'   => $pageSize
        ];

        $this->setApiRequestUrl( 'agreementAssetEvents/'.$searchId );

        $response = $this->simpleGetRequest( $query, $userId, $userEmail );

        return new AgreementAssetEventGetResponse( $response );
    }
}