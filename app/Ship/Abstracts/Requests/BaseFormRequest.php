<?php

namespace App\Ship\Abstracts\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class BaseFormRequest extends FormRequest
{
    public function validatedExcept($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = $this->validated();

        Arr::forget($results, $keys);

        return $results;
    }
}
