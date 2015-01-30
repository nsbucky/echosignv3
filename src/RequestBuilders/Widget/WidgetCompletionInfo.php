<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class WidgetCompletionInfo
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetCompletionInfo implements RequestBuilder
{
    protected $deframe = false;
    protected $delay = 0;
    protected $url;

    /**
     * @param $url
     * @param bool $deframe
     * @param int $delay
     */
    public function __construct( $url, $deframe = false, $delay = 0 )
    {
        $this->url     = filter_var( $url, FILTER_SANITIZE_URL );
        $this->deframe = $deframe;
        $this->delay   = $delay;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'deframe' => $this->deframe,
            'delay'   => $this->delay,
            'url'     => $this->url,
        ];
    }

}