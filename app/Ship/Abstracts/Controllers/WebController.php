<?php

namespace App\Ship\Abstracts\Controllers;

use App\Ship\Traits\ApiResponses;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


abstract class WebController extends Controller
{
    use ApiResponses, AuthorizesRequests, ValidatesRequests;

    /**
     * The type of this controller. This will be accessible mirrored in the Actions.
     * Giving each Action the ability to modify it's internal business logic based on the UI type that called it.
     */
    public string $ui = 'web';
}
