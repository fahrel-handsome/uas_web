<?php

namespace App\Repositories\Contracts;

interface ModuleRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function create(array $data);
}
