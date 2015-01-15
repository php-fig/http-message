<?php
namespace Psr\Http\Message;

/**
 * Value object representing a URI.
 *
 * @see http://tools.ietf.org/html/rfc3986 (the URI specification)
 * @see http://tools.ietf.org/html/rfc7230#section-2.7 (URIs as used in the HTTP specification)
 */
interface UriInterface
{
    /**
     * Retrieve the URI scheme.
     *
     * Generally this will be one of "http" or "https", but implementations may
     * allow for other schemes when desired.
     *
     * If no scheme is present, this method MUST return an empty string.
     *
     * The string returned MUST strip off the "://" trailing delimiter if
     * present.
     *
     * @return string The scheme of the URI.
     */
    public function getScheme();

    /**
     * Retrieve the authority portion of the URI.
     *
     * The authority portion of the URI is:
     *
     * <pre>
     * [user-info@]host[:port]
     * </pre>
     *
     * If the port component is not set or is the standard port for the current
     * scheme, it SHOULD NOT be included.
     *
     * This method MUST return an empty string if no authority information is
     * present.
     *
     * @return string Authority portion of the URI, in "[user-info@]host[:port]"
     *     format.
     */
    public function getAuthority();

    /**
     * Retrieve the user information portion of the URI, if present.
     *
     * If a user is present in the URI, this will return that value;
     * additionally, if the password is also present, it will be appended to the
     * user value, with a colon (":") separating the values.
     *
     * Implementations MUST NOT return the "@" suffix when returning this value.
     *
     * @return string User information portion of the URI, if present, in
     *     "username[:password]" format.
     */
    public function getUserInfo();

    /**
     * Retrieve the host segment of the URI.
     *
     * This method MUST return a string; if no host segment is present, an
     * empty string MUST be returned.
     *
     * @return string Host segment of the URI.
     */
    public function getHost();

    /**
     * Retrieve the port segment of the URI.
     *
     * If a port is present, and it is non-standard for the current scheme,
     * this method MUST return it as an integer. If the port is the standard port
     * used with the current scheme, this method SHOULD return null.
     *
     * If no port is present, and no scheme is present, this method MUST return
     * a null value.
     *
     * If no port is present, but a scheme is present, this method MAY return
     * the standard port for that scheme.
     *
     * @return null|int The port for the URI.
     */
    public function getPort();

    /**
     * Retrieve the path segment of the URI.
     *
     * This method MUST return a string; if no path is present it MUST return
     * an empty string.
     *
     * @return string The path segment of the URI.
     */
    public function getPath();

    /**
     * Retrieve the query string of the URI.
     *
     * This method MUST return a string; if no query string is present, it MUST
     * return an empty string.
     *
     * The string returned MUST strip off any leading "?" character.
     *
     * @return string The URI query string.
     */
    public function getQuery();

    /**
     * Retrieve the fragment segment of the URI.
     *
     * This method MUST return a string; if no fragment is present, it MUST
     * return an empty string.
     *
     * The string returned MUST strip off any leading "#" character.
     *
     * @return string The URI fragment.
     */
    public function getFragment();

    /**
     * Create a new instance with the specified scheme.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified scheme. If the scheme
     * provided includes the "://" delimiter, it MUST be removed.
     *
     * @param string $scheme The scheme to use with the new instance.
     * @return UriInterface A new instance with the specified scheme.
     * @throws \InvalidArgumentException for invalid or unsupported schemes.
     */
    public function withScheme($scheme);

    /**
     * Create a new instance with the specified user information.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified user information.
     *
     * Password is optional, but the user information MUST include the
     * user.
     *
     * @param string $user User name to use for authority.
     * @param null|string $password Password associated with $user.
     * @return UriInterface A new instance with the specified user
     *     information.
     */
    public function withUserInfo($user, $password = null);

    /**
     * Create a new instance with the specified host.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified host.
     *
     * @param string $host Hostname to use with the new instance.
     * @return UriInterface A new instance with the specified host.
     * @throws \InvalidArgumentException for invalid hostnames.
     */
    public function withHost($host);

    /**
     * Create a new instance with the specified port.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified port.
     *
     * @param int $port Port to use with the new instance.
     * @return UriInterface A new instance with the specified port.
     * @throws \InvalidArgumentException for invalid ports.
     */
    public function withPort($port);

    /**
     * Create a new instance with the specified path.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified path.
     *
     * The path MUST be prefixed with "/"; if not, the implementation MAY
     * provide the prefix itself.
     *
     * @param string $path The path to use with the new instance.
     * @return UriInterface A new instance with the specified path.
     * @throws \InvalidArgumentException for invalid paths.
     */
    public function withPath($path);

    /**
     * Create a new instance with the specified query string.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified query string.
     *
     * If the query string is prefixed by "?", that character MUST be removed.
     * Additionally, the query string SHOULD be parseable by parse_str() in
     * order to be valid.
     *
     * @param string $query The query string to use with the new instance.
     * @return UriInterface A new instance with the specified query string.
     * @throws \InvalidArgumentException for invalid query strings.
     */
    public function withQuery($query);

    /**
     * Create a new instance with the specified URI fragment.
     *
     * This method MUST retain the state of the current instance, and return
     * a new instance that contains the specified URI fragment.
     *
     * If the fragment is prefixed by "#", that character MUST be removed.
     *
     * @param string $fragment The URI fragment to use with the new instance.
     * @return UriInterface A new instance with the specified URI fragment.
     */
    public function withFragment($fragment);

    /**
     * Indicate whether the URI is in origin-form.
     *
     * Origin-form is a URI that includes only the path and optionally the
     * query string.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3.1
     * @return bool
     */
    public function isOrigin();

    /**
     * Indicate whether the URI is absolute.
     *
     * An absolute URI contains minimally the scheme and host.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3.2
     * @return bool
     */
    public function isAbsolute();

    /**
     * Indicate whether the URI is in authority form.
     *
     * An authority-form URI is an absolute URI that also contains authority
     * information.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3.3
     * @return bool
     */
    public function isAuthority();

    /**
     * Indicate whether the URI is an asterisk-form.
     *
     * An asterisk form URI will have "*" as the path, and no other URI parts.
     *
     * @see http://tools.ietf.org/html/rfc7230#section-5.3.4
     * @return bool
     */
    public function isAsterisk();

    /**
     * Return the string representation of the URI.
     *
     * Concatenates the various segments of the URI, using the appropriate
     * delimiters:
     *
     * - If a scheme is present, "://" MUST append the value.
     * - If authority information is present, the password MUST be separated
     *   from the user by a ":", and the full authority string MUST be appended
     *   with an "@" character.
     * - If a port is present, and non-standard for the given scheme, it MUST
     *   be provided, and MUST be prefixed by a ":" character.
     * - If a path is present, it MUST be prefixed by a "/" character.
     * - If a query string is present, it MUST be prefixed by a "?" character.
     * - If a URI fragment is present, it MUST be prefixed by a "#" character.
     *
     * @return string
     */
    public function __toString();
}
