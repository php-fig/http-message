Hacktions
=========

> "hacktions speak louder than words"

Events for Hacklang

Usage
-----

Hacktions exposes two traits:

##EventEmitter

Run of the mill event emitter with hack type safety.

```php
class MyEmitter
{
   use EventEmitter;
}

$emitter = new MyEmitter();

//listeners all use variable argument signatures
$lambda = (...) ==> print(func_get_args()[0]); 
$emitter->on('myevent', $lambda);

//trigger fires all registered events with the given name - can take variable arguments
$emitter->trigger('myevent', 'brian');

$emitter->off('myevent', $lambda); //remove a single listener
$emitter->removeListeners(); //remove all listeners
$emitter->removeListeners('myevent') //remove all 'myevent' events
```

##Subject<T>

Hacktions supports explicit subject/observer relationships:

```php
class Cook
{
    //Cook notifies Waiter objects
    use Subject<Waiter>;

    protected Vector<Burger> $cookedBurgers = {};

    public function cook(Burger $burger): void
    {
        $this->cookedBurgers->add($burger);
        $this->notifyObservers();
    }

    //implement methods to work on cooked items...
}

class Waiter implements Observer<Cook>
{
    //Waiter observes a cook
    public function update(Cook $cook, ...): void
    {
        $burger = $cook->orderUp();
        //deliver burger...
    }
}
```

The Subject has the following methods:

###registerObserver(T $observer): void

Registers a new observer with the subject.

###removeObserver(T $observer): void

Removes the specified object from the list of observers.

###notifyObservers(...): void

Notify all observers of a change and optionally pass additional data.

##Running tests

Tests are written using [HackUnit](https://github.com/HackPack/HackUnit). They can be run with the following:

```
bin/hackunit Tests/
```

##hhi
As always, make sure to copy hhi files to the project directory if type checking is desired:

```
cp -r /usr/share/hhvm/hack/hhi /path/to/hacktions
```
