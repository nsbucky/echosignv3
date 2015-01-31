<?php
namespace Echosign\RequestBuilders\Agreement;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class RecipientInfo
 * @package Echosign\RequestBuilders\Agreement
 */
class RecipientInfo implements RequestBuilder
{

    /**
     * @var string
     */
    public $fax;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $role;

    /**
     * You must specify email OR fax, but not both.
     * @param string $role
     * @param string $email
     * @param string $fax
     * @throws \RuntimeException
     */
    public function __construct( $role, $email = null, $fax = null )
    {
        if (!in_array( $role, [ 'SIGNER', 'APPROVER' ] )) {
            throw new \InvalidArgumentException('Invalid role given');
        }

        $this->role = $role;

        if( $email && $fax ) {
            throw new \RuntimeException("You must specify email OR fax, but NOT BOTH");
        }

        $this->email = filter_var( $email, FILTER_SANITIZE_EMAIL );
        $this->fax   = filter_var( $fax, FILTER_SANITIZE_NUMBER_INT );
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'fax'   => $this->fax,
            'email' => $this->email,
            'role'  => $this->role
        ] );
    }

}