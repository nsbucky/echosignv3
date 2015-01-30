<?php
namespace Echosign\RequestBuilders\Agreement;

use Echosign\Interfaces\RequestBuilder;

/**
 * Class SecurityOption
 * @package Echosign\RequestBuilders\Agreement
 */
class SecurityOption implements RequestBuilder
{

    public $passwordProtection;
    public $kbaProtection;
    public $webIdentityProtection;
    public $protectOpen;
    public $internalPassword;
    public $externalPassword;
    public $openPassword;

    /**
     * @return array
     */
    public function toArray()
    {
        return array_filter( [
            'passwordProtection'    => $this->passwordProtection,
            'kbaProtection'         => $this->kbaProtection,
            'webIdentityProtection' => $this->webIdentityProtection,
            'protectOpen'           => $this->protectOpen,
            'internalPassword'      => $this->internalPassword,
            'externalPassword'      => $this->externalPassword,
            'openPassword'          => $this->openPassword,
        ] );
    }

}