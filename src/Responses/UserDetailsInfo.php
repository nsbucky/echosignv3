<?php
namespace Echosign\Responses;

use Echosign\Interfaces\ApiResponse;

class UserDetailsInfo implements ApiResponse
{
    protected $lastName, $phone, $locale, $passwordExpiration,
    $title, $email, $initials, $company, $accountType,
    $account, $firstName, $group, $channel;

    protected $capabilityFlags = [];
    protected $roles = [];

    /**
     * @var array
     */
    protected $response;

    public function __construct( array $response )
    {
        $this->response = $response;

        foreach( ['lastName', 'phone', 'locale', 'passwordExpiration', 'roles',
                  'title', 'email', 'initials', 'company', 'accountType',
                  'account', 'firstName', 'group', 'channel', 'capabilityFlags'] as $k  ) {
            $this->$k = array_get( $response, $k );
        }
    }

    /**
     * @return mixed
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @return array
     */
    public function getCapabilityFlags()
    {
        return $this->capabilityFlags;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @return mixed
     */
    public function getInitials()
    {
        return $this->initials;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return mixed
     */
    public function getPasswordExpiration()
    {
        return $this->passwordExpiration;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }



    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

}