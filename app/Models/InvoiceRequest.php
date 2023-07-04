<?php

namespace App\Models;

use Carbon\Carbon;
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
            $model->uuid = Str::uuid()->toString();

            $length = 3;
            $char = 0;
            $type = 'd';
            $format = "%{$char}{$length}{$type}"; // or "$010d";


            $slug = 'RFA/' . $model->tenant->shortname . '/';
            $slug .= !is_null($model->category_id) ? $model->category->shortname : 'IR';
            $slug .= '/' . Carbon::now()->format('y');

            $count = $model->category->invoicerequests()->where('uniqueid', '<>', null)->count();
            $slug .= '/';
            $sequence = $count + 1;
            $slug .= sprintf($format, $sequence);;

            $model->uniqueid = $slug;
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function approvers()
    {
        return $this->morphMany(Approver::class, 'approvers');
    }

    public function extrafiles()
    {
        return $this->morphMany(Extrafiles::class, 'extrafiles');
    }

    public function allowances()
    {
        return $this->hasMany(DailyAllowance::class);
    }

    public function requestitems()
    {
        return $this->morphMany(RequestItem::class, 'requestitemable');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
