<?php
namespace Echosign\Interfaces;

/**
 * Interface RequestEntity
 * @package Echosign\Interfaces
 */
interface RequestEntity
{
    /**
     * @return string|null
     */
    public function getRequestUrl();

    /**
     * @return array
     */
    public function getHeaders();

    /**
     * @return string
     */
    public function getRequestMethod();

    /**
     * @return array
     */
    public function getBody();

    /**
     * @return string|null
     */
    public function getFileSavePath();

}