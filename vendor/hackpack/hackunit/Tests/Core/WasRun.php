<?hh //strict
namespace HackPack\HackUnit\Tests\Core;

use HackPack\HackUnit\Core\TestCase;

class WasRun extends TestCase
{
    public string $log = '';

    <<Override>> public function setUp(): void
    {
        $this->log = 'setUp ';
    }

    <<Override>> public function tearDown(): void
    {
        $this->log .= 'tearDown ';
    }

    public function testMethod(): void
    {
        $this->log .= 'testMethod ';
    }

    public function testBrokenMethod(): void
    {
        throw new \Exception("broken");
    }

    public function testSkip(): void
    {
        $this->markAsSkipped("Skippy");
    }
}
