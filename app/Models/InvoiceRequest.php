<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvoiceRequest extends Model
{
    use HasFactory;

    protected $dates = ['invoice_date'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $length = 3;
            $char = 0;
            $type = 'd';
            $format = "%{$char}{$length}{$type}"; // or "$010d";


            $slug = $model->tenant->shortname . '/';
            $slug .= !is_null($model->category_id) ? $model->category->shortname : 'IR';
            $slug .= '/' . $model->created_at->format('y');

            $count = $model->category->invoicerequests()->where('uniqueid', '<>', null)->count();
            $slug .= '/';
            $sequence = $count + 1;
            $slug .= sprintf($format, $sequence);;

            $model->uniqueid = $slug;
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function getSlugAttribute()
    {
        return $this->uniqueid;
    }

}
