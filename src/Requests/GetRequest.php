<?php
namespace Echosign\Requests;

use Echosign\Abstracts\HttpRequest;

class GetRequest extends HttpRequest
{
    const REQUEST_METHOD = 'GET';

    protected $saveFilePath;

    /**
     * @return string
     */
    public function getRequestMethod()
    {
        return self::REQUEST_METHOD;
    }

    /**
     * @return string
     */
    public function getSaveFilePath()
    {
        return $this->saveFilePath;
    }

    /**
     * @param string $saveFilePath
     * @throws \RuntimeException
     */
    public function setSaveFilePath( $saveFilePath )
    {
        $path = pathinfo( $saveFilePath, PATHINFO_DIRNAME );

        if( ! is_writable( $path ) ) {
            throw new \RuntimeException( $path . ' must be writable');
        }

        $this->saveFilePath = $saveFilePath;
    }

    /**
     * @return bool
     */
    public function saveResponseToFile()
    {
        $path = $this->getSaveFilePath();

        return ! empty( $path );
    }

}