<?php

namespace Vendor\RequestManagement\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InvoiceRequest extends Model
{
    use HasFactory;

    protected $casts = [
        'invoice_date' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = Str::uuid()->toString();
            }

            if (empty($model->uniqueid) && $model->tenant && $model->category) {
                $length = 3;
                $char = 0;
                $type = 'd';
                $format = "%{$char}{$length}{$type}";

                $slug = 'RFA/' . ($model->tenant->shortname ?? 'UNK') . '/';
                $slug .= ($model->category->shortname ?? 'IR');
                $slug .= '/' . Carbon::now()->format('y');

                $count = self::where('category_id', $model->category_id)
                    ->whereNotNull('uniqueid')
                    ->count();
                $slug .= '/';
                $sequence = $count + 1;
                $slug .= sprintf($format, $sequence);

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
        return $this->belongsTo(config('request-management.models.category'));
    }

    public function tenant()
    {
        return $this->belongsTo(config('request-management.models.tenant'));
    }

    public function requester()
    {
        return $this->belongsTo(config('request-management.models.user'), 'requester_id');
    }

    public function approvers()
    {
        return $this->morphMany(Approver::class, 'approvers');
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
        return $this->belongsTo(config('request-management.models.user'), 'user_id');
    }
}
