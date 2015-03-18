<?php

namespace Psr\Http\Message;

abstract class AbstractRequest extends AbstractMessage implements RequestInterface
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $url;

    /**
     * {@inheritDoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritDoc}
     */
    public function setMethod($method)
    {
        if (!is_string($method)) {
            throw new \InvalidArgumentException('HTTP Request method must be a string.');
        }

        $this->method = $method;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * {@inheritDoc}
     */
    public function setUrl($url)
    {
        if (!is_string($url) && (!is_object($url) || !method_exists($url, '__toString'))) {
            throw new \InvalidArgumentException('URL must be string or implement the __toString method.');
        }

        if (!$this->validateUrl($url)) {
            throw new \InvalidArgumentException('URL must be absolute and conform to RFC 3986.');
        }

        $this->url = $url;
    }

    /**
     * Returns whether or not the URL conforms to RFC 3986. The choice of
     * validation method is an implementation detail left to the consumer.
     *
     * @param string|object $url Request URL
     * @return boolean
     */
    abstract protected function validateUrl($url);
}
