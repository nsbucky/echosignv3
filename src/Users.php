<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\UserCreationInfo;
use Echosign\Responses\UserCreationResponse;
use Echosign\Responses\UsersInfo;
use Echosign\Responses\UserDetailsInfo;

class Users extends Resource
{
    protected $baseApiPath = 'users';

    /**
     * Creates a new user in the Echosign system
     * @param UserCreationInfo $userCreationInfo
     * @return UserCreationResponse
     */
    public function create( UserCreationInfo $userCreationInfo )
    {
        $response = $this->simplePostRequest( $userCreationInfo->toArray() );

        return new UserCreationResponse( $response );
    }

    /**
     * Gets all the users in an account that the caller has permissions to access
     * @param null $userEmail
     * @return UsersInfo
     */
    public function listAll( $userEmail = null )
    {
        $response = $this->simpleGetRequest( ['x-user-email'=>$userEmail] );

        return new UsersInfo( $response );
    }

    /**
     * Retrieve detailed information about the user that the caller has permissions to access
     * @param $userId
     * @return UserDetailsInfo
     */
    public function details( $userId )
    {
        $this->setApiRequestUrl( $userId );

        $response = $this->simpleGetRequest();

        return new UserDetailsInfo( $response );
    }
}