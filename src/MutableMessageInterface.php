<?php

namespace Psr\Http\Message;

/**
 * This interface extends standard MessageInterface by adding mutability.
 */
interface MutableMessageInterface extends MessageInterface
{

    /**
     * Modifies current instance by setting specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param string $version HTTP protocol version
     * @return self
     */
    public function setProtocolVersion($version);

    /**
     * Modifies current instance by replacing given header with new value.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return self
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function setHeader($name, $value);

    /**
     * Modifies current instance by adding header with given value to already excising one.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return self
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function addHeader($name, $value);

    /**
     * Modifies current instance by removing specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return self
     */
    public function removeHeader($name);

    /**
     * Modifies current instance by replacing body with specified one.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * @param StreamInterface $body Body.
     * @return self
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function setBody(StreamInterface $body);
}
