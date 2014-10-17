<?php

namespace Psr\Http\Message;

/**
 * An incoming (server-side) HTTP request.
 *
 * This interface further describes a server-side request and provides
 * accessors and mutators around common request data, including query
 * string arguments, body parameters, upload file metadata, cookies, and
 * arbitrary attributes derived from the request by the application.
 */
interface IncomingRequestInterface extends RequestInterface
{
    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The assumption is these are injected during instantiation, typically
     * from PHP's $_COOKIE superglobal. The data IS NOT REQUIRED to come from
     * $_COOKIE, but MUST be compatible with the structure of $_COOKIE.
     *
     * @return array
     */
    public function getCookieParams();

    /**
     * Set cookie parameters.
     *
     * Allows a library to set the cookie parameters. Use cases include
     * libraries that implement additional security practices, such as
     * encrypting or hashing cookie values; in such cases, they will read
     * the original value, filter them, and re-inject into the incoming
     * request.
     *
     * The value provided MUST be compatible with the structure of $_COOKIE.
     *
     * @param array $cookies Cookie values
     * @return void
     * @throws \InvalidArgumentException For invalid cookie parameters.
     */
    public function setCookieParams(array $cookies);

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's `parse_str()` would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * @return array
     */
    public function getQueryParams();

    /**
     * Retrieve the upload file metadata.
     *
     * This method MUST return file upload metadata in the same structure
     * as PHP's $_FILES superglobal.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_FILES superglobal, or MAY be derived from other sources.
     *
     * @return array Upload file(s) metadata, if any.
     */
    public function getFileParams();

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request body can be deserialized to an array, this method MAY be
     * used to retrieve them. These MAY be injected during instantiation from
     * PHP's $_POST superglobal. The data IS NOT REQUIRED to come from $_POST,
     * but MUST be an array.
     *
     * In cases where the request content cannot be coerced to an array, the
     * parent getBody() method should be used to retrieve the body content.
     *
     * @return array The deserialized body parameters, if any.
     */
    public function getBodyParams();

    /**
     * Set the request body parameters.
     *
     * If the body content can be deserialized to an array, the values obtained
     * MAY then be injected into the response using this method. This method
     * will typically be invoked by a factory marshaling request parameters.
     *
     * @param array $values The deserialized body parameters, if any.
     * @return void
     * @throws \InvalidArgumentException For $values that cannot be accepted.
     */
    public function setBodyParams(array $values);

    /**
     * Retrieve attributes derived from the request.
     *
     * If a router or similar is used to match against the path and/or request,
     * this method MAY be used to retrieve the results, so long as those
     * results can be represented as an array.
     *
     * @return array Attributes derived from the request.
     */
    public function getAttributes();

    /**
     * Set attributes derived from the request
     *
     * If a router or similar is used to match against the path and/or request,
     * this method MAY be used to inject the request with the results, so long
     * as those results can be represented as an array.
     *
     * @param array $attributes Attributes derived from the request.
     * @return void
     */
    public function setAttributes(array $attributes);
}
