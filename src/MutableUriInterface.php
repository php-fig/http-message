<?php
namespace Psr\Http\Message;

/**
 * Value object representing a URI.
 * This interface extends standard ServerRequestInterface by adding mutability.
 */
interface MutableUriInterface extends UriInterface
{
    /**
     * Modifies current instance by setting specified scheme.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * Implementations MUST support the schemes "http" and "https" case
     * insensitively, and MAY accommodate other schemes if required.
     *
     * An empty scheme is equivalent to removing the scheme.
     *
     * @param string $scheme The scheme to set on current instance.
     * @return self Current instance.
     * @throws \InvalidArgumentException for invalid or unsupported schemes.
     */
    public function setScheme($scheme);

    /**
     * Modifies current instance by setting specified user information.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * Password is optional, but the user information MUST include the
     * user; an empty string for the user is equivalent to removing user
     * information.
     *
     * @param string $user The user name to use for authority.
     * @param null|string $password The password associated with $user.
     * @return self Current instance.
     */
    public function setUserInfo($user, $password = null);

    /**
     * Modifies current instance by setting specified host.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * An empty host value is equivalent to removing the host.
     *
     * @param string $host The hostname to set on current instance.
     * @return self Current instance.
     * @throws \InvalidArgumentException for invalid hostnames.
     */
    public function setHost($host);

    /**
     * Modifies current instance by setting specified port.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * Implementations MUST raise an exception for ports outside the
     * established TCP and UDP port ranges.
     *
     * A null value provided for the port is equivalent to removing the port
     * information.
     *
     * @param null|int $port The port to set on current instance; a null value removes the port information.
     * @return self Current instance.
     * @throws \InvalidArgumentException for invalid ports.
     */
    public function setPort($port);

    /**
     * Modifies current instance by setting specified path.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * The path can either be empty or absolute (starting with a slash) or
     * rootless (not starting with a slash). Implementations MUST support all
     * three syntaxes.
     *
     * If the path is intended to be domain-relative rather than path relative then
     * it must begin with a slash ("/"). Paths not starting with a slash ("/")
     * are assumed to be relative to some base path known to the application or
     * consumer.
     *
     * Users can provide both encoded and decoded path characters.
     * Implementations ensure the correct encoding as outlined in getPath().
     *
     * @param string $path The path to set on current instance.
     * @return self Current instance.
     * @throws \InvalidArgumentException for invalid paths.
     */
    public function setPath($path);

    /**
     * Modifies current instance by setting specified query string.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * Users can provide both encoded and decoded query characters.
     * Implementations ensure the correct encoding as outlined in getQuery().
     *
     * An empty query string value is equivalent to removing the query string.
     *
     * @param string $query The query string to set on current instance.
     * @return self Current instance.
     * @throws \InvalidArgumentException for invalid query strings.
     */
    public function setQuery($query);

    /**
     * RModifies current instance by setting specified URI fragment.
     *
     * This method MUST be implemented in such a way as to modify current
     * instance of object, and MUST return the same instance that has been called.
     *
     * Users can provide both encoded and decoded fragment characters.
     * Implementations ensure the correct encoding as outlined in getFragment().
     *
     * An empty fragment value is equivalent to removing the fragment.
     *
     * @param string $fragment The fragment to set on current instance.
     * @return self Current instance.
     */
    public function setFragment($fragment);
}
