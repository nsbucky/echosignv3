<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

class GetRequest extends HttpRequest
{
    const REQUEST_METHOD = 'GET';

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return self::REQUEST_METHOD;
    }

}