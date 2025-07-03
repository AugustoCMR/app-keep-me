<?php

namespace App\Services\Income;

use App\Exceptions\ApiException;
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
        $incomes = $this->repository->all();

        if($incomes->isEmpty())
        {
            throw new ApiException('Incomes not found', 404);
        }

        return $incomes;
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): Model
    {
        $income = $this->repository->find($id);

        if(empty($income))
        {
            throw new ApiException('Income not found', 404);
        }

        return $income;
    }

    public function create(array $data): Model
    {
        $income = $this->repository->create($data);

        return $income;
    }

    public function update(array $data, int $id): Model
    {
        $income = $this->repository->find($id);

        if (empty($income))
        {
            throw new ApiException('Income not found', 404);
        }

        $this->repository->update($data, $id);

        return $income->refresh();
    }

    public function delete(int $id): void
    {
        $income = $this->repository->find($id);

        if(empty($income))
        {
            throw new ApiException('Income not found', 404);
        }

        $income->delete();
    }
}
