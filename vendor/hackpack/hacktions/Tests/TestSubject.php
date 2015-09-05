<?hh //strict
namespace HackPack\Hacktions\Tests;

use HackPack\Hacktions\Subject;

class TestSubject
{
    use Subject<TestObserver>;
}
