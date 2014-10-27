<?php

namespace Psr\Http\Message\TestAsset;

class Url
{
    public function __toString()
    {
        return ConcreteRequest::$validUrl;
    }
}
