<?php

namespace Psr\Http\Message;

use Psr\Http\Message\TestAsset\ConcreteResponse;

class AbstractResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractResponse
     */
    protected $response;

    public function testCanGetAndSetStatusCode()
    {
        $this->response->setStatusCode(200);
        $this->assertSame(200, $this->response->getStatusCode());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage HTTP status code must be an integer.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToSetInvalidStatusCode()
    {
        $this->response->setStatusCode($this);
    }

    public function testCanGetAndSetReasonPhrase()
    {
        $this->response->setReasonPhrase('because!');
        $this->assertSame('because!', $this->response->getReasonPhrase());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Reason Phrase must be a string.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToSetInvalidReasonPhrase()
    {
        $this->response->setReasonPhrase($this);
    }

    protected function setUp()
    {
        $this->response = new ConcreteResponse();
    }

    protected function tearDown()
    {
        $this->response = null;
    }
}
