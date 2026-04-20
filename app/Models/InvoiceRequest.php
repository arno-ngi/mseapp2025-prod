<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\SequenceService;

class InvoiceRequest extends Model
{
    use HasFactory;

    protected $dates = ['invoice_date'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();

            if (is_null($model->uniqueid)) {
                $length = 3;
                $char = 0;
                $type = 'd';
                $format = "%{$char}{$length}{$type}";

                $date = $model->invoice_date ? Carbon::parse($model->invoice_date) : Carbon::now();
                $year = $date->format('y');
                $fullYear = $date->format('Y');

                $categoryShortname = !is_null($model->category_id) ? $model->category->shortname : 'IR';

                $slug = 'RFA/' . $model->tenant->shortname . '/';
                $slug .= $categoryShortname;
                $slug .= '/' . $year;

                $sequenceService = app(SequenceService::class);
                $sequence = $sequenceService->getNextValue(
                    $model->tenant_id,
                    'RFA',
                    $model->category_id,
                    (int)$fullYear
                );

                $slug .= '/' . sprintf($format, $sequence);
                $model->uniqueid = $slug;
            }
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
