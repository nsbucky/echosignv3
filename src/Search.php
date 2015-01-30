<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementAssetEventRequest;
use Echosign\Requests\GetRequest;
use Echosign\Requests\PostRequest;
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

        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setBody( $eventRequest->toArray() );

        if( $userId && $userEmail ) {
            $request->setHeader('x-user-id', $userId);
            $request->setHeader('x-user-email', $userEmail);
        }

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating POST request to ".$this->getRequestUrl() );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

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

        $request =  new GetRequest( $this->getOAuthToken(), $this->getRequestUrl( $query ) );

        if( $userId && $userEmail ) {
            $request->setHeader('x-user-id', $userId);
            $request->setHeader('x-user-email', $userEmail);
        }

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl( $query ) );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new AgreementAssetEventGetResponse( $response );
    }
}