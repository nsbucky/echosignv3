<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class CounterSignerInfo
 * @package Echosign\RequestBuilders\Widget
 */
class CounterSignerInfo implements RequestBuilder
{
    protected $securityOptions;
    protected $email;
    protected $role;

    public function __construct( $email, $role, array $securityOptions = [ ] )
    {
        $this->setRole( $role );
        $this->setEmail( $email );
        $this->setSecurityOptions( $securityOptions );
    }

    /**
     * @return mixed
     */
    public function getSecurityOptions()
    {
        return $this->securityOptions;
    }

    /**
     * @param WidgetSignerSecurityOption[] $securityOptions
     * @return $this
     */
    public function setSecurityOptions( $securityOptions )
    {
        $this->securityOptions = $securityOptions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail( $email )
    {
        $this->email = filter_var( $email, FILTER_SANITIZE_EMAIL );
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRole( $role )
    {
        if (!in_array( $role, [ 'SIGNER', 'APPROVER' ] )) {
            throw new \InvalidArgumentException( 'invalid role' );
        }

        $this->role = $role;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = [
            'role'  => $this->getRole(),
            'email' => $this->getEmail(),
        ];

        if (count( $this->securityOptions ) > 0) {
            $data['securityOptions'] = [ ];
            foreach ($this->securityOptions as $o) {
                $data['securityOptions'][] = $o->toArray();
            }
        }

        return array_filter( $data );
    }

}