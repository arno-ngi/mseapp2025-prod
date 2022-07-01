<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorCheckIn extends Model
{
    use HasFactory;

    protected $dates = ['checkin', 'checkout'];


}
