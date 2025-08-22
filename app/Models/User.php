<?php

namespace App\Models;

use App\Notifications\SendCodeNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Laravel\Sanctum\HasApiTokens;
use phpseclib3\System\SSH\Agent\Identity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\LogOptions;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity;

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });

    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*']);
    }

    protected $fillable = [
        'name',
        'firstname',
        'initials',
        'lang',
        'tariftype',
        'rows_per_table',
        'email',
        'password',
    ];

    protected $dates = [
        'birthdate', 'date_identitycard', 'date_goedgedragenzeden', 'partner_birthdate'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'lastseen' => 'datetime',
    ];

    protected $with = ['tenant'];

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function getFullnameAttribute()
    {
        return $this->firstname . ' ' . $this->name;
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id' );
    }



    public function identity()
    {
        return $this->belongsTo(Identity::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function usermultifactors()
    {
        return $this->belongsTo(UserMultifactor::class);
    }

    public function extrafiles()
    {
        return $this->morphMany(Extrafiles::class, 'extrafiles');
    }

    public function checkMFA()
    {
       $getHttpChecks = getHttpChecks();

        if (!is_null(UserMultifactor::whereUserId($this->id)->whereUserIp($getHttpChecks['ip'])->whereUserAgent($getHttpChecks['useragent'])->where('valid_until', '>', Carbon::now())->whereValidated(true)->first())) {
            Session::put('user_2fa', auth()->user()->id);

            return true;
        }

        return false;
    }

    public function resentMFA()
    {
       $getHttpChecks = getHttpChecks();

       $mfa = UserMultifactor::whereUserId($this->id)->whereUserIp($getHttpChecks['ip'])->whereUserAgent($getHttpChecks['useragent'])->where('valid_until', '>', Carbon::now())->whereValidated(false)->first();

        if (!is_null($mfa)) {
            $this->notify(new SendCodeNotification($mfa->code));
            return true;
        }

        $this->generateMFA();

        return true;
    }

    public function invoicerequests()
    {
        return $this->hasMany(InvoiceRequest::class);
    }

    public function expenserequests()
    {
        return $this->hasMany(ExpenseRequest::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function generateMFA()
    {
        $usermultifactor = new UserMultifactor();

        $getHttpChecks = getHttpChecks();

        if (!is_null(UserMultifactor::whereUserId($this->id)->whereUserIp($getHttpChecks['ip'])->whereUserAgent($getHttpChecks['useragent'])->where('valid_until', '>', Carbon::now())->whereValidated(true)->first())) {
            return true;
        }

        if (is_null(UserMultifactor::whereUserId($this->id)->whereUserIp($getHttpChecks['ip'])->whereUserAgent($getHttpChecks['useragent'])->where('valid_until', '>', Carbon::now())->whereValidated(false)->first())) {
            $code = rand(100000,999999);

            $usermultifactor->user_id = $this->id;
            $usermultifactor->user_ip = $getHttpChecks['ip'];
            $usermultifactor->user_agent = $getHttpChecks['useragent'];
            $usermultifactor->valid_until = Carbon::now()->addDays(14);
            $usermultifactor->code_valid_until = Carbon::now()->addHour();
            $usermultifactor->code = $code;
            $usermultifactor->save();

            $this->notify(new SendCodeNotification($code));

            return false;
        }

    }

}
