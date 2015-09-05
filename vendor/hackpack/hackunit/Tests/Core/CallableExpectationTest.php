<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\ExpectationException;
use HackPack\HackUnit\Core\CallableExpectation;
use HackPack\HackUnit\Core\TestCase;

class CallableExpectationTest extends TestCase
{
    protected ?(function(): void) $callable;

    <<Override>> public function setUp(): void
    {
        $this->callable = $fun = () ==> {throw new ExpectationException('unexpected!');};
    }

    public function test_toThrow_does_nothing_if_exception_thrown(): void
    {
        if ($this->callable) {
            $this->expectCallable($this->callable)->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }

    public function test_toThrow_throws_exception_if_wrong_exception_type(): void
    {
        if ($this->callable) {
            $this->expectCallable(() ==> {
                $expectation = new CallableExpectation($this->callable);
                $expectation->toThrow('\RuntimeException');
            })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }

    public function test_toThrow_throws_exception_if_no_exception_thrown(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { $var = 'do nothing';  };
            $expectation = new CallableExpectation($callable);
            $expectation->toThrow('\RuntimeException');
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
    }

    public function test_toNotThrow_does_nothing_if_exception_not_thrown(): void
    {
        $callable = () ==> { $var = 'do nothing'; };
        $expectation = new CallableExpectation($callable);
        $expectation->toNotThrow();
    }

    public function test_toNotThrow_throws_exception_if_exception_thrown(): void
    {
        if ($this->callable) {
            $fun = () ==> { $fn = $this->callable; $fn();};
            $this->expectCallable($fun)->toThrow('\HackPack\HackUnit\Core\ExpectationException');
        }
    }

    public function test_toThrow_throws_exception_if_exception_thrown_with_incorrect_message(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { throw new \HackPack\HackUnit\Core\ExpectationException("Message"); };
            $expectation = new CallableExpectation($callable);
            $expectation->toThrow('\\HackPack\HackUnit\Core\ExpectationException', 'Different Message');
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
    }

    public function test_toThrow_does_nothing_if_exception_thrown_with_correct_message(): void
    {
        $this->expectCallable(
          () ==> {  throw new \HackPack\HackUnit\Core\ExpectationException("Message");
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException', 'Message');
    }

    public function test_toOutputString_does_nothing_when_true(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { echo "an output string"; };
            $expectation = new CallableExpectation($callable);
            $expectation->toOutputString("an output string");
        })->toNotThrow();
    }

    public function test_toOutputString_throws_ExpectationException_if_fails(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { echo "an output string"; };
            $expectation = new CallableExpectation($callable);
            $expectation->toOutputString("something different");
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
    }

    public function test_toOutputString_throws_ExpectationException_if_ob_was_closed(): void
    {
        $this->expectCallable(() ==> {
            $callable = () ==> { echo "an output string"; ob_end_clean(); };
            $expectation = new CallableExpectation($callable);
            $expectation->toOutputString("an output string");
        })->toThrow('\HackPack\HackUnit\Core\ExpectationException');
    }
}
