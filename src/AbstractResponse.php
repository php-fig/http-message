<?php

namespace Psr\Http\Message;

abstract class AbstractResponse extends AbstractMessage implements ResponseInterface
{
    /**
     * @var string
     */
    protected $reasonPhrase;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * {@inheritDoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritDoc}
     */
    public function setStatusCode($code)
    {
        if (!is_int($code)) {
            throw new \InvalidArgumentException('HTTP status code must be an integer.');
        }

        $this->statusCode = $code;
    }

    /**
     * {@inheritDoc}
     */
    public function getReasonPhrase()
    {
        return $this->reasonPhrase;
    }

    /**
     * {@inheritDoc}
     */
    public function setReasonPhrase($phrase)
    {
        if (!is_string($phrase)) {
            throw new \InvalidArgumentException('Reason Phrase must be a string.');
        }

        $this->reasonPhrase = $phrase;
    }
}
