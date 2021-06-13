<?php

namespace App\Services;

interface ServiceInterface
{
    public function all();

    public function create($data);

    public function firstOrCreate($data);
}