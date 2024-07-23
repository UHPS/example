<?php

namespace App\Ship\Abstracts\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Ship\Traits\FactoryLocatorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class UserModel extends Authenticatable implements JWTSubject
{
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function getPatchableFields()
    {
        return static::$patchable;
    }
}
