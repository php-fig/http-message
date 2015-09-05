<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\Expectation;
use HackPack\HackUnit\Core\ExpectationException;
use HackPack\HackUnit\Core\TestCase;

class ExpectationTest extends TestCase
{
    public function test_getContext_returns_value_being_tested(): void
    {
        $expectation = new Expectation(1 + 1);
        $this->expect($expectation->getContext())->toEqual(2);
    }

    public function test_toEqual_does_not_throw_exception_when_true(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation(1 + 1);
            $expectation->toEqual(2);
        })->toNotThrow();
    }

    public function test_toEqual_throws_ExpectationException_if_fails(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation(1 + 1);
            $expectation->toEqual(3);
        })->toThrow(ExpectationException::class);
    }

    public function test_toBeIdenticalTo_throws_when_not_identical(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation(new Expectation(1));
            $expectation->toBeIdenticalTo(new Expectation(1));
        })->toThrow(ExpectationException::class);
    }

    public function test_toBeIdenticalTo_does_not_throw_when_identical(): void
    {
        $this->expectCallable(() ==> {
            $ex = new Expectation(1);
            $expectation = new Expectation($ex);
            $expectation->toBeIdenticalTo($ex);
        })->toNotThrow();
    }

    public function test_toMatch_does_not_throw_exception_when_matches(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation("hello");
            $expectation->toMatch('/^he/');
        })->toNotThrow();
    }

    public function test_toMatch_throws_ExpectationException_if_fails(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation("hello");
            $expectation->toMatch('/^oe/');
        })->toThrow(ExpectationException::class);
    }

    public function test_toBeInstanceOf_does_not_throw_exception_when_match(): void
    {
        $instance = new Expectation("string here");
        $this->expectCallable(() ==> {
            $expectation = new Expectation($instance);
            $expectation->toBeInstanceOf(Expectation::class);
        })->toNotThrow();
    }

    public function test_toBeInstanceOf_does_throw_exception_when_does_not_match(): void
    {
        $instance = new Expectation("string here");
        $this->expectCallable(() ==> {
            $expectation = new Expectation($instance);
            $expectation->toBeInstanceOf(TestCase::class);
        })->toThrow(ExpectationException::class);
    }

    public function test_toBeInstanceOf_does_throw_exception_when_not_class(): void
    {
        $this->expectCallable(() ==> {
            $expectation = new Expectation("string here");
            $expectation->toBeInstanceOf(TestCase::class);
        })->toThrow(ExpectationException::class);
    }
}
