<?hh //strict
namespace HackPack\HackUnit\Runner\Loading;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Core\TestSuite;
use HackPack\HackUnit\Runner\Options;

<<__ConsistentConstruct>> class StandardLoader implements LoaderInterface
{
    private static string $testPattern = '/Test[.](?:php|hh)$/';
    private static string $testMethodPattern = '/^test/';

    private Vector<TestCase> $testCases;
    private Instantiator $instantiator;

    public function __construct(protected string $path, protected Set<string> $exclude = Set {})
    {
        $this->testCases = Vector {};
        $this->exclude = $this->exclude->map(($path) ==> (string) realpath($path));
        $this->instantiator = new Instantiator();
    }

    public function loadSuite(): TestSuite
    {
        $testCases = $this->load();
        $suite = new TestSuite();
        foreach ($testCases as $testCase) {
            $suite->add($testCase);
        }
        return $suite;
    }

    public function load(): Vector<TestCase>
    {
        $paths = $this->getTestCasePaths();
        foreach ($paths as $path) {
            $this->addTestCase($path);
        }
        return $this->testCases;
    }

    public function getTestCasePaths(string $searchPath = '', Set<string> $accum = Set {}): Set<string>
    {
        $searchPath = $searchPath ? $searchPath : $this->path;
        $files = is_dir($searchPath) ? scandir($searchPath) : [$searchPath];

        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $newPath = is_file($searchPath) ? $searchPath : $searchPath . "/" . (string)$file;

            if ($this->isExcluded($newPath)) {
                continue;
            }

            if (is_file($newPath)) {
                if (! preg_match(StandardLoader::$testPattern, $newPath)) continue;
                $accum->add($newPath);
                continue;
            }

            $this->getTestCasePaths($newPath, $accum);
        }
        return $accum;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public static function create(Options $options): StandardLoader
    {
        return new static((string) $options->getTestPath(), $options->getExcludedPaths());
    }

    protected function isExcluded(string $path): bool
    {
        $real = realpath($path);

        // realpath returns false when the path does not exist
        if($real === false) {
            return true;
        }
        return $this->exclude->contains($real);
    }

    protected function addTestCase(string $testPath): void
    {
        $this->includeClass($testPath);
        $testCase = $this->instantiator->fromFile($testPath, ['noop']);
        $methods = get_class_methods($testCase);
        foreach ($methods as $method) {
            if (preg_match(StandardLoader::$testMethodPattern, $method)) {
                $test = $this->instantiator->fromObject($testCase, [$method]);
                $this->testCases->add($test);
            }
        }
    }

    protected function includeClass(string $testPath): void
    {
        // UNSAFE
        /* HH_FIXME[1002] */
        include_once($testPath);
    }
}
