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
interface OutgoingRequestInterface extends MessageInterface
{
    /**
     * Set the HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * @param string $version HTTP protocol version
     * @return void
     */
    public function setProtocolVersion($version);

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
     * Retrieves the request URL.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @return string Returns the URL as a string. The URL SHOULD be an
     *     absolute URI as specified in RFC 3986, but MAY be a relative URI.
     */
    public function getUrl();

    /**
     * Sets the request URL.
     *
     * The URL MUST be a string. The URL SHOULD be an absolute URI as specified
     * in RFC 3986, but MAY be a relative URI.
     *
     * @link http://tools.ietf.org/html/rfc3986#section-4.3
     * @param string $url Request URL.
     * @return void
     * @throws \InvalidArgumentException If the URL is invalid.
     */
    public function setUrl($url);

    /**
     * Sets a header, replacing any existing values of any headers with the
     * same case-insensitive name.
     *
     * The header name is case-insensitive. The header values MUST be a string
     * or an array of strings.
     *
     * @param string $header Header name
     * @param string|string[] $value Header value(s).
     * @return void
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function setHeader($header, $value);

    /**
     * Appends a header value for the specified header.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list.
     *
     * @param string $header Header name to add
     * @param string|string[] $value Header value(s).
     * @return void
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function addHeader($header, $value);

    /**
     * Remove a specific header by case-insensitive name.
     *
     * @param string $header HTTP header to remove
     * @return void
     */
    public function removeHeader($header);

    /**
     * Sets the body of the message.
     *
     * The body MUST be a StreamableInterface object.
     *
     * @param StreamableInterface $body Body.
     * @return void
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function setBody(StreamableInterface $body);
}
