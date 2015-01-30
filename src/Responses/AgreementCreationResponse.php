<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class AgreementCreationResponse implements ApiResponse
{
    /**
     * @var string
     */
    protected $expiration;

    /**
     * @var string
     */
    protected $agreementId;

    /**
     * @var string
     */
    protected $embeddedCode;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response     = $response;
        $this->expiration   = array_get( $response, 'expiration' );
        $this->agreementId  = array_get( $response, 'agreementId' );
        $this->embeddedCode = array_get( $response, 'embeddedCode' );
        $this->url          = array_get( $response, 'url' );
    }

    /**
     * @return string
     */
    public function getAgreementId()
    {
        return $this->agreementId;
    }

    /**
     * @return string
     */
    public function getEmbeddedCode()
    {
        return $this->embeddedCode;
    }

    /**
     * @return string
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}