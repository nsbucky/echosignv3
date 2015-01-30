<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;
use Echosign\Util;

/**
 * Class WidgetAgreements
 * @package Echosign\Responses
 */
class WidgetAgreements implements ApiResponse
{
    protected $userAgreementList = [ ];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response          = $response;
        $this->userAgreementList = Util::array_get( $response, 'userAgreementList' );
    }

    /**
     * @return array
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