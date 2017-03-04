<?php

namespace Psr\Http\Message;

/**
 * Representation of an outgoing, server-side response.
 * This interface extends standard ResponseInterface by adding mutability.
 */
interface MutableResponseInterface extends MessageInterface
{
    /**
     * Sets status code and, optionally, reason phrase on current instance.
     *
     * If no reason phrase is specified, implementations MAY choose to default
     * to the RFC 7231 or IANA recommended reason phrase for the response's
     * status code.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @link http://tools.ietf.org/html/rfc7231#section-6
     * @link http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
     * @param int $code The 3-digit integer result code to set.
     * @param string $reasonPhrase The reason phrase to use with the
     *     provided status code; if none is provided, implementations MAY
     *     use the defaults as suggested in the HTTP specification.
     * @return self
     * @throws \InvalidArgumentException For invalid status code arguments.
     */
    public function setStatus($code, $reasonPhrase = '');
}
