<?php

namespace Psr\Http\Message;

/**
 * Representation of an incoming, server-side HTTP request.
 * This interface extends standard ServerRequestInterface by adding mutability.
 */
interface MutableServerRequestInterface extends ServerRequestInterface
{
    /**
     * Modifies current instance by setting specified cookies.
     *
     * The data IS NOT REQUIRED to come from the $_COOKIE superglobal, but MUST
     * be compatible with the structure of $_COOKIE. Typically, this data will
     * be injected at instantiation.
     *
     * This method MUST NOT update the related Cookie header of the request
     * instance, nor related values in the server params.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param array $cookies Array of key/value pairs representing cookies.
     * @return self
     */
    public function setCookieParams(array $cookies);

    /**
     * Modifies current instance by setting specified query string arguments.
     *
     * These values SHOULD remain immutable over the course of the incoming
     * request. They MAY be injected during instantiation, such as from PHP's
     * $_GET superglobal, or MAY be derived from some other value such as the
     * URI. In cases where the arguments are parsed from the URI, the data
     * MUST be compatible with what PHP's parse_str() would return for
     * purposes of how duplicate query parameters are handled, and how nested
     * sets are handled.
     *
     * Setting query string arguments MUST NOT change the URI stored by the
     * request, nor the values in the server params.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param array $query Array of query string arguments, typically from
     *     $_GET.
     * @return self
     */
    public function setQueryParams(array $query);

    /**
     * Modifies current instance by setting specified uploaded files.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param array An array tree of UploadedFileInterface instances.
     * @return self
     * @throws \InvalidArgumentException if an invalid structure is provided.
     */
    public function setUploadedFiles(array $uploadedFiles);

    /**
     * Modifies current instance by setting specified body parameters.
     *
     * These MAY be injected during instantiation.
     *
     * If the request Content-Type is either application/x-www-form-urlencoded
     * or multipart/form-data, and the request method is POST, use this method
     * ONLY to inject the contents of $_POST.
     *
     * The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * deserializing the request body content. Deserialization/parsing returns
     * structured data, and, as such, this method ONLY accepts arrays or objects,
     * or a null value if nothing was available to parse.
     *
     * As an example, if content negotiation determines that the request data
     * is a JSON payload, this method could be used to create a request
     * instance with the deserialized parameters.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param null|array|object $data The deserialized body data. This will
     *     typically be in an array or object.
     * @return self
     * @throws \InvalidArgumentException if an unsupported argument type is
     *     provided.
     */
    public function setParsedBody($data);

    /**
     * Modifies current instance by setting specified derived request attribute.
     *
     * This method allows setting a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @param mixed $value The value of the attribute.
     * @return self
     */
    public function setAttribute($name, $value);

    /**
     * Modifies current instance by removing specified derived request attribute.
     *
     * This method allows removing a single derived request attribute as
     * described in getAttributes().
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @see getAttributes()
     * @param string $name The attribute name.
     * @return self
     */
    public function removeAttribute($name);
}
