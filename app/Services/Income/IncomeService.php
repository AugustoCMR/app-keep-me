<?php

namespace App\Services\Income;

use App\Exceptions\ApiException;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Income\IncomeRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class IncomeService
{
    private IncomeRepository $repository;
    public function __construct(IncomeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function getAll(): Collection
    {
        $categories = $this->repository->all();

        if($categories->isEmpty())
        {
            throw new ApiException('Categories not found', 404);
        }

        return $categories;
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): Model
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            throw new ApiException('Category not found', 404);
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
            throw new ApiException('Category not found', 404);
        }

        $this->repository->update($data, $id);

        return $category;
    }

    public function detachCategoryFromUser(int $id): void
    {
        $category = $this->repository->find($id);

        if(empty($category))
        {
            throw new ApiException('Category not found', 404);
        }

        $userId = auth('api')->id();

        $category->users()->detach($userId);


    }
}
