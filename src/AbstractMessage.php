<?php

namespace Psr\Http\Message;

abstract class AbstractMessage implements MessageInterface
{
    /**
     * @var StreamableInterface|null
     */
    protected $body;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @var string
     */
    protected $protocolVersion;

    /**
     * {@inheritDoc}
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * {@inheritDoc}
     */
    public function setProtocolVersion($version)
    {
        $this->protocolVersion = $version;
    }

    /**
     * {@inheritDoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritDoc}
     */
    public function setBody(StreamableInterface $body = null)
    {
        $this->body = $body;
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * {@inheritDoc}
     */
    public function hasHeader($header)
    {
        return isset($this->headers[strtolower($header)]);
    }

    /**
     * {@inheritDoc}
     */
    public function getHeader($header)
    {
        return !$this->hasHeader($header) ? '' : implode(',', $this->getHeaderAsArray($header));
    }

    /**
     * {@inheritDoc}
     */
    public function getHeaderAsArray($header)
    {
        return (!$this->hasHeader($header)) ? [] : $this->headers[strtolower($header)];
    }

    /**
     * {@inheritDoc}
     */
    public function setHeader($header, $value)
    {
        if (!is_string($header)) {
            throw new \InvalidArgumentException('Header field name must be a string.');
        }

        $header = strtolower($header);

        if (!is_array($value)) {
            $value = [$value];
        }

        foreach ($value as $headerValue) {
            if (!is_string($headerValue)) {
                throw new \InvalidArgumentException('Header field value must be a string or array of strings.');
            }
        }

        $this->headers[strtolower($header)] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function addHeader($header, $value)
    {
        if (!is_string($header)) {
            throw new \InvalidArgumentException('Header field name must be a string.');
        }

        $value = (array) $value;
        $this->setHeader($header, array_merge($this->getHeaderAsArray($header), $value));
    }

    /**
     * {@inheritDoc}
     */
    public function removeHeader($header)
    {
        unset($this->headers[strtolower($header)]);
    }
}
