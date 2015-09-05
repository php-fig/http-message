<?hh //strict
namespace HackPack\HackUnit\Core;

class TestSuite implements TestInterface
{
    public function __construct(protected Vector<TestCase> $tests = Vector {})
    {
    }

    public function add(TestCase $case): void
    {
        $this->tests->add($case);
    }

    public function getTests(): Vector<TestCase>
    {
        return $this->tests;
    }

    public function run(TestResult $result): TestResult
    {
        foreach ($this->tests as $test) {
            $test->run($result);
        }
        return $result;
    }
}
