<?php

namespace Vendor\RequestManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyAllowance extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'from_date' => 'datetime',
        'to_date' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            $model->calculateTotals();
        });

        self::updating(function ($model) {
            $model->calculateTotalsNoSave();
        });

    }

    public function user()
    {
        return $this->belongsTo(config('request-management.models.user'), 'user_id');
    }

    public function invoicerequest()
    {
        return $this->belongsTo(InvoiceRequest::class);
    }

    public function calculateTotals()
    {
        $this->calculateTotalsNoSave();

        $this->save();
    }

    public function calculateTotalsNoSave()
    {
        $totalallowance = 0;
        $allowanceperday = 60.00;
        $tmefee = 10.00;
        $entertainmentfee = 22.50;

        $start = $this->from_date;
        $end = $this->to_date;

        if (!$start || !$end) return;

        $days = $start->diffInDays($end) + 1;
        $totaldays = $days;

        if ($start->format('H') > 13) {
            $this->leave_after_noon = true;
            $days = $days - 0.5;
        } else {
            $this->leave_after_noon = false;
        }

        if ($end->format('H') < 14) {
            $this->arrive_before_noon = true;
            $days = $days - 0.5;
        } else {
            $this->arrive_before_noon = false;
        }

        $entertainmentminus = 0;

        if($this->tme_inhouse)
        {
            $tme =  $tmefee * $days;
            $this->days = $totaldays;
            $allowanceperday = $tmefee;
            $this->allowance_per_day = $tmefee;
            $totalallowance = $allowanceperday * $totaldays;
            $total = $totalallowance;

        } else {
            $this->days = $days;
            $this->allowance_per_day = $allowanceperday;
            if (!is_null($this->entertainment)) {
                $entertainmentminus = $this->entertainment * $entertainmentfee;
            }
            $totalallowance = $allowanceperday * $days;

            $total = $totalallowance - $entertainmentminus;

        }

        $this->allowance_total = $total;
    }
}
