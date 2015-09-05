<?hh //strict
namespace HackPack\HackUnit\Core;

use HackPack\HackUnit\Error\TraceParser;
use HackPack\HackUnit\Error\Origin;
use HackPack\Hacktions\EventEmitter;

class TestResult
{
    use EventEmitter;

    protected Vector<Origin> $failures;
    protected Vector<Origin> $skipped;
    protected ?float $startTime;
    protected ?float $endTime;

    public function __construct(protected int $runCount = 0, protected int $errorCount = 0)
    {
        $this->failures = Vector {};
        $this->skipped = Vector {};
    }

    public function testStarted(): void
    {
        $this->runCount++;
    }

    public function startTimer(): void
    {
        $this->startTime = microtime(true);
        $this->endTime = null;
    }

    public function getStartTime(): ?float
    {
        return $this->startTime;
    }

    public function getTime(): ?float
    {
        if($this->endTime === null) {
            $this->endTime = microtime(true);
        }

        if($this->startTime === null) {
            return null;
        }

        return (float)($this->endTime - $this->startTime);
    }

    public function getTestCount(): int
    {
        return $this->runCount;
    }

    public function testPassed(): void
    {
        $this->trigger('testPassed');
    }

    public function testFailed(\Exception $exception): void
    {
        $parser = new TraceParser($exception);
        $this->failures->add($parser->getOrigin());
        $this->errorCount++;
        $this->trigger('testFailed');
    }

    public function testSkipped(\Exception $exception): void
    {
        $parser = new TraceParser($exception);
        $this->skipped->add($parser->getOrigin());
        $this->errorCount++;
        $this->trigger('testSkipped');
    }

    public function getExitCode(): int
    {
        return ($this->failures->count() > 0)
            ? 1 : 0;
    }

    public function getFailures(): Vector<Origin>
    {
        return $this->failures;
    }

    public function getSkipped(): Vector<Origin>
    {
        return $this->skipped;
    }
}
