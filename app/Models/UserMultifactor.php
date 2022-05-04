<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMultifactor extends Model
{
    use HasFactory;

    protected $dates = ['code_valid_until', 'valid_until'];
}
