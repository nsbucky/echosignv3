<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class WidgetSignerSecurityOption
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetSignerSecurityOption implements RequestBuilder
{
    protected $authenticationMethod;
    protected $phoneInfos = [ ];
    protected $password;

    public function __construct( $authenticationMethod, array $phoneInfos = [ ], $password )
    {
        $this->setAuthenticationMethod( $authenticationMethod );
        $this->phoneInfos = $phoneInfos;
        $this->password   = $password;

        if ($this->authenticationMethod == 'PHONE' && count( $phoneInfos ) < 1) {
            throw new \RuntimeException( 'You must specify phoneInfos if authenticationMethod is set to PHONE' );
        }
    }

    /**
     * @return mixed
     */
    public function getAuthenticationMethod()
    {
        return $this->authenticationMethod;
    }

    /**
     * @param mixed $authenticationMethod
     * @return $this
     */
    public function setAuthenticationMethod( $authenticationMethod )
    {
        if (!in_array( $authenticationMethod,
            [ 'INHERITED_FROM_DOCUMENT', 'KBA', 'PASSWORD', 'WEB_IDENTITY', 'PHONE', 'NONE' ] )
        ) {
            throw new \InvalidArgumentException( 'Invalid authentication method' );
        }

        $this->authenticationMethod = $authenticationMethod;
        return $this;
    }

    /**
     * @return array
     */
    public function getPhoneInfos()
    {
        return $this->phoneInfos;
    }

    /**
     * @param array $phoneInfos
     * @return $this
     */
    public function setPhoneInfos( $phoneInfos )
    {
        $this->phoneInfos = $phoneInfos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword( $password )
    {
        $this->password = $password;
        return $this;
    }


    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'authenticationMethod' => $this->authenticationMethod,
            'password'             => $this->password,
        ];

        if (count( $this->phoneInfos ) > 0) {
            $data['phoneInfos'] = [ ];
            foreach ($this->phoneInfos as $t) {
                $data['phoneInfos'][] = $t->toArray();
            }
        }

        return array_filter( $data );
    }

}