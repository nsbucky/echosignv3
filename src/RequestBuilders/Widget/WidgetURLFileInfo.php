<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class URLFileInfo
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetURLFileInfo implements RequestBuilder
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @param $name
     * @param $url
     * @param string $mimeType
     */
    public function __construct( $name, $url, $mimeType = null )
    {
        $this->name     = $name;
        $this->url      = filter_var( $url, FILTER_SANITIZE_URL );
        $this->mimeType = $mimeType;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'name'     => $this->name,
            'url'      => $this->url,
            'mimeType' => $this->mimeType
        ] );
    }

}