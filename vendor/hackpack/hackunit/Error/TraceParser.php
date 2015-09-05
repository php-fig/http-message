<?hh //strict
namespace HackPack\HackUnit\Error;

type Origin = shape(
    'method' => string, 
    'message' => string,
    'location' => string,
);

newtype Location = shape(
    'file' => string,
    'line' => int
);

class TraceParser
{
    public function __construct(protected \Exception $exception)
    {
    }

    public function getOrigin(): Origin
    {
        $trace = $this->exception->getTrace();
        $test = $trace[1];
        $location = $this->getLocation($trace);
        return shape(
            'method' => sprintf('%s::%s', $test['class'], $test['function']),
            'message' => $this->exception->getMessage(),
            'location' => ($location != null) ? sprintf('%s:%s', $location['file'], $location['line']) : ''
        );
    }

    protected function getLocation(array<array<string, string>> $trace): ?Location
    {
        foreach ($trace as $item) {
            if (array_key_exists('line', $item)) {
                return shape('file' => $item['file'], 'line' => (int) $item['line']);
            }
        }
        return null;
    }

}
