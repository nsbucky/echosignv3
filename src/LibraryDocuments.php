<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\LibraryCreationInfo;
use Echosign\Requests\GetRequest;
use Echosign\Requests\PostRequest;
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
        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        if( $userId && $userEmail ) {
            $request->setHeader('x-user-id', $userId);
            $request->setHeader('x-user-email', $userEmail);
        }

        $request->setBody( $libraryCreationInfo->toArray() );

        $this->setRequest( $request );
        $this->logDebug( "Creating POST request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

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
        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        if( $userId && $userEmail ) {
            $request->setHeader('x-user-id', $userId);
            $request->setHeader('x-user-email', $userEmail);
        }

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

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

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new LibraryDocumentInfo( $response );
    }

    /**
     * Retrieves the ID of the document associated with library document
     * @param $libraryDocumentId
     * @return Documents
     */
    public function documentsInfo( $libraryDocumentId )
    {
        $this->setApiRequestUrl( $libraryDocumentId .'/documents');

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $response  = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

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
        $this->setApiRequestUrl( $libraryDocumentId .'/documents/'.$documentId );

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setSaveFilePath( $saveToPath );
        $request->setJsonRequest(false);

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $transport->handleRequest( $request );

        $this->logDebug( "tried to write to file: ".$saveToPath );

        return file_exists( $saveToPath );
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

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setSaveFilePath( $saveToPath );
        $request->setJsonRequest(false);

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $transport->handleRequest( $request );

        $this->logDebug( "tried to write to file: ".$saveToPath );

        return file_exists( $saveToPath );
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

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setSaveFilePath( $saveToPath );
        $request->setJsonRequest(false);

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $transport = $this->getTransport();
        $transport->handleRequest( $request );

        $this->logDebug( "tried to write to file: ".$saveToPath );

        return file_exists( $saveToPath );
    }
}