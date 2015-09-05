<?hh //strict
namespace HackPack\Hacktions;

trait Subject<T>
{
    use EventEmitter;

    protected Vector<T> $observers = Vector {};

    public function registerObserver(T $observer): void
    {
        $this->observers->add($observer);
    }

    public function removeObserver(T $observer): void
    {
        $index = $this->observers->linearSearch($observer);
        if ($index > -1) {
            $this->observers->removeKey($index);
        }
    }

    public function notifyObservers(...): void
    {
        foreach ($this->observers as $observer) {
            invariant($observer instanceof Observer, 'Subjects can only notify Observers');
            $update = inst_meth($observer, 'update');
            $args = array_merge([$this], func_get_args());
            call_user_func_array($update, $args);
        }
    }

    public function getObservers(): Vector<T>
    {
        return $this->observers;
    }
}
