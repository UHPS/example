<?php

namespace App\Ship\Traits;

use Carbon\Carbon;

trait DateFormattingTrait
{
    public function getCreatedAtAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return $this->formatDate($value);
    }

    public function getPublishedAtAttribute($value)
    {
        return $this->formatDate($value);
    }

    protected function formatDate($value)
    {
        return Carbon::parse($value)->format('d-m-Y H:i:s');
    }
}
