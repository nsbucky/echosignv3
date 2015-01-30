<?php
namespace Echosign\RequestBuilders\Widget;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class VaultingInfo
 * @package Echosign\RequestBuilders\Widget
 */
class WidgetVaultingInfo implements RequestBuilder {

    /**
     * @var bool
     */
    public $enabled;

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'enabled'=>(bool) $this->enabled,
        ];
    }

}