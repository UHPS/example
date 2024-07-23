<?php

namespace App\Ship\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;

trait FactoryLocatorTrait
{
    protected static function newFactory(): Factory
    {
        $separator = '\\';
        $containersFactoriesPath = $separator . 'Data' . $separator . 'Factories' . $separator;
        $fullPathSections = explode($separator, static::class);
        $sectionName = $fullPathSections[2];
        $nameSpace = 'App' . $separator . 'Containers' . $separator . $sectionName . $containersFactoriesPath;


        Factory::useNamespace($nameSpace);
        $className = class_basename(static::class);

        return Factory::factoryForModel($className);
    }
}
