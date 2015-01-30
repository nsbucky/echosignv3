<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class AgreementAssetListRequest
 * @package Echosign\RequestBuilders
 */
class AgreementAssetListRequest implements RequestBuilder
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
     * @param bool $autoLogin
     */
    public function setAutoLogin( $autoLogin )
    {
        $this->autoLogin = (bool) $autoLogin;
    }

    /**
     * @return bool
     */
    public function getNoChrome()
    {
        return $this->noChrome;
    }

    /**
     * @param bool $noChrome
     */
    public function setNoChrome( $noChrome )
    {
        $this->noChrome = (bool) $noChrome;
    }

    /**
     * @return string
     */
    public function getAgreementAssetId()
    {
        return $this->agreementAssetId;
    }

    /**
     * @param mixed $agreementAssetId
     */
    public function setAgreementAssetId( $agreementAssetId )
    {
        $this->agreementAssetId = $agreementAssetId;
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