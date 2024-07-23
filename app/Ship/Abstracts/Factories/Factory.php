<?php

namespace App\Ship\Abstracts\Factories;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Factory as BaseFactory;


abstract class Factory extends BaseFactory
{
    protected function withFaker(): Generator
    {
        return \Faker\Factory::create('uk_UA');
    }
}
