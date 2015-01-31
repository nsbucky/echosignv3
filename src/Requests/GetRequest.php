<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

/**
 * Class GetRequest
 * @package Echosign\Requests
 */
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