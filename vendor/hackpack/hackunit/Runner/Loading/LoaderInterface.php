<?hh //strict
namespace HackPack\HackUnit\Runner\Loading;

use HackPack\HackUnit\Core\TestSuite;
use HackPack\HackUnit\Core\TestCase;

interface LoaderInterface
{
    /**
     * Load all TestCase objects into a single TestSuite
     * object
     */
    public function loadSuite(): TestSuite;

    /**
     * Load test paths into a vector of TestCase
     * objects
     */
    public function load(): Vector<TestCase>;

    /**
     * Return a set of test paths
     */
    public function getTestCasePaths(): Set<string>;

    /**
     * Return the path used for loading
     */
    public function getPath(): string;
}
