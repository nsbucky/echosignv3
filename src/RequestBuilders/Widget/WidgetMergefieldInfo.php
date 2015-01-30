<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class MergefieldInfo
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetMergefieldInfo implements RequestBuilder
{

    /**
     * @var string
     */
    public $defaultValue;

    /**
     * @var string
     */
    public $fieldName;

    /**
     * @param string $defaultValue
     * @param string $fieldName
     */
    public function __construct( $defaultValue = null, $fieldName = null )
    {
        $this->defaultValue = $defaultValue;
        $this->fieldName    = $fieldName;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'defaultValue' => $this->defaultValue,
            'fieldName'    => $this->fieldName,
        ] );
    }
}