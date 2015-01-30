<?php
namespace Echosign\RequestBuilders;

use Echosign\Interfaces\RequestBuilder;
use Echosign\RequestBuilders\Widget\WidgetCreationInfo;

/**
 * Class WidgetCreationRequest
 * @package Echosign\RequestBuilders
 */
class WidgetCreationRequest implements RequestBuilder
{
    /**
     * @var WidgetCreationInfo
     */
    protected $widgetCreationInfo;

    /**
     * @param WidgetCreationInfo $widgetCreationInfo
     */
    public function __construct( WidgetCreationInfo $widgetCreationInfo )
    {
        $this->widgetCreationInfo = $widgetCreationInfo;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'widgetCreationInfo' => $this->widgetCreationInfo->toArray(),
        ];
    }
}