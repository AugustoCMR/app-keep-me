<?php

namespace App\Repositories\Income;

use App\Models\Account;
use App\Repositories\BaseRepository;

class IncomeRepository extends BaseRepository
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }
}
