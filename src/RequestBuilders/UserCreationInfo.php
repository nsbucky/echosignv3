<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class UserCreationInfo
 * @package Echosign\RequestBuilders
 */
class UserCreationInfo implements RequestBuilder
{
    protected $optIn, $lastName, $groupId, $title, $phone,
        $email, $company, $customField3, $customField1,
        $customField2, $firstName, $password;

    /**
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     */
    public function __construct( $firstName, $lastName, $email, $password )
    {
        $this->firstName = $firstName;
        $this->lastName  = $lastName;
        $this->email     = $email;
        $this->password  = $password;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param $company
     * @return $this
     */
    public function setCompany( $company )
    {
        $this->company = $company;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomField1()
    {
        return $this->customField1;
    }

    /**
     * @param $customField1
     * @return $this
     */
    public function setCustomField1( $customField1 )
    {
        $this->customField1 = $customField1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomField2()
    {
        return $this->customField2;
    }

    /**
     * @param $customField2
     * @return $this
     */
    public function setCustomField2( $customField2 )
    {
        $this->customField2 = $customField2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomField3()
    {
        return $this->customField3;
    }

    /**
     * @param $customField3
     * @return $this
     */
    public function setCustomField3( $customField3 )
    {
        $this->customField3 = $customField3;
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
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName( $firstName )
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param string $groupId
     * @return $this
     */
    public function setGroupId( $groupId )
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return $this
     */
    public function setLastName( $lastName )
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOptIn()
    {
        return $this->optIn;
    }

    /**
     * @param $optIn
     * @return $this|void
     */
    public function setOptIn( $optIn )
    {
        if (!in_array( $optIn, [ 'YES', 'NO', 'UNKNOWN' ] )) {
            return;
        }

        $this->optIn = $optIn;
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
     * @param $password
     * @return $this
     */
    public function setPassword( $password )
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param $phone
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return $this
     */
    public function setTitle( $title )
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            "optIn"        => $this->optIn,
            "lastName"     => $this->lastName,
            "groupId"      => $this->groupId,
            "title"        => $this->title,
            "phone"        => $this->phone,
            "email"        => $this->email,
            "company"      => $this->company,
            "customField3" => $this->customField3,
            "customField1" => $this->customField1,
            "customField2" => $this->customField2,
            "firstName"    => $this->firstName,
            "password"     => $this->password
        ]);
    }
}