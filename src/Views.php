<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementAssetListRequest;
use Echosign\RequestBuilders\AgreementAssetRequest;
use Echosign\RequestBuilders\TargetViewRequest;
use Echosign\Requests\PostRequest;
use Echosign\Responses\ViewUrl;

class Views extends Resource
{
    protected $baseApiPath = 'views';

    /**
     * Returns the URL which shows the view page of given agreement asset
     * @param AgreementAssetRequest $agreementAssetRequest
     * @param null $userId
     * @param null $userEmail
     * @return ViewUrl
     */
    public function agreementAssets( AgreementAssetRequest $agreementAssetRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'agreementAssets' );

        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setBody( $agreementAssetRequest->toArray() );

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

        return new ViewUrl( $response );
    }

    /**
     * Returns the URL for manage page
     * @param AgreementAssetListRequest $listRequest
     * @param null $userId
     * @param null $userEmail
     * @return ViewUrl
     */
    public function agreementAssetList( AgreementAssetListRequest $listRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'agreementAssetList' );

        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setBody( $listRequest->toArray() );

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

        return new ViewUrl( $response );
    }

    /**
     * Returns the URL for settings page
     * @param TargetViewRequest $targetViewRequest
     * @param null $userId
     * @param null $userEmail
     * @return ViewUrl
     */
    public function settings( TargetViewRequest $targetViewRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'settings' );

        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setBody( $targetViewRequest->toArray() );

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

        return new ViewUrl( $response );
    }
}