<?hh //strict
namespace HackPack\Hacktions;

interface Observer<T>
{
    public function update(T $update, ...): void;
}
