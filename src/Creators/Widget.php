<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;
use Echosign\RequestBuilders\Widget\WidgetCreationInfo;
use Echosign\RequestBuilders\Widget\WidgetFileInfo;
use Echosign\RequestBuilders\WidgetCreationRequest;
use Echosign\Widgets;

class Widget extends CreatorBase
{
    /**
     * @var Widgets
     */
    protected $widget;

    /**
     * @var string
     */
    protected $signatureType = 'ESIGN';

    /**
     * @var string
     */
    protected $signatureFlow = 'SENDER_SIGNS_LAST';

    /**
     * Create a transient document from a local filepath, then create a widget for use with that transient document. This
     * function returns the url for the widget. You can use $this->getResponse() to get the widget object.
     * @param $fileName
     * @param $widgetName
     * @return bool|string
     */
    public function createTransientWidgetFromLocalFile( $fileName, $widgetName )
    {
        $transientDocument = new TransientDocument( $this->getToken(), $this->getTransport() );

        $transientDocumentId = $transientDocument->create( $fileName );

        if ($transientDocumentId === false) {
            $this->response      = $transientDocument->getResponse();
            $this->errorMessages = $transientDocument->getErrorMessages();
            return false;
        }

        $this->widget = new Widgets( $this->getToken(), $this->getTransport() );

        $fileInfo = new WidgetFileInfo();
        $fileInfo->setTransientDocumentId( $transientDocumentId );

        $widgetCreationInfo = new WidgetCreationInfo( $widgetName, $this->getSignatureFlow(), $fileInfo );

        $widgetRequest = new WidgetCreationRequest( $widgetCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->widget->create( $widgetRequest );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getUrl();
    }

    /**
     * Create a library document from a local file, then create a widget for that document. If successful it returns the
     * url to the widget. You can use $this->getResponse() to get the widget object.
     * @param $fileName
     * @param $widgetName
     * @return bool|string
     */
    public function createLibraryDocumentWidgetFromLocalFile( $fileName, $widgetName )
    {
        $libraryDocument   = new LibraryDocument( $this->getToken(), $this->getTransport() );
        $libraryDocumentId = $libraryDocument->createFromLocalFile( $fileName, basename( $fileName ), 'DOCUMENT' );

        if ($libraryDocumentId === false) {
            $this->response      = $libraryDocument->getResponse();
            $this->errorMessages = $libraryDocument->getErrorMessages();
            return false;
        }

        $this->widget = new Widgets( $this->getToken(), $this->getTransport() );

        $fileInfo = new WidgetFileInfo();
        $fileInfo->setLibraryDocumentId( $libraryDocumentId );

        $widgetCreationInfo = new WidgetCreationInfo( $widgetName, $this->getSignatureFlow(), $fileInfo );

        $widgetRequest = new WidgetCreationRequest( $widgetCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->widget->create( $widgetRequest );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getUrl();
    }

    /**
     * @return Widgets
     */
    public function getWidget()
    {
        return $this->widget;
    }

    /**
     * @return string
     */
    public function getSignatureType()
    {
        return $this->signatureType;
    }

    /**
     * @param string $signatureType
     * @return $this
     */
    public function setSignatureType( $signatureType )
    {
        $this->signatureType = $signatureType;
        return $this;
    }

    /**
     * @return string
     */
    public function getSignatureFlow()
    {
        return $this->signatureFlow;
    }

    /**
     * @param string $signatureFlow
     * @return $this
     */
    public function setSignatureFlow( $signatureFlow )
    {
        $this->signatureFlow = $signatureFlow;
        return $this;
    }
}