<?php

namespace Psr\Http\Message;

/**
 * An HTTP request message.
 *
 * @link http://tools.ietf.org/html/rfc7230#section-3
 */
interface RequestInterface extends MessageInterface
{
    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod();

    /**
     * Sets the HTTP method to be performed on the resource identified by the
     * Request-URI.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * @param string $method Case-insensitive method.
     * @return void
     * @throws \InvalidArgumentException for invalid HTTP methods.
     */
    public function setMethod($method);

    /**
     * Retrieves the absolute request URL.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return string|object Returns the URL as a string, or an object that
     *    implements the `__toString()` method. The URL must be an absolute URI
     *    as specified in RFC 3986.
     */
    public function getUrl();

    /**
     * Sets the request URL.
     *
     * The URL MUST be a string, or an object that implements the
     * `__toString()` method. The URL must be an absolute URI as specified
     * in RFC 3986.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param string|object $url Request URL.
     * @return void
     * @throws \InvalidArgumentException If the URL is invalid.
     */
    public function setUrl($url);
}
