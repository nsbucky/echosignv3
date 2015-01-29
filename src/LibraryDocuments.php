<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\LibraryCreationInfo;
use Echosign\Responses\LibraryDocumentCreationResponse;
use Echosign\Responses\DocumentLibraryItems;

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
     */
    public function documentDetails( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId );
    }

    public function documentsInfo( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/documents');
    }

    public function downloadDocument( $libraryDocumentId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/documents/'.$documentId );
    }

    public function auditTrail( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/auditTrail' );
    }

    public function combinedDocument( $libraryDocumentId, $saveToPath )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/combinedDocument' );
    }
}