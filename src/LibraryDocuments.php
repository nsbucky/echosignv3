<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\LibraryCreationInfo;
use Echosign\Responses\DocumentLibraryItems;
use Echosign\Responses\Documents;
use Echosign\Responses\LibraryDocumentCreationResponse;
use Echosign\Responses\LibraryDocumentInfo;

/**
 * Class LibraryDocuments
 * @package Echosign
 */
class LibraryDocuments extends Resource
{
    protected $baseApiPath = 'libraryDocuments';

    /**
     * Creates a template that is placed in the user's library for reuse.
     * @param LibraryCreationInfo $libraryCreationInfo
     * @param null $userId
     * @param null $userEmail
     * @return LibraryDocumentCreationResponse
     */
    public function create( LibraryCreationInfo $libraryCreationInfo, $userId = null, $userEmail = null )
    {
        $response = $this->simplePostRequest( $libraryCreationInfo->toArray(), $userId, $userEmail );

        return new LibraryDocumentCreationResponse( $response );
    }

    /**
     * Retrieves library documents for a user.
     * @param null $userId
     * @param null $userEmail
     * @return DocumentLibraryItems
     */
    public function listAll( $userId = null, $userEmail = null )
    {
        $response = $this->simpleGetRequest( [ ], $userId, $userEmail );

        return new DocumentLibraryItems( $response );
    }

    /**
     * Retrieves the details of a library document
     * @param $libraryDocumentId
     * @return LibraryDocumentInfo
     */
    public function documentDetails( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId );

        $response = $this->simpleGetRequest();

        return new LibraryDocumentInfo( $response );
    }

    /**
     * Retrieves the ID of the document associated with library document
     * @param $libraryDocumentId
     * @return Documents
     */
    public function documentsInfo( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId . '/documents' );

        $response = $this->simpleGetRequest();

        return new Documents( $response );
    }

    /**
     * Retrieves the file stream of a library document, and saves to a local path
     * @param $libraryDocumentId
     * @param $documentId
     * @param $saveToPath
     * @return bool
     */
    public function downloadDocument( $libraryDocumentId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId . '/documents/' . $documentId );

        return $this->saveFileRequest( $saveToPath );
    }

    /**
     * Retrieves the audit trail associated with a library document, saves to a local file
     * @param $libraryDocumentId
     * @param $saveToPath
     * @return bool
     */
    public function auditTrail( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId . '/auditTrail' );

        return $this->saveFileRequest( $saveToPath );;
    }

    /**
     * Retrieves the combined document associated with a library document, saves to a local file
     * @param $libraryDocumentId
     * @param $saveToPath
     * @return bool
     */
    public function combinedDocument( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId . '/combinedDocument' );

        return $this->saveFileRequest( $saveToPath );
    }
}