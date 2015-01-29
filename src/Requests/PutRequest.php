<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

class PutRequest extends HttpRequest
{
    const REQUEST_METHOD = 'PUT';

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return self::REQUEST_METHOD;
    }

}