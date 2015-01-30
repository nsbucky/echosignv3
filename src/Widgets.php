<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\WidgetCreationRequest;
use Echosign\RequestBuilders\WidgetPersonalizationInfo;
use Echosign\RequestBuilders\WidgetStatusUpdateInfo;
use Echosign\Responses\WidgetCreationResponse;
use Echosign\Responses\UserWidgets;
use Echosign\Responses\WidgetInfo;
use Echosign\Responses\WidgetDocuments;
use Echosign\Responses\WidgetAgreements;
use Echosign\Responses\WidgetPersonalizeResponse;
use Echosign\Responses\WidgetStatusUpdateResponse;

class Widgets extends Resource
{
    protected $baseApiPath = 'widgets';

    /**
     * Creates a widget and returns the Javascript snippet and URL to access the widget and widgetID in response to the
     * client
     * @param WidgetCreationRequest $widgetCreationRequest
     * @param null $userId
     * @param null $userEmail
     * @return WidgetCreationResponse
     */
    public function create( WidgetCreationRequest $widgetCreationRequest, $userId = null, $userEmail = null )
    {
        $response = $this->simplePostRequest( $widgetCreationRequest->toArray(), $userId, $userEmail );

        return new WidgetCreationResponse( $response );
    }

    /**
     * @param null $userId
     * @param null $userEmail
     * @return UserWidgets
     */
    public function listAll( $userId = null, $userEmail = null )
    {
        $response = $this->simpleGetRequest( [ ], $userId, $userEmail );

        return new UserWidgets( $response );
    }

    /**
     * Retrieves the details of a widget
     * @param $widgetId
     * @return WidgetInfo
     */
    public function details( $widgetId )
    {
        $this->setApiRequestUrl( $widgetId );

        $response = $this->simpleGetRequest();

        return new WidgetInfo( $response );
    }

    /**
     * Retrieves the IDs of the documents associated with widget
     * @param $widgetId
     * @return WidgetDocuments
     */
    public function documents( $widgetId, $versionId = null, $participantEmail = null )
    {
        $this->setApiRequestUrl( $widgetId . '/documents' );

        $response = $this->simpleGetRequest( [
            'versionId'        => $versionId,
            'participantEmail' => $participantEmail
        ] );

        return new WidgetDocuments( $response );
    }

    /**
     * Retrieves the file stream of a document of a widget, saves to a local file
     * @param $widgetId
     * @param $documentId
     * @param $saveToPath
     * @return bool
     */
    public function downloadDocument( $widgetId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId . '/documents' );

        return $this->saveFileRequest( $saveToPath );
    }

    /**
     * Retrieves the audit trail of a widget identified by widgetId, saves to a local file
     * @param $widgetId
     * @param $saveToPath
     * @return bool
     */
    public function auditTrail( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId . '/auditTrail' );

        return $this->saveFileRequest( $saveToPath );
    }

    /**
     * Gets a single combined PDF document for the documents associated with a widget, saves to local file
     * @param $widgetId
     * @param $saveToPath
     * @return bool
     */
    public function combinedDocument( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId . '/combinedDocument' );

        return $this->saveFileRequest( $saveToPath );
    }

    /**
     * Retrieves data entered by the user into interactive form fields at the time they signed the widget
     * @param $widgetId
     * @param $saveToPath
     * @return bool
     */
    public function formData( $widgetId, $saveToPath )
    {
        $this->setApiRequestUrl( $widgetId . '/formData' );

        return $this->saveFileRequest( $saveToPath );
    }

    /**
     * Retrieves agreements for the widget
     * @param $widgetId
     * @return WidgetAgreements
     */
    public function agreements( $widgetId )
    {
        $this->setApiRequestUrl( $widgetId . '/agreements' );
    }

    /**
     * Personalize the widget to a signable document for a specific known user
     * @param $widgetId
     * @param WidgetPersonalizationInfo $widgetPersonalizationInfo
     * @return WidgetPersonalizeResponse
     */
    public function personalize( $widgetId, WidgetPersonalizationInfo $widgetPersonalizationInfo )
    {
        $this->setApiRequestUrl( $widgetId . '/personalize' );
    }

    /**
     * Enables or Disables a widget
     * @param $widgetId
     * @param WidgetStatusUpdateInfo $widgetStatusUpdateInfo
     * @return WidgetStatusUpdateResponse
     */
    public function updateStatus( $widgetId, WidgetStatusUpdateInfo $widgetStatusUpdateInfo )
    {
        $this->setApiRequestUrl( $widgetId . '/status' );
    }
}