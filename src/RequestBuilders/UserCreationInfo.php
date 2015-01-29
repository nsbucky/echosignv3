<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;

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
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param mixed $company
     */
    public function setCompany( $company )
    {
        $this->company = $company;
    }

    /**
     * @return mixed
     */
    public function getCustomField1()
    {
        return $this->customField1;
    }

    /**
     * @param mixed $customField1
     */
    public function setCustomField1( $customField1 )
    {
        $this->customField1 = $customField1;
    }

    /**
     * @return mixed
     */
    public function getCustomField2()
    {
        return $this->customField2;
    }

    /**
     * @param mixed $customField2
     */
    public function setCustomField2( $customField2 )
    {
        $this->customField2 = $customField2;
    }

    /**
     * @return mixed
     */
    public function getCustomField3()
    {
        return $this->customField3;
    }

    /**
     * @param mixed $customField3
     */
    public function setCustomField3( $customField3 )
    {
        $this->customField3 = $customField3;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail( $email )
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName( $firstName )
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId( $groupId )
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName( $lastName )
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getOptIn()
    {
        return $this->optIn;
    }

    /**
     * @param mixed $optIn
     */
    public function setOptIn( $optIn )
    {
        if( ! in_array( $optIn, ['YES','NO','UNKNOWN']) ) {
            return;
        }

        $this->optIn = $optIn;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword( $password )
    {
        $this->password = $password;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle( $title )
    {
        $this->title = $title;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
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
        ];
    }
}