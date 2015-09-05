<?hh //strict
namespace HackPack\HackUnit\Tests\Runner;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Runner\Loading\StandardLoader;
use HackPack\HackUnit\Runner\Runner;
use HackPack\HackUnit\Runner\Options;

class RunnerTest extends TestCase
{
    protected ?(function(Options): StandardLoader) $factory;

    <<Override>> public function setUp(): void
    {
        $this->factory = class_meth('\HackPack\HackUnit\Runner\Loading\StandardLoader', 'create');
    }

    public function test_runner_constructs_loader_via_factory_using_options(): void
    {
        $options = new Options();
        $options->setTestPath(__DIR__);
        $runner = new Runner($options, $this->factory ?: ($opts) ==> new StandardLoader('null'));

        $loader = $runner->getLoader();

        $this->expect($loader->getPath())->toEqual(__DIR__);
    }

    public function test_run_returns_result_from_loader(): void
    {
        $factory = $this->factory ?: ($opts) ==> new StandardLoader('null');
        $options = new Options();
        $options->setTestPath(__DIR__ . '/../Fixtures/Loading');
        $runner = new Runner($options, $factory);

        $result = $runner->run();

        $this->expect($result->getTestCount())->toEqual(6);
    }

    public function test_run_returns_result_with_a_started_timer(): void
    { 
        $factory = $this->factory ?: ($opts) ==> new StandardLoader('null');
        $options = new Options();
        $options->setTestPath(__DIR__ . '/../Fixtures/Loading');
        $runner = new Runner($options, $factory);

        $result = $runner->run();

        $this->expect(is_null($result->getTime()))->toEqual(false);
    }
}
