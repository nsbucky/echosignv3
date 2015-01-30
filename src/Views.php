<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementAssetListRequest;
use Echosign\RequestBuilders\AgreementAssetRequest;
use Echosign\RequestBuilders\TargetViewRequest;
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

        $response = $this->simplePostRequest( $agreementAssetRequest->toArray(), $userId, $userEmail );

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

        $response = $this->simplePostRequest( $listRequest->toArray(), $userId, $userEmail );

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

        $response = $this->simplePostRequest( $targetViewRequest->toArray(), $userId, $userEmail );

        return new ViewUrl( $response );
    }
}