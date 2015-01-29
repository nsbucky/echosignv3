<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementAssetListRequest;
use Echosign\RequestBuilders\AgreementAssetRequest;
use Echosign\RequestBuilders\TargetViewRequest;

class Views extends Resource
{
    protected $baseApiPath = 'views';

    public function agreementAssets( AgreementAssetRequest $agreementAssetRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'agreementAssets' );
    }

    public function agreementAssetList( AgreementAssetListRequest $listRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'agreementAssetList' );
    }

    public function settings(TargetViewRequest $targetViewRequest, $userId = null, $userEmail = null )
    {
        $this->setApiRequestUrl( 'settings' );
    }
}