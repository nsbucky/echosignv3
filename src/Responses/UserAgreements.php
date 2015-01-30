<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

/**
 * Class UserAgreements
 * @package Echosign\Responses
 */
class UserAgreements implements ApiResponse
{
    protected $userAgreementList;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response          = $response;
        $this->userAgreementList = array_get( $response, 'userAgreementList' );
    }

    /**
     * @return mixed
     */
    public function getUserAgreementList()
    {
        return $this->userAgreementList;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}