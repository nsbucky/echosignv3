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
     * @param string $email
     * @param string $fax
     * @param string $role
     */
    public function __construct( $email = null, $fax = null, $role = null )
    {
        $this->email = filter_var( $email, FILTER_SANITIZE_EMAIL );
        $this->fax   = filter_var( $fax, FILTER_SANITIZE_NUMBER_INT );

        if (!in_array( $role, [ 'SIGNER', 'APPROVER' ] )) {
            $role = null;
        }

        $this->role = $role;
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