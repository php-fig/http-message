<?hh //strict
namespace HackPack\HackUnit\UI;

use HackPack\HackUnit\Core\TestResult;
use HackPack\HackUnit\Error\Origin;

class Text implements TextReporterInterface
{
    public Map<string, int> $colors = Map {
        'bg-green' => 42,
        'fg-black' => 30,
        'bg-red' => 41,
        'fg-white' => 37
    };

    protected bool $colorIsEnabled;

    protected int $maxColumns = 63;

    protected int $currentColumn = 0;

    public function __construct()
    {
        $this->colorIsEnabled = false;
    }

    public function printFeedback(string $feedback): void
    {
        if ($this->currentColumn == $this->maxColumns) {
            print "\n";
            $this->currentColumn = 0;
        }
        print $feedback;
        $this->currentColumn++;
    }

    public function getReport(TestResult $result): string
    {
        $failCount = count($result->getFailures());
        return sprintf(
            "%s%s%s%s",
            $this->getHeader($result) ?: "\n",
            $failCount == 0 ? '' : sprintf(
                "There %s %d %s:\n\n",
                $failCount > 1 ? 'were' : 'was',
                $failCount,
                $failCount > 1 ? 'failures' : 'failure'
            ),
            $this->getFailures($result),
            $this->getFooter($result)
        );
    }

    public function printReport(TestResult $result): void
    {
        print $this->getReport($result);
    }

    public function getFailures(TestResult $result): string
    {
        $failures = "";
        $origins = $result->getFailures();
        for($i = 0; $i < $origins->count(); $i++) {
            $method = sprintf("%d) %s\n", $i + 1, $origins[$i]['method']);
            $message = sprintf("%s\n\n", $origins[$i]['message']);
            $location = sprintf("%s\n\n", $origins[$i]['location']);
            $failures .= $method . $message . $location;
        }
        return $failures;
    }

    public function getHeader(TestResult $result): string
    {
        $time = $result->getTime();
        if (is_null($time)) return '';

        $unit = ($time == 1) ? 'second' : 'seconds';

        return sprintf("\n\nTime: %4.2f %s\n\n", $time, $unit);
    }

    public function getFooter(TestResult $result): string
    {
        $message = $this->footerBuilder($result);
        return $this->formatFooter($message, count($result->getFailures()) > 0);
    }

    private function footerBuilder(TestResult $result): string
    {
        $output = "";
        $failureCount = count($result->getFailures());
        $skippedCount = count($result->getSkipped());
        if ($failureCount > 0 ) {
            $output .= "FAILURES!\n";
        } else {
            $output .= "OK ";
        }

        $output .= sprintf("%d run, ", $result->getTestCount());

        if ($skippedCount > 0) {
            $output .= sprintf("%d skipped, ", $skippedCount);
        }

        $output .= sprintf("%d failed", $failureCount);

        return $output;
    }

    public function enableColor(): void
    {
        $this->colorIsEnabled = true;
    }

    protected function formatFooter(string $footer, bool $hasFailures): string
    {
        $formatted = $footer;
        $lines = explode("\n", $formatted);
        $padding = max(array_map(fun('strlen'), $lines));
        if ($this->colorIsEnabled) {
            $message = array_reduce($lines, ($r, $l) ==> $r . str_pad($l, $padding) . "\n", "");
            $formatted = sprintf(
                "\033[%d;%dm%s\033[0m",
                $this->colors->get($hasFailures ? 'bg-red' : 'bg-green'),
                $this->colors->get($hasFailures ? 'fg-white' : 'fg-black'),
                trim($message)
            );
        }
        return $formatted . "\n";
    }
}
