<?hh //strict

namespace HackPack\HackUnit\Core;

class CallableExpectation
{
    public function __construct(protected (function(): void) $context)
    {
    }

    public function toThrow(string $exceptionType, ?string $expectedMessage = null): void
    {
        try {
            $fun = $this->context;
            $fun();
        } catch (\Exception $e) {
            if (!is_a($e, $exceptionType)) {
                $message = sprintf(
                    "Unexpected exception type.\n\nExpected: %s\nActual: %s\nFile: %s (%d)",
                    $exceptionType,
                    get_class($e),
                    $e->getFile(),
                    $e->getLine(),
                );
                throw new ExpectationException($message);
            }

            if ($expectedMessage !== null && $expectedMessage != $e->getMessage()) {
                $actualMessage = $e->getMessage();
                $message = sprintf(
                    "Unexpected exception message.\n\nException type: %s\nExpected message: %s\nActual message: %s",
                    get_class($e),
                    $expectedMessage,
                    $actualMessage
                );
                throw new ExpectationException($message);
            }

            return;
        }

        throw new ExpectationException("Expected exception of type $exceptionType.\nNo exception was thrown.");

    }

    public function toNotThrow(): void
    {
        $thrown = false;
        try {
            $fun = $this->context;
            $fun();
            $exceptionType = '';
        } catch (\Exception $e) {
            $exceptionType = get_class($e);
            $message = sprintf(
                "Unexpected exception thrown.\nType: %s\nFile: %s (%d)\nMessage: %s",
                get_class($e),
                $e->getFile(),
                (string)$e->getLine(),
                $e->getMessage()
            );
            throw new ExpectationException($message);
        }
    }

    public function toOutputString(string $expectedOutput): void
    {
        $fun = $this->context;

        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        ob_start();
        $obLevel = ob_get_level();

        $fun();

        if (ob_get_level() != $obLevel) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $message = 'Test code or tested code did not (only) close its own output buffers';
            throw new ExpectationException($message);
        }

        $actualOutput = ob_get_contents();
        ob_end_clean();

        $expectation = new Expectation($actualOutput);
        $expectation->toEqual($expectedOutput);
    }
}
