<?php

namespace App\Repository\Base;

use App\Interfaces\CRUD\CRUDInterface;
use App\Interfaces\ModelFilterInterface;
use App\Traits\Repository\HasFilter;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseRepository implements CRUDInterface, ModelFilterInterface
{
    use HasFilter;

    public function all(): Collection
    {
        $model = $this->getModel();

        $query = $model::query();

        $this->applyFilter($query);

        return $query->get();
    }

    public function paginated(int $count = 25)
    {
        $model = $this->getModel();

        $query = $model::query();

        $this->applyFilter($query);

        return $query->paginate($count);
    }

    public function show(int $id)
    {
        $model = $this->getModel();

        return $model::find($id);
    }

    public function create(array $data)
    {
        $model = $this->getModel();

        if($model::where($data)->exists()) {
            return $model::where($data)->first();
        }

        $newInstance = new $model();

        $newInstance->fill($data);

        $newInstance->save();

        $newInstance->_created = true;

        return $newInstance;
    }

    public function delete(int $id): bool
    {
        $model = $this->getModel();

        return $model::where('id', $id)->delete();
    }

    public function update(int $id, array $data)
    {
        $model = $this->getModel();

        $existedInstance = $model::find($id);

        $existedInstance->fill($data);

        $existedInstance->save();

        return $existedInstance;
    }

    abstract public function getModel(): string;
}
