<?php
namespace Echosign\Creators;

use Echosign\Agreements;
use Echosign\Exceptions\JsonApiResponseException;
use Echosign\RequestBuilders\Agreement\DocumentCreationInfo;
use Echosign\RequestBuilders\Agreement\FileInfo;
use Echosign\RequestBuilders\Agreement\InteractiveOptions;
use Echosign\RequestBuilders\AgreementCreationInfo;

class Agreement extends CreatorBase
{
    /**
     * @var Agreements
     */
    protected $agreement;

    /**
     * @var string
     */
    protected $signatureType = 'ESIGN';

    /**
     * @var string
     */
    protected $signatureFlow = 'SENDER_SIGNS_LAST';

    /**
     * @param $signerEmail
     * @param $message
     * @param $libraryDocumentId
     * @param $agreementName
     * @return bool|string
     * @internal param $signatureType
     * @internal param $signatureFlow
     */
    public function createFromLibraryDocumentId( $signerEmail, $message, $libraryDocumentId, $agreementName )
    {
        $this->agreement = new Agreements( $this->getToken(), $this->getTransport() );

        $fileInfo                    = new FileInfo();
        $fileInfo->libraryDocumentId = $libraryDocumentId;

        $docCreationInfo = new DocumentCreationInfo( $fileInfo, $agreementName, $this->getSignatureType(),
            $this->getSignatureFlow() );
        $docCreationInfo->setMessage( $message )
                        ->addRecipient( 'SIGNER', $signerEmail );

        $agreementCreationInfo = new AgreementCreationInfo( $docCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->agreement->create( $agreementCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getAgreementId();
    }

    /**
     * @param $signerEmail
     * @param $message
     * @param $libraryDocumentName
     * @param $agreementName
     * @return bool|string
     * @internal param $signatureType
     * @internal param $signatureFlow
     */
    public function createFromLibraryDocumentName( $signerEmail, $message, $libraryDocumentName, $agreementName )
    {
        $this->agreement = new Agreements( $this->getToken(), $this->getTransport() );

        $fileInfo                      = new FileInfo();
        $fileInfo->libraryDocumentName = $libraryDocumentName;

        $docCreationInfo = new DocumentCreationInfo( $fileInfo, $agreementName, $this->getSignatureType(),
            $this->getSignatureFlow() );
        $docCreationInfo->setMessage( $message )
                        ->addRecipient( 'SIGNER', $signerEmail );

        $agreementCreationInfo = new AgreementCreationInfo( $docCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->agreement->create( $agreementCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getAgreementId();
    }

    /**
     * @param $signerEmail
     * @param $message
     * @param $fileName
     * @param $url
     * @param $agreementName
     * @return bool|string
     * @internal param $signatureType
     * @internal param $signatureFlow
     */
    public function createFromUrl( $signerEmail, $message, $fileName, $url, $agreementName )
    {
        $this->agreement = new Agreements( $this->getToken(), $this->getTransport() );

        $fileInfo = new FileInfo();
        $fileInfo->setDocumentURL( $fileName, $url );

        $docCreationInfo = new DocumentCreationInfo( $fileInfo, $agreementName, $this->getSignatureType(),
            $this->getSignatureFlow() );
        $docCreationInfo->setMessage( $message )
                        ->addRecipient( 'SIGNER', $signerEmail );

        $agreementCreationInfo = new AgreementCreationInfo( $docCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->agreement->create( $agreementCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getAgreementId();
    }

    /**
     * @param $signerEmail
     * @param $message
     * @param $transientDocumentId
     * @param $agreementName
     * @return bool|string
     * @internal param $signatureType
     * @internal param $signatureFlow
     */
    public function createFromTransientDocumentId( $signerEmail, $message, $transientDocumentId, $agreementName )
    {
        $this->agreement = new Agreements( $this->getToken(), $this->getTransport() );

        $fileInfo                      = new FileInfo();
        $fileInfo->transientDocumentId = $transientDocumentId;

        $docCreationInfo = new DocumentCreationInfo( $fileInfo, $agreementName, $this->getSignatureType(),
            $this->getSignatureFlow() );
        $docCreationInfo->setMessage( $message )
                        ->addRecipient( 'SIGNER', $signerEmail );

        $agreementCreationInfo = new AgreementCreationInfo( $docCreationInfo, new InteractiveOptions() );

        try {
            $this->response = $this->agreement->create( $agreementCreationInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getAgreementId();
    }

    /**
     * create an agreement from a local file
     * @param $signerEmail
     * @param $message
     * @param $filename
     * @param $agreementName
     * @return bool|string
     * @internal param $signatureType
     * @internal param $signatureFlow
     */
    public function createTransientAgreement( $signerEmail, $message, $filename, $agreementName )
    {
        $transientDocument = new TransientDocument( $this->getToken(), $this->getTransport() );

        $transientDocumentId = $transientDocument->create( $filename );

        if ($transientDocumentId === false) {
            $this->response      = $transientDocument->getResponse();
            $this->errorMessages = $transientDocument->getErrorMessages();
            return false;
        }

        return $this->createFromTransientDocumentId( $signerEmail, $message, $transientDocumentId, $agreementName );
    }

    /**
     * @param $signerEmail
     * @param $message
     * @param $filename
     * @param $agreementName
     * @return bool|string
     */
    public function createLibraryDocumentAgreement( $signerEmail, $message, $filename, $agreementName )
    {
        $libraryDocument   = new LibraryDocument( $this->getToken(), $this->getTransport() );
        $libraryDocumentId = $libraryDocument->createFromLocalFile( $filename, basename( $filename ), 'DOCUMENT' );

        if ($libraryDocumentId === false) {
            $this->response      = $libraryDocument->getResponse();
            $this->errorMessages = $libraryDocument->getErrorMessages();
            return false;
        }

        return $this->createFromLibraryDocumentId( $signerEmail, $message, $libraryDocumentId, $agreementName );
    }

    /**
     * @return Agreements
     */
    public function getAgreement()
    {
        return $this->agreement;
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