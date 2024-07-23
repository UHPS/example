<?php


namespace App\Ship\Abstracts\DTO;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

abstract class DataTransferObject extends Data
{
    public static function fromRequest(Request $request)
    {
        return self::from($request->validated());
    }
}
