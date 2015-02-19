<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class AgreementAssetRequest
 * @package Echosign\RequestBuilders
 */
class AgreementAssetRequest implements RequestBuilder
{
    /**
     * @var bool
     */
    protected $noChrome;

    /**
     * @var string
     */
    protected $agreementAssetId;

    /**
     * @var bool
     */
    protected $autoLogin;

    /**
     * @param string $agreementAssetId
     * @param bool $noChrome
     * @param bool $autoLogin
     */
    public function __construct( $agreementAssetId, $noChrome = false, $autoLogin = false )
    {
        $this->agreementAssetId = $agreementAssetId;
        $this->noChrome         = (bool) $noChrome;
        $this->autoLogin        = (bool) $autoLogin;
    }

    /**
     * @return bool
     */
    public function getAutoLogin()
    {
        return $this->autoLogin;
    }

    /**
     * @param $autoLogin
     * @return $this
     */
    public function setAutoLogin( $autoLogin )
    {
        $this->autoLogin = (bool) $autoLogin;
        return $this;
    }

    /**
     * @return string
     */
    public function getNoChrome()
    {
        return $this->noChrome;
    }

    /**
     * @param $noChrome
     * @return $this
     */
    public function setNoChrome( $noChrome )
    {
        $this->noChrome = (bool) $noChrome;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgreementAssetId()
    {
        return $this->agreementAssetId;
    }

    /**
     * @param $agreementAssetId
     * @return $this
     */
    public function setAgreementAssetId( $agreementAssetId )
    {
        $this->agreementAssetId = $agreementAssetId;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'noChrome'         => $this->noChrome,
            'agreementAssetId' => $this->agreementAssetId,
            'autoLogin'        => $this->autoLogin,
        ];
    }
}