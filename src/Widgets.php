<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\WidgetCreationRequest;
use Echosign\RequestBuilders\WidgetPersonalizationInfo;
use Echosign\RequestBuilders\WidgetStatusUpdateInfo;

class Widgets extends Resource
{
    protected $baseApiPath = 'widgets';

    public function create( WidgetCreationRequest $widgetCreationRequest, $userId = null, $userEmail = null )
    {

    }

    public function listAll( $userId = null, $userEmail = null )
    {

    }

    public function details( $widgetId )
    {
        $this->setApiRequestUrl( $widgetId );
    }

    public function documents( $widgetId )
    {
        $this->setApiRequestUrl( $widgetId .'/documents' );
    }

    public function downloadDocument( $widgetId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId .'/documents' );
    }

    public function auditTrail( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId .'/auditTrail' );
    }

    public function combinedDocument( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId .'/combinedDocument' );
    }

    public function formData( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId .'/formData' );
    }

    public function agreements( $widgetId )
    {
        $this->setApiRequestUrl( $widgetId .'/agreements' );
    }

    public function personalize( $widgetId, WidgetPersonalizationInfo $widgetPersonalizationInfo )
    {
        $this->setApiRequestUrl( $widgetId .'/personalize' );
    }

    public function updateStatus( $widgetId, WidgetStatusUpdateInfo $widgetStatusUpdateInfo )
    {
        $this->setApiRequestUrl( $widgetId .'/status' );
    }
}