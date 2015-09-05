<?hh //strict
namespace HackUnit;

class ClassLoader
{
    public static Vector<string> $searchPaths = Vector {};

    public static function register(): void
    {
        static::$searchPaths->add(__DIR__ . '/..');
        $cb = class_meth('\HackUnit\ClassLoader', 'autoload');
        spl_autoload_register($cb);
    }

    public static function autoload(string $class): void
    {
        $parts = explode('\\', $class);
        $path = implode('/', $parts);
        foreach (static::$searchPaths as $spath) {
            $absPath = $spath . '/' . $path . '.php';
            if (file_exists($absPath)) {
                // UNSAFE
                /* HH_FIXME[1002] */
                include_once($absPath);
                break;
            }
        }
    }

    public static function addSearchPath(string $searchPath): void 
    {
        static::$searchPaths->add($searchPath);
    }
}
