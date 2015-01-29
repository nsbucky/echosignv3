<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\UserCreationInfo;
use Echosign\Requests\GetRequest;
use Echosign\Requests\PostRequest;
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
        $request = new PostRequest( $this->getOAuthToken(), $this->getRequestUrl() );
        $request->setBody( $userCreationInfo->toArray() );

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating POST request to ".$this->getRequestUrl() );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new UserCreationResponse( $response );
    }

    /**
     * Gets all the users in an account that the caller has permissions to access
     * @param null $userEmail
     * @return UsersInfo
     */
    public function listAll( $userEmail = null )
    {
        $query = '';

        if( $userEmail ) {
            $query = '?'.http_build_query(['x-user-email'=>$userEmail]);
        }

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() . $query );

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() . $query );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

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

        $request = new GetRequest( $this->getOAuthToken(), $this->getRequestUrl() );

        $transport = $this->getTransport();

        $this->setRequest( $request );
        $this->logDebug( "Creating GET request to ".$this->getRequestUrl() );

        $response = $transport->handleRequest( $request );

        if( ! is_array( $response ) ) {
            $this->responseReceived = $response;
            throw new \RuntimeException('Bad response received! Please inspect responseReceived');
        }

        $this->logDebug( "response", $response );

        return new UserDetailsInfo( $response );
    }
}