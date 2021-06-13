<?php

namespace App\Services;

use Illuminate\Support\Collection;

abstract class AbstractService implements ServiceInterface
{
    public function create($data)
    {
        return $this->createModel(collect($data));
    }

    public function firstOrCreate($data)
    {
        return $this->firstOrCreateModel(collect($data));
    }
    
    public function createMany($data)
    {
        return $this->createManyModels(collect($data));
    }
}