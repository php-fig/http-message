PSR Http Message
================

This repository holds all interfaces/classes/traits related to
[PSR-7](http://www.php-fig.org/psr/psr-7/).

Note that this is not a HTTP message implementation of its own. It is merely an
interface that describes a HTTP message. See the specification for more details.

Usage
-----

There are two ways of using the [PSR-7](http://www.php-fig.org/psr/psr-7) standard. You can write your own implementation or consume a library/package that implements the standard.

* [Writing your own implementation](#implementation)
* [Consuming the interfaces through a vendor](#consuming-through-vendor)

<a name="implementation"></a>
## Writing your own implementation
Implementations should implement all functionality in each interface. Please check [here](https://packagist.org/providers/psr/http-message-implementation) for vendors who have already done this.

<a name="consuming-through-vendor"></a>
## Consuming the interfaces through a vendor
Imagine you need a way to send HTTP requests from your application. Instead of reinventing the wheel, you would then pull in a [vendor](https://packagist.org/providers/psr/http-message-implementation) that has done the legwork for you (perhaps through composer) and use that.

As an example, the [Guzzle](https://github.com/guzzle/guzzle) library already supports [PSR-7](http://www.php-fig.org/psr/psr-7). It is then possible to send a request and get back a response.
To decouple your code from guzzle, you can create your own client interface
and have that type hinted in your services. Your services know to send a RequestInterface to the client and that they get back a ResponseInterface object.

You have an application with an api that allows you to fetch posts. You create a RequestInterface implementation object (like Guzzle's Request object) and send it to the client. The client then responds with an implementation of a ResponseInterface object (like Guzzle's Response object).

```php
<?php
namespace YourApp\Controller;

use Psr7\Http\Message\RequestInterface;
use Psr7\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Creating a client interface that your services can depend on so you can 
 * swap out clients whenever you feel like it, without changing the underlying 
 * code
 */
interface ClientInterface
{
    /**
     * This method sends a request and returns a response
     * 
     * @param  RequestInterface $request
     * 
     * @return ResponseInterface
     */
    public function send(RequestInterface $request);

    /**
     * @param string $method
     * @param string $url
     * 
     * @return RequestInterface
     */
    public function request($method, $url);
}

/**
 * This is a guzzle client, implementing our interface
 */
class GuzzleClient implements ClientInterface
{
    public function send(RequestInterface $request)
    {
        return $this->guzzle->send($request);
    }

    public function request($method, $url)
    {
        return new Request($method, $url);
    }
}

/**
 * Or another client, that you swapped guzzle out with
 * as a simple example.
 */
class OtherHttpClient implements ClientInterface
{
    public function send(RequestInterface $request)
    {
        $this->otherClient->send($request);
    }

    public function request($method, $url)
    {
        return new OtherHttpVendorRequest($method, $url);
    }
}

/**
 * Your posts service then receives a client object, on which he can create 
 * requests (RequestInterface) and receive responses (ResponseInterface)
 */
class PostsService
{
    /**
     * Inject the client, but keep the service agnostic as to which client it is using.
     * 
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function all()
    {
        // $request is now an instance of RequestInterface
        $request = $this->client->request('GET', 'https://api.app.com/posts');

        // $response is now an instance of ResponseInterface
        $response = $this->client->send($request);

        return json_decode($response->getBody(), true);
    }
}
