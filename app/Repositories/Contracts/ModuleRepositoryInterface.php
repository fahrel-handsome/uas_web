<?php

namespace App\Repositories\Contracts;

use App\Models\Module;
use Illuminate\Database\Eloquent\Collection;

interface ModuleRepositoryInterface
{
    public function getAll(): Collection;
    public function getAllPublished(): Collection;
    public function findById(int $id): ?Module;
    public function findBySlug(string $slug): ?Module;
    public function create(array $data): Module;
    public function update(Module $module, array $data): Module;
    public function delete(Module $module): bool;
}
