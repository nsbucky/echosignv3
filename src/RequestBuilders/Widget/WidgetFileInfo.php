<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class FileInfo
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetFileInfo implements RequestBuilder
{

    /**
     * @var string
     */
    public $libraryDocumentId;

    /**
     * @var string
     */
    public $transientDocumentId;

    /**
     * @var string
     */
    public $libraryDocumentName;

    /**
     * @var WidgetURLFileInfo
     */
    protected $documentURL;

    /**
     * @param $name
     * @param $url
     * @param string $mimeType
     */
    public function setDocumentURL( $name, $url, $mimeType = null )
    {
        $this->documentURL = new WidgetURLFileInfo( $name, $url, $mimeType );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $documentURL = null;

        if (isset( $this->documentURL )) {
            $documentURL = $this->documentURL->toArray();
        }

        return array_filter( [
            'libraryDocumentId'   => $this->libraryDocumentId,
            'transientDocumentId' => $this->transientDocumentId,
            'libraryDocumentName' => $this->libraryDocumentName,
            'documentURL'         => $documentURL
        ] );
    }

    /**
     * @return string
     */
    public function getLibraryDocumentId()
    {
        return $this->libraryDocumentId;
    }

    /**
     * @param string $libraryDocumentId
     */
    public function setLibraryDocumentId( $libraryDocumentId )
    {
        $this->libraryDocumentId = $libraryDocumentId;
    }

    /**
     * @return string
     */
    public function getTransientDocumentId()
    {
        return $this->transientDocumentId;
    }

    /**
     * @param string $transientDocumentId
     */
    public function setTransientDocumentId( $transientDocumentId )
    {
        $this->transientDocumentId = $transientDocumentId;
    }

    /**
     * @return string
     */
    public function getLibraryDocumentName()
    {
        return $this->libraryDocumentName;
    }

    /**
     * @param string $libraryDocumentName
     */
    public function setLibraryDocumentName( $libraryDocumentName )
    {
        $this->libraryDocumentName = $libraryDocumentName;
    }

    /**
     * @return WidgetURLFileInfo
     */
    public function getDocumentURL()
    {
        return $this->documentURL;
    }

}