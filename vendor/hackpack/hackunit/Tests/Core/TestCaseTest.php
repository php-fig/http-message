<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Core\TestResult;
use HackPack\HackUnit\Core\TestSuite;

class TestCaseTest extends TestCase
{
    private ?WasRun $test;

    <<Override>> public function setUp(): void
    {
        $this->test = new WasRun('testMethod');
    }

    public function testResult(): void
    {
        $test = $this->test;
        if ($test) {
            $result = $test->run(new TestResult());
            $this->expect($result->getTestCount())->toEqual(1);
        }
    }

    public function testTemplateMethod(): void
    {
        $test = $this->test;
        if ($test) {
            $test->run(new TestResult());
            $this->expect($test->log)->toEqual('setUp testMethod tearDown ');
        }
    }

    public function testFailedResult(): void
    {
        $test = new WasRun('testBrokenMethod');
        $result = $test->run(new TestResult());
        $count = $result->getTestCount();
        $failures = $result->getFailures();
        $this->expect($count)->toEqual(1);
        $this->expect(count($failures))->toEqual(1);
    }

    public function testSkippedResult(): void
    {
        $test = new WasRun('testSkip');
        $result = $test->run(new TestResult());
        $count = $result->getTestCount();
        $skipped = $result->getSkipped();
        $this->expect($count)->toEqual(1);
        $this->expect(count($skipped))->toEqual(1);
    }

    public function testSuite(): void
    {
        $result = new TestResult();
        $suite = new TestSuite();
        $suite->add(new WasRun('testMethod'));
        $suite->add(new WasRun('testBrokenMethod'));
        $result = $suite->run($result);
        $count = $result->getTestCount();
        $failures = $result->getFailures();
        $this->expect($count)->toEqual(2);
        $this->expect(count($failures))->toEqual(1);
    }
}
