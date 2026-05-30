<?php

namespace Vendor\RequestManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function requestitemable()
    {
        return $this->morphTo();
    }
}
