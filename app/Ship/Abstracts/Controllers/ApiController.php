<?php

namespace App\Ship\Abstracts\Controllers;

use App\Ship\Traits\ApiResponses;
use App\Ship\Traits\OptioanlPagination;

abstract class ApiController extends Controller
{
    use ApiResponses, OptioanlPagination;

    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'api';

    public function resolvePaginate($request, $model, $pages = null)
    {
        if (!$pages) {
            $pages = config('database.pagination');
        }

        if ($request->has('page')) {
            return $model->paginate($pages);
        }

        return $model->paginate($model->count());
    }
}
