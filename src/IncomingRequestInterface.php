<?php

namespace Psr\Http\Message;

/**
 * An incoming (server-side) HTTP request.
 *
 * This interface further describes a server-side request and provides
 * accessors and mutators around common request data, such as query
 * string arguments, body parameters, upload file metadata, cookies, and
 * matched routing parameters.
 */
interface IncomingRequestInterface extends RequestInterface
{
    /**
     * Retrieve cookies.
     *
     * Retrieves cookies sent by the client to the server.
     *
     * The assumption is these are injected during instantiation, typically
     * from PHP's $_COOKIE superglobal, and should remain immutable over the
     * course of the incoming request.
     *
     * The return value can be either an array or an object that acts like
     * an array (e.g., implements ArrayAccess, or an ArrayObject).
     * 
     * @return array|\ArrayAccess
     */
    public function getCookieParams();

    /**
     * Set cookie parameters.
     *
     * Allows a library to set the cookie parameters. Use cases include
     * libraries that implement additional security practices, such as
     * encrypting or hashing cookie values; in such cases, they will read
     * the original value, filter them, and re-inject into the incoming
     * request..
     *
     * The value provided should be an array or array-like object
     * (e.g., implements ArrayAccess, or an ArrayObject).
     * 
     * @param array|\ArrayAccess $cookies Cookie values/structs
     * 
     * @return void
     */
    public function setCookieParams($cookies);

    /**
     * Retrieve query string arguments.
     *
     * Retrieves the deserialized query string arguments, if any.
     *
     * The assumption is these are injected during instantiation, typically
     * from PHP's $_GET superglobal, and should remain immutable over the
     * course of the incoming request.
     *
     * The return value can be either an array or an object that acts like
     * an array (e.g., implements ArrayAccess, or an ArrayObject).
     * 
     * @return array
     */
    public function getQueryParams();

    /**
     * Retrieve the upload file metadata.
     *
     * This method should return file upload metadata in the same structure
     * as PHP's $_FILES superglobal.
     *
     * The assumption is these are injected during instantiation, typically
     * from PHP's $_FILES superglobal, and should remain immutable over the
     * course of the incoming request.
     *
     * The return value can be either an array or an object that acts like
     * an array (e.g., implements ArrayAccess, or an ArrayObject).
     * 
     * @return array Upload file(s) metadata, if any.
     */
    public function getFileParams();

    /**
     * Retrieve any parameters provided in the request body.
     *
     * If the request body can be deserialized, and if the deserialized values
     * can be represented as an array or object, this method can be used to
     * retrieve them.
     *
     * In other cases, the parent getBody() method should be used to retrieve
     * the body content.
     * 
     * @return array|object The deserialized body parameters, if any. These may
     *                      be either an array or an object, though an array or
     *                      array-like object is recommended.
     */
    public function getBodyParams();

    /**
     * Set the request body parameters.
     *
     * If the body content can be deserialized, the values obtained may then
     * be injected into the response using this method. This method will
     * typically be invoked by a factory marshaling request parameters.
     * 
     * @param array|object $values The deserialized body parameters, if any.
     *                             These may be either an array or an object,
     *                             though an array or array-like object is
     *                             recommended.
     *
     * @return void
     */
    public function setBodyParams($values);

    /**
     * Retrieve parameters matched during routing.
     *
     * If a router or similar is used to match against the path and/or request,
     * this method can be used to retrieve the results, so long as those
     * results can be represented as an array or array-like object.
     *
     * @return array|\ArrayAccess Path parameters matched by routing
     */
    public function getPathParams();

    /**
     * Set parameters discovered by matching that path
     *
     * If a router or similar is used to match against the path and/or request,
     * this method can be used to inject the request with the results, so long
     * as those results can be represented as an array or array-like object.
     * 
     * @param array|\ArrayAccess $values Path parameters matched by routing
     *
     * @return void
     */
    public function setPathParams(array $values);
}
