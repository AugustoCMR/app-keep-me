<?php

namespace App\Services\Account;

use App\Exceptions\ApiException;
use App\Repositories\Account\AccountRepository;
use App\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AccountService
{
    private AccountRepository $repository;
    public function __construct(AccountRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function getAll(): Collection
    {
        $accounts = $this->repository->all();

        if($accounts->isEmpty())
        {
            throw new ApiException('Accounts not found', 404);
        }

        return $accounts;
    }

    /**
     * @throws Exception
     */
    public function findById(int $id): Model
    {
        $account = $this->repository->find($id);

        if(empty($account))
        {
            throw new ApiException('Account not found', 404);
        }

        return $account;
    }

    public function createAccountAndAttachToUser(array $data): Model
    {
        $account = $this->repository->create($data);

        $user = auth('api')->user();

        $user->accounts()->attach($account->id);

        return $account;
    }

    public function update(array $data, int $id): Model
    {
        $account = $this->repository->find($id);

        if (empty($account))
        {
            throw new ApiException('Account not found', 404);
        }

        $this->repository->update($data, $id);

        return $account;
    }

    public function detachAccountFromUser(int $id): void
    {
        $account = $this->repository->find($id);

        if(empty($account))
        {
            throw new ApiException('Account not found', 404);
        }

        $userId = auth('api')->id();

        $account->users()->detach($userId);
    }
}
