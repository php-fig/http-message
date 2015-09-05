<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\TestResult;
use HackPack\HackUnit\Core\TestCase;

class TestResultTest extends TestCase
{
    public function test_getTestCount_should_return_number_of_tests_run(): void
    {
        $result = $this->getResult();
        $count = $result->getTestCount();
        $this->expect($count)->toEqual(1);
    }

    public function test_getFailures_returns_method(): void
    {
        $result = $this->getResult();
        $failures = $result->getFailures();
        $failure = $failures->at(0);
        $method = $failure['method'];
        $this->expect($method)->toEqual('HackPack\HackUnit\Tests\Core\TestResultTest::test_getFailures_returns_method');
    }

    public function test_getFailures_returns_message(): void
    {
        $result = $this->getResult();
        $failures = $result->getFailures();
        $failure = $failures->at(0);
        $message = $failure['message'];
        $this->expect($message)->toEqual('Failure');
    }

    public function test_getFailures_returns_location(): void
    {
        $result = $this->getResult();
        $failures = $result->getFailures();
        $failure = $failures->at(0);
        $location = $failure['location'];
        $this->expect($location)->toEqual(__FILE__ . ':36');
    }

    public function test_getExitCode_returns_1_if_failures(): void
    {
        $result = $this->getResult();
        $this->expect($result->getExitCode())->toEqual(1);
    }

    public function test_getSkipped_returns_message(): void
    {
        $result = $this->getSkippedResult();
        $skipped = $result->getSkipped();
        $skip = $skipped->at(0);
        $message = $skip['message'];
        $this->expect($message)->toEqual('Skipped');
    }

    public function test_startTimer_should_set_start_time(): void
    {
        $result = new TestResult();
        $result->startTimer();
        $time = $result->getStartTime();

        $this->expect(is_null($time))->toEqual(false);
    }

    public function test_getTime_should_return_time_since_start(): void
    {
        $result = new TestResult();
        $result->startTimer();
        $startTime = $result->getStartTime();
        $time = $result->getTime();

        $this->expect($time < $startTime)->toEqual(true);
    }

    protected function getSkippedResult(): TestResult
    {
        $result = new TestResult();
        $result->testStarted();
        try {
            throw new \Exception("Skipped");
        } catch (\Exception $e) {
            $result->testSkipped($e);
        }
        return $result;
    }

    protected function getResult(): TestResult
    {
        $result = new TestResult();
        $result->testStarted();
        try {
            throw new \Exception("Failure");
        } catch (\Exception $e) {
            $result->testFailed($e);
        }
        return $result;
    }
}
