<?hh //strict
namespace HackPack\HackUnit\Core;

interface TestInterface
{
    public function run(TestResult $result): TestResult;
}
