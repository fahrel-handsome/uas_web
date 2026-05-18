<?php

namespace App\Repositories\Eloquent;

use App\Models\Module;
use App\Repositories\Contracts\ModuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function getAll(): Collection
    {
        return Module::withCount('courses')
            ->orderBy('order')
            ->get();
    }

    public function getAllPublished(): Collection
    {
        return Module::where('is_published', true)
            ->withCount('courses')
            ->orderBy('order')
            ->get();
    }

    public function findById(int $id): ?Module
    {
        return Module::with('courses')->find($id);
    }

    public function findBySlug(string $slug): ?Module
    {
        return Module::with(['courses' => fn($q) => $q->where('is_published', true)->orderBy('order')])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    public function create(array $data): Module
    {
        return Module::create($data);
    }

    public function update(Module $module, array $data): Module
    {
        $module->update($data);
        return $module->fresh();
    }

    public function delete(Module $module): bool
    {
        return $module->delete();
    }
}
