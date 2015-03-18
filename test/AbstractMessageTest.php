<?php

namespace Psr\Http\Message;

use Psr\Http\Message\TestAsset\ConcreteMessage;

class AbstractMessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractMessage
     */
    protected $message;

    public function testCanGetAndSetProtocolVersion()
    {
        $this->assertNull($this->message->getProtocolVersion());
        $this->message->setProtocolVersion('HTTP/1.1');
        $this->assertSame('HTTP/1.1', $this->message->getProtocolVersion());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Header field name must be a string.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToSetInvalidHeader()
    {
        $this->message->setHeader($this, 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Header field name must be a string.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToAddInvalidHeader()
    {
        $this->message->addHeader($this, 'bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Header field value must be a string or array of strings.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToSetNonStringHeaderValues()
    {
        $this->message->setHeader('Accept', $this);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Header field value must be a string or array of strings.
     */
    public function testInvalidArgumentExceptionIsThrownWhenAttemptingToAddNonStringHeaderValues()
    {
        $this->message->addHeader('hello-world', $this);
    }

    public function testCanSetHeaderValuesAsStrings()
    {
        $this->message->setHeader('hello-world', 'hello!');
        $this->assertSame('hello!', $this->message->getHeader('hello-world'));
    }

    public function testCanSetHeaderValuesAsArrayOfStrings()
    {
        $this->message->setHeader('hello-world', ['hello!', 'world!']);
        $this->assertSame('hello!,world!', $this->message->getHeader('hello-world'));
    }

    public function testSettingHttpHeaderReplacesPreviouslySetHeadersOfTheSameType()
    {
        $this->message->setHeader('hello-world', ['hello!']);
        $this->message->setHeader('hello-world', ['goodbye!']);

        $this->assertSame('goodbye!', $this->message->getHeader('hello-world'));
    }

    public function testAddingHttpHeaderAppendsToExistingHeadersOfTheSameType()
    {
        $this->message->addHeader('hello-world', ['hello!']);
        $this->message->addHeader('hello-world', ['goodbye!']);

        $this->assertSame('hello!,goodbye!', $this->message->getHeader('hello-world'));
    }

    public function testGetHeadersReturnsHeadersWithFieldNamesAsKeysAndValuesAsArraysOfStrings()
    {
        $this->message->setHeader('hello-world', ['hello!', 'goodbye!']);
        $this->message->setHeader('foobar', ['foo', 'bar']);
        $this->assertSame(
            [
                'hello-world' => ['hello!', 'goodbye!'],
                'foobar' => ['foo', 'bar']
            ],
            $this->message->getHeaders()
        );
    }

    public function testCanRemovePreviouslySetHeaders()
    {
        $this->message->setHeader('foobar', ['foo', 'bar']);
        $this->message->removeHeader('foobar');
        $this->assertFalse($this->message->hasHeader('foobar'));
    }

    public function fieldNameProvider()
    {
        return [
            ['foobar'],
            ['FooBar'],
            ['FOOBAR'],
            ['FoObAr'],
        ];
    }

    /**
     * @dataProvider fieldNameProvider
     */
    public function testHeaderFieldNameHandlingIsCaseInsensitive($fieldName)
    {
        $lcFieldName = strtolower($fieldName);

        $this->message->setHeader($fieldName, 'foo');
        $this->message->addHeader($fieldName, 'bar');

        $this->assertSame(
            $this->message->hasHeader($fieldName),
            $this->message->hasHeader($lcFieldName)
        );
        $this->assertSame(
            $this->message->getHeader($fieldName),
            $this->message->getHeader($lcFieldName)
        );
        $this->assertSame(
            $this->message->getHeaderAsArray($fieldName),
            $this->message->getHeaderAsArray($lcFieldName)
        );

        $this->message->removeHeader($fieldName);

        $this->assertFalse($this->message->hasHeader($fieldName));
        $this->assertSame(
            $this->message->hasHeader($fieldName),
            $this->message->hasHeader($lcFieldName)
        );
    }

    public function bodyProvider()
    {
        return [
            [null],
            [$this->getMockForAbstractClass('Psr\Http\Message\StreamableInterface', [], '', false)],
        ];
    }

    /**
     * @dataProvider bodyProvider
     */
    public function testCanGetAndSetBody($body)
    {
        $this->message->setBody($body);
        $this->assertSame($body, $this->message->getBody());
    }

    protected function setUp()
    {
        $this->message = new ConcreteMessage();
    }

    protected function tearDown()
    {
        $this->message = null;
    }
}
