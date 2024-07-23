<?php

namespace App\Ship\Abstracts\Models;

use App\Ship\Traits\DateFormattingTrait;
use App\Ship\Traits\FactoryLocatorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class AuthenticatableModel extends Authenticatable
{
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }
}
