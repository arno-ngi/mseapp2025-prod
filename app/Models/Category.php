<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function invoicerequests()
    {
        return $this->hasMany(InvoiceRequest::class);
    }

    public function categoryusers()
    {
        return $this->hasMany(CategoryUser::class);
    }
}
