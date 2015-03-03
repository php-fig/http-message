<?php

namespace Psr\Http\Message;

/**
 * Representation of an outgoing, client-side request.
 *
 * Per the HTTP specification, this interface includes properties for
 * each of the following:
 *
 * - Protocol version
 * - HTTP method
 * - URI
 * - Headers
 * - Message body
 *
 * Requests are considered immutable; all methods that might change state MUST
 * be implemented such that they retain the internal state of the current
 * message and return a new instance that contains the changed state.
 */
interface RequestInterface extends MessageInterface
{
    /**
     * Extends MessageInterface::getHeaders() to provide request-specific
     * behavior.
     *
     * Retrieves all message headers.
     *
     * This method acts exactly like MessageInterface::getHeaders(), with one
     * behavioral change: if the Host header has not been previously set, the
     * method MUST attempt to pull the host segment of the composed URI, if
     * present.
     *
     * @see MessageInterface::getHeaders()
     * @see UriInterface::getHost()
     * @return array Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings.
     */
    public function getHeaders();

    /**
     * Extends MessageInterface::getHeader() to provide request-specific
     * behavior.
     *
     * This method acts exactly like MessageInterface::getHeader(), with
     * one behavioral change: if the Host header is requested, but has
     * not been previously set, the method MUST attempt to pull the host
     * segment of the composed URI, if present.
     *
     * @see MessageInterface::getHeader()
     * @see UriInterface::getHost()
     * @param string $name Case-insensitive header field name.
     * @return string
     */
    public function getHeader($name);

    /**
     * Extends MessageInterface::getHeaderLines() to provide request-specific
     * behavior.
     *
     * Retrieves a header by the given case-insensitive name as an array of strings.
     *
     * This method acts exactly like MessageInterface::getHeaderLines(), with
     * one behavioral change: if the Host header is requested, but has
     * not been previously set, the method MUST attempt to pull the host
     * segment of the composed URI, if present.
     *
     * @see MessageInterface::getHeaderLines()
     * @see UriInterface::getHost()
     * @param string $name Case-insensitive header field name.
     * @return string[]
     */
    public function getHeaderLines($name);

    /**
     * Retrieves the message's request target.
     *
     * Retrieves the message's request-target either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestTarget()).
     *
     * In most cases, this will be the origin-form of the composed URI,
     * unless a value was provided to the concrete implementation (see
     * withRequestTarget() below).
     *
     * If no URI is available, and no request-target has been specifically
     * provided, this method MUST return the string "/".
     *
     * @return string
     */
    public function getRequestTarget();

    /**
     * Create a new instance with a specific request-target.
     *
     * If the request needs a non-origin-form request-target — e.g., for
     * specifying an absolute-form, authority-form, or asterisk-form —
     * this method may be used to create an instance with the specified
     * request-target, verbatim.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * changed request target.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-2.7 (for the various
     *     request-target forms allowed in request messages)
     * @param mixed $requestTarget
     * @return self
     */
    public function withRequestTarget($requestTarget);

    /**
     * Retrieves the HTTP method of the request.
     *
     * @return string Returns the request method.
     */
    public function getMethod();

    /**
     * Create a new instance with the provided HTTP method.
     *
     * While HTTP method names are typically all uppercase characters, HTTP
     * method names are case-sensitive and thus implementations SHOULD NOT
     * modify the given string.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * changed request method.
     *
     * @param string $method Case-insensitive method.
     * @return self
     * @throws \InvalidArgumentException for invalid HTTP methods.
     */
    public function withMethod($method);

    /**
     * Retrieves the URI instance.
     *
     * This method MUST return a UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return UriInterface Returns a UriInterface instance
     *     representing the URI of the request, if any.
     */
    public function getUri();

    /**
     * Create a new instance with the provided URI.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new UriInterface instance.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param UriInterface $uri New request URI to use.
     * @return self
     */
    public function withUri(UriInterface $uri);
}
