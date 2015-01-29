<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\AgreementCreationInfo;
use Echosign\RequestBuilders\AgreementStatusUpdateInfo;

class Agreements extends Resource
{
    protected $baseApiPath = 'agreements';

    public function create( AgreementCreationInfo $agreementCreationInfo, $userId = null, $userEmail = null)
    {

    }

    public function listAll( $userId = null, $userEmail = null, $query = null)
    {

    }

    public function status( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId );
    }

    public function documents( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/documents' );
    }

    public function dowmloadDocument( $agreementId, $documentId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/documents/'.$documentId );
    }

    public function auditTrail( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/auditTrail' );
    }

    public function signingUrls( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/signingUrls' );
    }

    public function combinedDocument( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/combinedDocument' );
    }

    public function pagesInfo( $agreementId )
    {
        $this->setApiRequestUrl( $agreementId.'/combinedDocument/pagesInfo' );
    }

    public function formData( $agreementId, $saveToPath )
    {
        $this->setApiRequestUrl( $agreementId.'/formData' );
    }

    public function cancel( $agreementId, AgreementStatusUpdateInfo $agreementStatusUpdateInfo )
    {
        $this->setApiRequestUrl( $agreementId.'/status' );
    }
}