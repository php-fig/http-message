<?hh //strict
namespace HackPack\HackUnit\Core;

class Expectation<T>
{
    public function __construct(protected T $actual)
    {
    }

    public function getContext(): T
    {
        return $this->actual;
    }

    public function toEqual(T $expected): void
    {
        if ($expected != $this->actual) {
            $expectedDump = $this->captureVarDump($expected);
            $actualDump = $this->captureVarDump($this->actual);
            $message = sprintf(
                "Unexpected value.\n\nExpected:\n%sActual:\n%s",
                $expectedDump,
                $actualDump,
            );
            throw new ExpectationException($message);
        }
    }

    public function toBeIdenticalTo(T $expected): void
    {
        if ($expected !== $this->actual) {
            $expectedDump = $this->captureVarDump($expected);
            $actualDump = $this->captureVarDump($this->actual);
            $message = sprintf(
                "Values are not identical.\n\nExpected:\n%sActual:\n%s",
                $expectedDump,
                $actualDump,
            );
            throw new ExpectationException($message);
        }
    }

    public function toMatch(string $pattern): void
    {
        if ( ! preg_match($pattern, $this->actual)) {
            $message = sprintf(
                'Expected pattern %s to match "%s"',
                $pattern,
                $this->actual,
            );
            throw new ExpectationException($message);
        }
    }

    private function captureVarDump(mixed $var) : string
    {
        ob_start();
        trim(implode("\n    ", explode("\n", var_dump($var))));
        return '    ' . ob_get_clean();
    }

    public function toBeInstanceOf(string $expectedClassName): void
    {
        if(is_a($this->actual, $expectedClassName)){
            return;
        }

        if (is_object($this->actual)) {
            $type = get_class($this->actual);
        } else {
            $type = gettype($this->actual);
        }

        $message = sprintf(
            "Unexpected object type.\n\nExpected: %s\nActual: %s",
            $expectedClassName,
            $type
        );
        throw new ExpectationException($message);
    }

}
