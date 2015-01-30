<?php
namespace Echosign\RequestBuilders\Agreement;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class VaultingInfo
 * @package Echosign\RequestBuilders\Agreement
 */
class VaultingInfo implements RequestBuilder
{

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
            'enabled' => (bool) $this->enabled,
        ];
    }

}