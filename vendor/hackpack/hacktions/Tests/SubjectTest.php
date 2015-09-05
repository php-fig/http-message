<?hh //strict
namespace HackPack\Hacktions\Tests;

use HackPack\HackUnit\Core\TestCase;
use HackPack\Hacktions\Subject;

class SubjectTest extends TestCase
{
    public function test_registerObserver_registers_observer(): void
    {
        $subject = new TestSubject();
        $observer = new TestObserver();
        $subject->registerObserver($observer);

        $this->expect($subject->getObservers()->count())->toEqual(1);
    }

    public function test_notifyObservers_notifies_observers(): void
    {
        $subject = new TestSubject();
        $observer = new TestObserver();
        $subject->registerObserver($observer);

        $subject->notifyObservers();

        $this->expect($observer->getNotificationCount())->toEqual(1);
    }


    public function test_notifyObservers_can_pass_variable_arguments(): void
    {
        $subject = new TestSubject();
        $observer = new TestObserver();
        $subject->registerObserver($observer);
        $ints = Vector {};
        $strs = Vector {};

        $subject->notifyObservers($ints, $strs);

        $this->expect($observer->getNotificationCount())->toEqual(1);
        $this->expect($ints->at(0))->toEqual(1);
        $this->expect($strs->at(0))->toEqual("test");
    }

    public function test_removeObserver_removes_observer(): void
    {
        $subject = new TestSubject();
        $observer = new TestObserver();
        $subject->registerObserver($observer);
        $subject->removeObserver($observer);

        $this->expect($subject->getObservers()->count())->toEqual(0);
    }
}
