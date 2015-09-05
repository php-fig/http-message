<?hh //strict
namespace HackPack\Hacktions\Tests;

use HackPack\Hacktions\Observer;

class TestObserver implements Observer<TestSubject>
{
    protected int $count = 0;

    public function getNotificationCount(): int
    {
        return $this->count;
    }

    public function update(TestSubject $subject, ...): void
    {
        $this->count++;
        $args = array_slice(func_get_args(), 1);
        if (count($args) > 1) {
            $ints = $args[0];
            $strs = $args[1];
            $ints->add(1);
            $strs->add("test");
        }
    }
}
