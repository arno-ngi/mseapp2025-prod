<?php

namespace Vendor\RequestManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approver extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(config('request-management.models.user'), 'user_id');
    }

    public function approvers()
    {
        return $this->morphTo();
    }
}
