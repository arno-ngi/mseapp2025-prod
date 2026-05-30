<?php

namespace Vendor\RequestManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extrafiles extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function extrafiles()
    {
        return $this->morphTo();
    }
}
