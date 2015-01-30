<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

/**
 * Class DeleteRequest
 * @package Echosign\Requests
 */
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