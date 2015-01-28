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
     * Retrieves the message's request line.
     *
     * Retrieves the message's request line either as it will appear (for
     * clients), as it appeared at request (for servers), or as it was
     * specified for the instance (see withRequestLine()).
     *
     * This method MUST return a string of the form:
     *
     * <code>
     * HTTP_METHOD REQUEST_TARGET HTTP/PROTOCOL_VERSION
     * </code>
     *
     * If the request line is calculated at method execution (i.e., not from
     * a value set on the instance), the request-target MUST be in origin-form.
     *
     * If any aspect of the request line is unknown, it MUST raise an
     * exception.
     *
     * @return string
     * @throws \RuntimeException if unable to construct a valid request line.
     */
    public function getRequestLine();

    /**
     * Create a new instance with a specific request line.
     *
     * If the request needs a specific request line — for instance, to allow
     * specifying an absolute-form, authority-form, or asterisk-form
     * request-target — this method may be used to create an instance with
     * the specified request line, verbatim.
     *
     * This method MUST validate that the line is in the form:
     *
     * <code>
     * HTTP_METHOD REQUEST_TARGET HTTP/PROTOCOL_VERSION
     * </code>
     *
     * and raise an exception if not.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * changed request line.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-2.7 (for the various
     *     request-target forms allowed in request messages)
     * @param mixed $requestLine
     * @return self
     * @throws \InvalidArgumentException for invalid request lines.
     */
    public function withRequestLine($requestLine);

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
