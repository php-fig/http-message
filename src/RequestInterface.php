<?php

namespace Psr\Http\Message;

/**
 * Representation of an outgoing, client-side request.
 *
 * Per the HTTP specification, this interface includes both accessors for
 * and mutators for the following:
 *
 * - Protocol version
 * - HTTP method
 * - URL
 * - Headers
 * - Message body
 *
 * As the request CAN be built iteratively, the interface allows
 * mutability of all properties.
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
     * Retrieves the base request URL.
     *
     * The base URL consists of:
     *
     * - scheme
     * - authentication (if any)
     * - server name/host
     * - port (if non-standard)
     *
     * This method is provided for convenience, particularly when considering
     * server-side requests, where data such as the scheme and server name may
     * need to be computed from more than one environmental variable.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return string Returns the base URL as a string. The URL MUST include
     *     the scheme and host; if the port is non-standard for the scheme,
     *     the port MUST be included; authentication data MAY be provided.
     */
    public function getBaseUrl();

    /**
     * Sets the base request URL.
     *
     * The base URL MUST be a string, and MUST include the scheme and host.
     *
     * If the port is non-standard for the scheme, the port MUST be provided.
     *
     * Authentication data MAY be provided.
     *
     * If path, query string, or URL fragment are provided they SHOULD be
     * stripped; optionally, an error MAY be raised in such situations.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param string $url Base request URL.
     * @return void
     * @throws \InvalidArgumentException If the URL is invalid.
     */
    public function setBaseUrl($url);

    /**
     * Retrieves the request URL.
     *
     * The request URL is the same value as REQUEST_URI: the path and query
     * string ONLY.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-5.3
     * @return string Returns the URL as a string. The URL MUST be an
     *     origin-form (path + query string), per RFC 7230 section 5.3
     */
    public function getUrl();

    /**
     * Sets the request URL.
     *
     * The URL MUST be a string. The URL SHOULD be an origin-form (path + query
     * string) per RFC 7230 section 5.3; if other URL parts are present, the
     * method MUST raise an exception OR remove those parts.
     *
     * @link http://tools.ietf.org/html/rfc7230#section-5.3
     * @param string $url Request URL, with path and optionally query string.
     * @return void
     * @throws \InvalidArgumentException If the URL is invalid.
     */
    public function setUrl($url);
}
