<?php

namespace App\Ship\Traits;

use Illuminate\Http\Request;

trait OptioanlPagination
{
    protected function optionalPaginate($builder, Request $request)
    {
        return $builder->paginate($builder->count());
    }
}
