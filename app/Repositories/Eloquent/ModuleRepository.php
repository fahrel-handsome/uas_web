<?php

namespace App\Repositories\Eloquent;

use App\Models\Module;
use App\Repositories\Contracts\ModuleRepositoryInterface;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function getAll()
    {
        return Module::all();
    }
    
    public function getById($id)
    {
        return Module::findOrFail($id);
    }
    
    public function create(array $data)
    {
        return Module::create($data);
    }
}
