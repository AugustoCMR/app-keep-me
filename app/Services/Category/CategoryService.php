<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class CategoryService
{
    private $repository;
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): Collection
    {
        $categories = $this->repository->all();

        if($categories->isEmpty())
        {
            throw new Exception('Categories not found');
        }

        return $categories;
    }

    public function findById(int $id): Model
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            throw new Exception('Category not found');
        }

        return $category;
    }

    public function createCategoryAndAttachToUser(array $data): Model
    {
        $category = $this->repository->create($data);

        $user = auth('api')->user();

        $user->categories()->attach($category->id);

        return $category;
    }

    public function update(array $data, int $id): Model
    {
        $category = $this->repository->find($id);

        if (empty($category))
        {
            throw new Exception('Category not found');
        }

        $this->repository->update($data, $id);

        return $category;
    }

    public function detachCategoryFromUser(int $id): void
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            throw new Exception('Category not found');
        }

        $userId = auth('api')->id();

        $category->users()->detach($userId);


    }
}
