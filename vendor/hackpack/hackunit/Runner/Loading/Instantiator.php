<?hh //strict
namespace HackPack\HackUnit\Runner\Loading;

class Instantiator
{
    const int T_NAMESPACE = 377;
    const int T_STRING = 307;
    const int T_CLASS = 353;

    private static Map<string, string> $pathMap = Map {};

    public function fromClassName<T>(string $className, array<mixed> $args): T
    {
        return hphp_create_object($className, $args);
    }

    public function fromObject<T>(T $object, array<mixed> $args): T
    {
        $className = get_class($object);
        return $this->fromClassName($className, $args);
    }

    public function fromFile<T>(string $classPath, array<mixed> $args): T
    {
        //check for cached version
        if (Instantiator::$pathMap->containsKey($classPath)) {
            return $this->fromClassName(Instantiator::$pathMap->at($classPath), $args);
        }

        //incrementally break contents into tokens
        $fp = fopen($classPath, 'r');
        $namespace = $class = $buffer = '';
        $i = 0;
        while (!$class) {
            if (feof($fp)) break;
            $buffer .= (string) fread($fp, 512);
            $tokens = token_get_all($buffer);

            if (strpos($buffer, '{') === false) continue;

            for (; $i < count($tokens); $i++) {

                //search for a namespace
                if ($tokens[$i][0] === Instantiator::T_NAMESPACE) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j][0] === Instantiator::T_STRING) {
                            $namespace .= '\\' . (string) $tokens[$j][1];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }

                //search for the class name
                if ($tokens[$i][0] === Instantiator::T_CLASS) {
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        if ($tokens[$j] === '{') {
                            $class = $tokens[$i + 2][1];
                            break;
                        }
                    }
                }
                if($class) {
                    // Stop looking for the class name after it is found
                    break;
                }
            }
        }

        //cache path and class name and return instance
        $className = $namespace . '\\' . $class;
        Instantiator::$pathMap->add(Pair {$classPath, $className});
        return $this->fromClassName($className, $args);
    }
}
