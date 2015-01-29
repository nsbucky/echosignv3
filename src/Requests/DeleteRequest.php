<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

class DeleteRequest extends HttpRequest
{
    const REQUEST_METHOD = 'DELETE';

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return self::REQUEST_METHOD;
    }

}