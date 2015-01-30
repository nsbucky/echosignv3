<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

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
     * @param mixed $phone
     */
    public function setPhone( $phone )
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode( $countryCode )
    {
        $this->countryCode = $countryCode;
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