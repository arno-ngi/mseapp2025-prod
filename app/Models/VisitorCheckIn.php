<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VisitorCheckIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'licenseplate',
        'reason',
        'checkin',
        'checkout',
        'status',
        'nationalnumber',
        'nationality',
        'gender',
        'language',
        'birthdate',
        'birthplace',
        'photoblob',
        'eid_expires', // Add this line
        'country_iso',
        'country',
        'address_zip',
        'address_city',
        'address_street',
        'address_number',
        'address_extra',
        'contact_phone',
        'contact_email'
    ];

    protected $dates = [
        'checkin',
        'checkout',
        'eid_expires' // Add this line
    ];

    // Add this method to check if eID is expired
    public function isEidExpired()
    {
        if (!$this->eid_expires) {
            return false;
        }

        return Carbon::now()->gt($this->eid_expires);
    }
}
