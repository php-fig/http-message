<?php

namespace Psr\Http\Message;

use Psr\Http\Message\TestAsset\ConcreteRequest;
use Psr\Http\Message\TestAsset\Url;

class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractRequest
     */
    protected $request;

    public function testCanGetAndSetMethod()
    {
        $this->request->setMethod('get');
        $this->assertSame('get', $this->request->getMethod());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage HTTP Request method must be a string.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToSetInvalidHttpMethod()
    {
        $this->request->setMethod($this);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage URL must be string or implement the __toString method.
     */
    public function testInvalidArgumentExceptionIsThrownIfUrlIsNeitherStringNorImplementorOfToString()
    {
        $this->request->setUrl($this);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage URL must be absolute and conform to RFC 3986.
     */
    public function testInvalidArgumentExceptionIsThrownIfUrlIsNotValid()
    {
        $this->request->setUrl('invalid');
    }

    public function validUrlProvider()
    {
        return [
            [ConcreteRequest::$validUrl],
            [new Url()],
        ];
    }

    /**
     * @dataProvider validUrlProvider
     */
    public function testCanSetValidUrl($url)
    {
        $this->request->setUrl($url);
        $this->assertEquals($url, $this->request->getUrl());
    }

    protected function setUp()
    {
        $this->request = new ConcreteRequest();
    }

    protected function tearDown()
    {
        $this->request = null;
    }
}
