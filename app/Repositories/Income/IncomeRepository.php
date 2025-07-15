<?php

namespace App\Repositories\Income;

use App\Models\Income;
use App\Repositories\BaseRepository;

class IncomeRepository extends BaseRepository
{
    public function __construct(Income $model)
    {
        parent::__construct($model);
    }
}
