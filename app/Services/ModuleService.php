<?php

namespace App\Services;

use App\Models\Module;
use App\Repositories\Contracts\ModuleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ModuleService
{
    public function __construct(
        private readonly ModuleRepositoryInterface $repository
    ) {}

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

    public function getAllPublished(): Collection
    {
        return $this->repository->getAllPublished();
    }

    public function getById(int $id): ?Module
    {
        return $this->repository->findById($id);
    }

    public function getBySlug(string $slug): ?Module
    {
        return $this->repository->findBySlug($slug);
    }

    public function create(array $data): Module
    {
        $data['slug']         = Str::slug($data['title']);
        $data['is_published'] = isset($data['status']) && $data['status'] === 'published';
        return $this->repository->create($data);
    }

    public function update(Module $module, array $data): Module
    {
        $data['slug']         = Str::slug($data['title']);
        $data['is_published'] = isset($data['status']) && $data['status'] === 'published';
        return $this->repository->update($module, $data);
    }

    public function delete(Module $module): bool
    {
        return $this->repository->delete($module);
    }
}
