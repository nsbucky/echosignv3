<?php
namespace Echosign;

use Echosign\Abstracts\Resource;
use Echosign\Responses\BaseUriInfo;

/**
 * Class BaseUris
 * @package Echosign
 */
class BaseUris extends Resource
{
    protected $baseApiPath = 'base_uris';

    /**
     * @return BaseUriInfo
     * @throws \RuntimeException on bad response received
     */
    public function getBaseUris()
    {
        $response = $this->simpleGetRequest();

        return new BaseUriInfo( (array) $response );
    }

}