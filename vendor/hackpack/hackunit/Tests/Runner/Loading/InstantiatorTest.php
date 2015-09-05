<?hh // strict
namespace HackPack\HackUnit\Tests\Runner\Loading;

use HackPack\HackUnit\Core\TestCase;
use HackPack\HackUnit\Runner\Loading\Instantiator;
use \MultipleClassTokenTest;

class InstantiatorTest extends TestCase
{
    public function test_fromFile_creates_object_from_file_with_multiple_class_tokens(): void
    {
        $filename = dirname(dirname(__DIR__)) . '/Fixtures/Instantiating/MultipleClassTokenTest.php';
        /* HH_FIXME[1002] */
        include_once($filename);
        $instantiator = new Instantiator();
        $this->expectCallable(() ==> {
            $object = $instantiator->fromFile($filename, [MultipleClassTokenTest::class]);
            $this->expect(get_class($object))->toEqual(MultipleClassTokenTest::class);
        })->toNotThrow();
    }
}
