<?php

use Echosign\Responses\BaseUriInfo;

class BaseUriInfoTest extends PHPUnit_Framework_TestCase
{
    public function testCreateResponse()
    {
        $response = [
            "api_access_point" => "https://api.echosign.com",
            "web_access_point" => "https://secure.echosign.com"
        ];

        $baseUri = new BaseUriInfo( $response );

        $this->assertEquals( $response["api_access_point"], $baseUri->getApiAccessPoint() );
        $this->assertEquals( $response["web_access_point"], $baseUri->getWebAccessPoint() );
    }
}