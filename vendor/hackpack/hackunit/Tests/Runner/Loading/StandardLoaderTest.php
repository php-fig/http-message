<?hh //strict
namespace HackPack\HackUnit\Tests\Runner\Loading;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Runner\Options;
use HackPack\HackUnit\Runner\Loading\StandardLoader;

require_once __DIR__ . '/../../Fixtures/Loading/Excluded/ThreeTest.php';

class StandardLoaderTest extends TestCase
{
    protected ?StandardLoader $loader;
    protected string $path = '';

    <<Override>> public function setUp(): void
    {
        $this->path = __DIR__ . '/../../Fixtures/Loading';
        $this->loader = new StandardLoader($this->path);
    }

    public function test_getTestCasePaths_should_return_paths_to_test_cases(): void
    {
        if (! $this->loader) throw new \Exception("loader and path cannot be null");
        $paths = $this->loader->getTestCasePaths();
        $this->expect($paths->count())->toEqual(3);
        $this->expect($paths->contains($this->path . '/OneTest.hh'))->toEqual(true);
        $this->expect($paths->contains($this->path . '/TwoTest.php'))->toEqual(true);
        $this->expect($paths->contains($this->path . '/Excluded/ThreeTest.php'))->toEqual(true);
    }

    public function test_getTestCasePaths_should_return_paths_with_single_file(): void
    {
        $loader = new StandardLoader($this->path . '/OneTest.hh');
        $paths = $loader->getTestCasePaths();
        $this->expect($paths->count())->toEqual(1);
        $this->expect($paths->contains($this->path . '/OneTest.hh'))->toEqual(true);
    }

    public function test_load_should_return_classes_ending_in_Test_for_every_method(): void
    {
        if (! $this->loader) throw new \Exception("loader cannot be null");
        $pattern = '/Test$/';
        $objects = $this->loader->load();
        $this->expect($objects->count())->toEqual(6);

        $oneTest = $objects->at(2);
        $oneTest2 = $objects->at(3);
        $this->expect($oneTest->getName())->toEqual('testOne');
        $this->expect($oneTest2->getName())->toEqual('testTwo');

        $twoTest = $objects->at(4);
        $twoTest2 = $objects->at(5);
        $this->expect($twoTest->getName())->toEqual('testThree');
        $this->expect($twoTest2->getName())->toEqual('testFour');

        $threeTest = $objects->at(0);
        $threeTest2 = $objects->at(1);
        $this->expect($threeTest->getName())->toEqual('testFive');
        $this->expect($threeTest2->getName())->toEqual('testSix');
    }

    public function test_loadSuite_should_use_results_of_load_to_create_a_TestSuite(): void
    {
        if (! $this->loader) throw new \Exception("loader cannot be null");
        $suite = $this->loader->loadSuite();
        $tests = $suite->getTests();
        $this->expect($tests->count())->toEqual(6);
    }

    public function test_getTestCasePaths_should_exclude_dirs(): void
    {
        $options = new Options();
        $options
            ->setTestPath($this->path)
            ->setExcludedPaths($this->path . '/Excluded');
        $loader = StandardLoader::create($options);
        $paths = $loader->getTestCasePaths();
        $this->expect($paths->count())->toEqual(2);
    }

    public function test_getTestCasePaths_should_exclude_nonexistent_dirs(): void
    {
        $options = new Options();
        $options
            ->setTestPath($this->path . '/DoesNotExist');
        $loader = StandardLoader::create($options);
        $paths = $loader->getTestCasePaths();
        $this->expect($paths->count())->toEqual(0);
    }
}
