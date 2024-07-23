<?php

namespace App\Containers\Sms\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sms extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'phone',
        'message',
        'status',
        'provider',
        'provider_id',
        'sent_at',
    ];
}
