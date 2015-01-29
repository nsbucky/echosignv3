<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementCreationInfo;
use Echosign\RequestBuilders\AgreementStatusUpdateInfo;
use Echosign\Responses\AgreementCreationResponse;
use Echosign\Responses\UserAgreements;
use Echosign\Responses\AgreementInfo;
use Echosign\Responses\AgreementDocuments;
use Echosign\Responses\SigningUrls;
use Echosign\Responses\AgreementStatusUpdateResponse;

/**
 * Class Agreements
 * @package Echosign
 */
class Agreements extends Resource
{
    protected $baseApiPath = 'agreements';

    /**
     * Creates an agreement. Sends it out for signatures, and returns the agreementID in the response to the client
     * @param AgreementCreationInfo $agreementCreationInfo
     * @param null $userId
     * @param null $userEmail
     * @return AgreementCreationResponse
     */
    public function create( AgreementCreationInfo $agreementCreationInfo, $userId = null, $userEmail = null)
    {

    }

    /**
     * Retrieves agreements for the user
     * @param null $userId
     * @param null $userEmail
     * @param null $query
     * @return UserAgreements
     */
    public function listAll( $userId = null, $userEmail = null, $query = null)
    {

    }

    /**
     * Retrieves the latest status of an agreement
     * @param $agreementId
     * @return AgreementInfo
     */
    public function status( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId );
    }

    /**
     * Retrieves the IDs of all the main and supporting documents of an agreement identified by agreementid
     * @param $agreementId
     * @return AgreementDocuments
     */
    public function documents( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/documents' );
    }

    /**
     * Retrieves the stream of a document of an agreement, and saves to a local file
     * @param $agreementId
     * @param $documentId
     * @param $saveToPath
     * @return bool
     */
    public function dowmloadDocument( $agreementId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/documents/'.$documentId );
    }

    /**
     * Retrieves the audit trail of an agreement identified by agreementId, and saves to local file
     * @param $agreementId
     * @param $saveToPath
     */
    public function auditTrail( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/auditTrail' );
    }

    /**
     * @param $agreementId
     * @return SigningUrls
     */
    public function signingUrls( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/signingUrls' );
    }

    /**
     * Gets a single combined PDF document for the documents associated with an agreement, saved to a local file
     * @param $agreementId
     * @param $saveToPath
     * @return bool
     */
    public function combinedDocument( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/combinedDocument' );
    }

    /**
     * Retrieves info of all pages of a combined PDF document for the documents associated with an agreement
     * @param $agreementId
     */
    public function pagesInfo( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/combinedDocument/pagesInfo' );
    }

    /**
     * Retrieves data entered by the user into interactive form fields at the time they signed the agreement, saves
     * to a local file
     * @param $agreementId
     * @param $saveToPath
     * @return bool
     */
    public function formData( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/formData' );
    }

    /**
     * Cancels an agreement
     * @param $agreementId
     * @param AgreementStatusUpdateInfo $agreementStatusUpdateInfo
     * @return AgreementStatusUpdateResponse
     */
    public function cancel( $agreementId, AgreementStatusUpdateInfo $agreementStatusUpdateInfo )
    {
        $this->setApiRequestUrl( $agreementId.'/status' );
    }
}