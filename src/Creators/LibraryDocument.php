<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\LibraryDocuments;
use Echosign\RequestBuilders\Agreement\FileInfo;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;
use Echosign\RequestBuilders\LibraryCreationInfo;
use Echosign\RequestBuilders\LibraryDocument\LibraryDocumentCreationInfo;

class LibraryDocument extends CreatorBase
{
    /**
     * @var LibraryDocuments
     */
    protected $libraryDocument;

    /**
     * @param $localFilename
     * @param $libraryFilename
     * @param $templateType
     * @param string $sharingMode
     * @return bool|string
     */
    public function createFromLocalFile( $localFilename, $libraryFilename, $templateType, $sharingMode='USER' )
    {
        // first create a transient document
        $transientDocument   = new TransientDocument( $this->getToken(), $this->getTransport() );
        $transientDocumentId = $transientDocument->create( $localFilename );

        if( $transientDocumentId === false ) {
            $this->response = $transientDocument->getResponse();
            $this->errorMessages = $transientDocument->getErrorMessages();
            return false;
        }

        $this->libraryDocument = new LibraryDocuments( $this->getToken(), $this->getTransport() );

        $fileInfo = new FileInfo();
        $fileInfo->setTransientDocumentId( $transientDocumentId );

        $docCreationInfo = new LibraryDocumentCreationInfo( $libraryFilename, $templateType, $fileInfo, $sharingMode );

        $libCreationInfo = new LibraryCreationInfo( $docCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->libraryDocument->create( $libCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getLibraryDocumentid();
    }

    /**
     * @return LibraryDocuments
     */
    public function getLibraryDocument()
    {
        return $this->libraryDocument;
    }

}