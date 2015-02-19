<?php
namespace Echosign\Creators;

use Echosign\Exceptions\JsonApiResponseException;
use Echosign\RequestBuilders\UserCreationInfo;
use Echosign\Users;

class User extends CreatorBase
{
    /**
     * @var Users
     */
    protected $user;

    /**
     * Create a new user in your echosign account.
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @return bool|mixed
     */
    public function create($firstName, $lastName, $email, $password)
    {
        $this->user = new Users( $this->getToken(), $this->getTransport() );
        $userInfo   = new UserCreationInfo( $firstName, $lastName, $email, $password );

        try {
            $this->response = $this->user->create( $userInfo );
        } catch ( JsonApiResponseException $e ) {
            $this->errorMessages[ $e->getCode() ] = sprintf( '%s - %s', $e->getApiCode(), $e->getMessage() );
            return false;
        } catch ( \Exception $e ) {
            $this->errorMessages[ $e->getCode() ] = $e->getMessage();
            return false;
        }

        return $this->response->getUserId();
    }

    /**
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

}