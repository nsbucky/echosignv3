<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class PhoneInfo
 * @package Echosign\RequestBuilders\Widget
 */
class PhoneInfo implements RequestBuilder
{
    protected $phone;
    protected $countryCode;

    public function __construct( $phone, $countryCode = null )
    {
        $this->phone       = $phone;
        $this->countryCode = $countryCode;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return $this
     */
    public function setPhone( $phone )
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode( $countryCode )
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'phone'       => $this->phone,
            'countryCode' => $this->countryCode
        ] );
    }

}