<?hh // strict

use HackPack\HackUnit\Core\TestCase;

class MultipleClassTokenTest extends TestCase
{
    public function testHasClassToken() : void
    {
        MultipleClassTokenTest::class;
    }
}
