<?hh //strict
namespace HackPack\HackUnit\Tests\Runner;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Runner\Options;

class OptionsTest extends TestCase
{
    public function test_getExcludedPaths_splits_set_string_into_set(): void
    {
        $options = new Options();
        $options->setExcludedPaths("path/to/excluded1 path/to/excluded2");
        $excluded = $options->getExcludedPaths();

        $this->expect($excluded->contains('path/to/excluded1'))->toEqual(true);
        $this->expect($excluded->contains('path/to/excluded2'))->toEqual(true);
    }

    public function test_getTestPath_returns_cwd_if_not_specified(): void
    {
        $options = new Options();

        $this->expect($options->getTestPath())->toEqual(getcwd());
    }

    public function test_getHackUnitFile_searches_cwd_if_hackunit_file_not_specified(): void
    {
        chdir(__DIR__);
        $options = new Options();
        $expected = realpath(__DIR__ . '/Hackunit.php');

        $this->expect($options->getHackUnitFile())->toEqual($expected);
    }
}
