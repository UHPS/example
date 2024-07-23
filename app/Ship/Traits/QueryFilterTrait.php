<?php

namespace App\Ship\Traits;

use App\Ship\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

trait QueryFilterTrait
{
    public function filter(QueryFilter $filters): Builder
    {
        return $filters->apply($this);
    }
}
