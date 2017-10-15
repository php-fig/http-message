<?php

namespace Psr\Http\Message;

/**
 * State store http
 */
interface StateStorageInterface 
{
    /**
     * Return an instance with the specified RequestInterface state
     * @param \Psr\Http\Message\RequestInterface $request RequestInterface instance
     * @return new instance StateStorageInterface
     */
    public function withRequestState(RequestInterface $request);
    /**
     * Return an instance with the specified RequestInterface state
     * @param \Psr\Http\Message\ResponseInterface $request
     * @return new instance StateStorageInterface
     */
    public function withResponseState(ResponseInterface $request);
    /**
     * Return an instance with the specified ResponseInterface state
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return new instance StateStorageInterface
     */
    public function withServerRequestState(ServerRequestInterface $request);
    /**
     * Return an instance with the specified ServerRequestInterface state
     * @param \Psr\Http\Message\MessageInterface $request
     * @return new instance StateStorageInterface
     */
    public function withMessageState(MessageInterface $request);
    /**
     * Return an instance with the specified MessageInterface state
     * @param \Psr\Http\Message\UriInterface $request
     * @return new instance StateStorageInterface
     */
    public function withUriState(UriInterface $request);
    /**
     * Return RequestInterface state
     * @return \Psr\Http\Message\RequestInterface
     */
    public function getRequestState();
    /**
     * Return ResponseInterface state
     * @return \Psr\Http\Message\ResponseInterface 
     */
    public function getResponseState();
    /**
     * Return ResponseInterface state
     * @return \Psr\Http\Message\ServerRequestInterface
     */
    public function getServerRequestState();
    /**
     * Return ServerRequestInterface state
     * @return \Psr\Http\Message\MessageInterface
     */
    public function getMessageState();
    /**
     * Return MessageInterface state
     * @return \Psr\Http\Message\UriInterface
     */
    public function getUriState();
}
