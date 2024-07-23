<?php

namespace App\Ship\Abstracts\Models;


use App\Ship\Traits\FactoryLocatorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as LaravelEloquentModel;

abstract class Model extends LaravelEloquentModel
{
    protected static $patchable = [];

    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    public function getNextAttribute()
    {
        return $this->where('id', '>', $this->id)->min('id');
    }

    public function getPreviousAttribute()
    {
        return $this->where('id', '<', $this->id)->max('id');
    }

    public function hasAttribute($attr)
    {
        return in_array($attr, $this->fillable);
    }

    public static function getPatchableFields()
    {
        return static::$patchable;
    }
}
