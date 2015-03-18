<?php

namespace Psr\Http\Message\TestAsset;

use Psr\Http\Message\AbstractRequest;

class ConcreteRequest extends AbstractRequest
{
    public static $validUrl = 'https://github.com/php-fig/http-message';

    /**
     * Stub validator for testing purposes.
     *
     * @param string|object $url Request URL
     * @return boolean
     */
    protected function validateUrl($url)
    {
        return $url == self::$validUrl;
    }
}
