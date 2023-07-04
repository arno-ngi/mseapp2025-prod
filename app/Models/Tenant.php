<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Tenant extends Model
{
    use HasFactory, HasSlug;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->preventOverwrite();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'tenants_users','tenants_id', 'users_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function barcodes()
    {
        return $this->hasMany(Barcode::class);
    }

    public function invoicerequests()
    {
        return $this->hasMany(InvoiceRequest::class);
    }

    public function expenserequests()
    {
        return $this->hasMany(ExpenseRequest::class);
    }

}
