<?php
namespace Echosign\RequestBuilders\Agreement;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class FileInfo
 * @package Echosign\RequestBuilders\Agreement
 */
class FileInfo implements RequestBuilder
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
     * @var URLFileInfo
     */
    protected $documentURL;

    /**
     * @param $name
     * @param $url
     * @param string $mimeType
     */
    public function setDocumentURL( $name, $url, $mimeType = null )
    {
        $this->documentURL = new URLFileInfo( $name, $url, $mimeType );
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
     * @return $this
     */
    public function setLibraryDocumentId( $libraryDocumentId )
    {
        $this->libraryDocumentId = $libraryDocumentId;
        return $this;
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
     * @return $this
     */
    public function setTransientDocumentId( $transientDocumentId )
    {
        $this->transientDocumentId = $transientDocumentId;
        return $this;
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
     * @return $this
     */
    public function setLibraryDocumentName( $libraryDocumentName )
    {
        $this->libraryDocumentName = $libraryDocumentName;
        return $this;
    }

    /**
     * @return URLFileInfo
     */
    public function getDocumentURL()
    {
        return $this->documentURL;
    }

}