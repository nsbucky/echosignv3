<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\RequestBuilders\UserCreationInfo;

class Users extends Resource
{
    protected $baseApiPath = 'users';

    public function create( UserCreationInfo $userCreationInfo )
    {

    }

    public function listAll( $userEmail = null )
    {

    }

    public function details( $userId )
    {
        $this->setApiRequestUrl( $userId );
    }
}