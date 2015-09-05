<?hh //strict
namespace HackPack\HackUnit\UI;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Core\TestResult;
use HackPack\HackUnit\Core\ExpectationException;
use HackPack\HackUnit\UI\Text;

class TextTest extends TestCase
{
    public function test_getFooter_should_return_count_summary_with_skipped(): void
    {
        $result = $this->getSkippedResult();
        $ui = new Text();
        $this->expect($ui->getFooter($result))->toEqual("OK 1 run, 1 skipped, 0 failed\n");
    }

    public function test_getFooter_should_return_count_summary(): void
    {
        $result = $this->getResult();
        $ui = new Text();
        $this->expect($ui->getFooter($result))->toEqual("FAILURES!\n1 run, 1 failed\n");
    }

    public function test_getFooter_should_return_OK_message_when_no_failures(): void
    {
        $result = new TestResult();
        $result->testStarted();
        $ui = new Text();
        $this->expect($ui->getFooter($result))->toEqual("OK 1 run, 0 failed\n");
    }

    public function test_getFailures_should_print_failure_information(): void
    {
        $result = $this->getResult();
        $ui = new Text();
        $expected = $this->getExpectedFailures(35, "test_getFailures_should_print_failure_information");
        $this->expect($ui->getFailures($result))->toEqual($expected);
    }

    public function test_getReport_should_return_entire_message(): void
    {
        $result = $this->getResult();
        $result->startTimer();
        $ui = new Text();
        $expectedFailures = $this->getExpectedFailures(43, "test_getReport_should_return_entire_message");
        $time = sprintf('%4.2f', $result->getTime());
        $expected = "\n\nTime: $time seconds\n\nThere was 1 failure:\n\n" . $expectedFailures . "FAILURES!\n1 run, 1 failed\n";
        $this->expect($ui->getReport($result))->toEqual($expected);
    }

    public function test_getFooter_should_include_color_on_OK_statement_when_color_enabled(): void
    {
        $result = new TestResult();
        $result->testStarted();
        $ui = new Text();
        $ui->enableColor();

        $expected = sprintf(
            "\033[%d;%dmOK 1 run, 0 failed\033[0m\n",
            $ui->colors->get('bg-green'),
            $ui->colors->get('fg-black')
        );
        $this->expect($ui->getFooter($result))->toEqual($expected);
    }

    public function test_getFooter_should_include_color_and_padding_for_FAILURES_when_color_enabled(): void
    {
        $result = $this->getResult();
        $ui = new Text();
        $ui->enableColor();

        $expected = sprintf(
            "\033[%d;%dmFAILURES!      \n1 run, 1 failed\033[0m\n",
            $ui->colors->get('bg-red'),
            $ui->colors->get('fg-white')
        );
        $this->expect($ui->getFooter($result))->toEqual($expected);
    }

    public function test_getHeader_includes_time_from_result(): void
    {
        $result = $this->getResult();
        $result->startTimer();
        $ui = new Text();
        $this->expect($ui->getHeader($result))->toMatch("/\n\nTime: [0-9]+([.][0-9]{1,2})? seconds?\n\n/");
    }

    protected function getExpectedFailures(int $line, string $method): string
    {
        $expected  = "1) HackPack\HackUnit\UI\TextTest::$method\n";
        $expected .= "Something is wrong\n\n";
        $expected .= __FILE__ . ":$line\n\n";
        return $expected;
    }

    protected function getSkippedResult(): TestResult
    {
        $result = new TestResult();
        $result->testStarted();
        try {
            throw new \Exception("Something is wrong");
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
            throw new \Exception("Something is wrong");
        } catch (\Exception $e) {
            $result->testFailed($e);
        }
        return $result;
    }
}
