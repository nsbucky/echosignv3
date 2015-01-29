<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\LibraryCreationInfo;
use Echosign\Responses\LibraryDocumentCreationResponse;
use Echosign\Responses\DocumentLibraryItems;
use Echosign\Responses\LibraryDocumentInfo;
use Echosign\Responses\Documents;

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

    }

    /**
     * Retrieves library documents for a user.
     * @param null $userId
     * @param null $userEmail
     * @return DocumentLibraryItems
     */
    public function listAll( $userId = null, $userEmail = null )
    {

    }

    /**
     * Retrieves the details of a library document
     * @param $libraryDocumentId
     * @return LibraryDocumentInfo
     */
    public function documentDetails( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId );
    }

    /**
     * Retrieves the ID of the document associated with library document
     * @param $libraryDocumentId
     * @return Documents
     */
    public function documentsInfo( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/documents');
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
        $this->setApiRequestUrl( $libraryDocumentId .'/documents/'.$documentId );
    }

    /**
     * Retrieves the audit trail associated with a library document, saves to a local file
     * @param $libraryDocumentId
     * @param $saveToPath
     * @return bool
     */
    public function auditTrail( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/auditTrail' );
    }

    /**
     * Retrieves the combined document associated with a library document, saves to a local file
     * @param $libraryDocumentId
     * @param $saveToPath
     * @return bool
     */
    public function combinedDocument( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/combinedDocument' );
    }
}