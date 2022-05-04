<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    use HasFactory;

    protected $fillable = ['setting_key', 'setting_value', 'setting_type'];

    public static function boot()
    {
        parent::boot();

        self::updated(function ($model) {
            Cache::flush();
        });

    }
}
