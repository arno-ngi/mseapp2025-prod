<?php

namespace App\Http\Controllers;

use App\Models\VisitorCheckIn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EidController extends Controller
{
    public function index()
    {
        $VisitorCheckIns = VisitorCheckIn::orderBy('created_at', 'desc')->whereNull('checkout')->get();
        return view('eid.index', compact('VisitorCheckIns'));
    }

    public function checkout(VisitorCheckIn $VisitorCheckIn)
    {

        $VisitorCheckIn->checkout = Carbon::now();
        $VisitorCheckIn->save();

        return redirect(route('eid.index'));

    }

    public function show()
    {
        $openid = new \App\Models\LightOpenID(route('eid.show'));
        if ($openid->mode) {
            //session_start();
            $_SESSION["photo"] = $openid->getAttributes()["eid/photo"];
            $attributeseid = $openid->getAttributes();
            $VisitorCheckIn = VisitorCheckIn::where('nationalnumber', $attributeseid['eid/rrn'])->whereNull('checkout')->first();

            $parts = explode(' ', $attributeseid['contact/postalAddress/home']);
            $last = array_pop($parts);
            $parts = array(implode(' ', $parts), $last);
            $street = $parts[0];
            $streetnumber = $last;

            if (Str::startsWith($last, '/')) {
                $parts2 = explode(' ', $street);
                $last2 = array_pop($parts2);
                $parts2 = array(implode(' ', $parts2), $last2);
                $street = $parts2[0];
                $streetnumber = $last2 . $streetnumber;
            }

            return view('eid.create', compact('street', 'streetnumber', 'attributeseid', 'VisitorCheckIn'));

        } else {
            $openid->identity = 'https://www.e-contract.be/eid-idp/endpoints/openid/ident';
            $openid->required = array('namePerson/first', 'namePerson/last',
                'namePerson', 'person/gender', 'contact/postalCode/home',
                'contact/postalAddress/home', 'contact/city/home', 'eid/nationality',
                'eid/pob', 'birthDate', 'eid/rrn', 'eid/card-number', 'eid/card-validity/begin',
                'eid/card-validity/end', 'eid/photo');
            $openid->lang = 'nl';
            return redirect($openid->authUrl());
        }
    }

    public function store(Request $request)
    {
        $VisitorCheckIn = new VisitorCheckIn();
        $VisitorCheckIn->checkin = Carbon::now();
        $VisitorCheckIn->reason = $request->reason;
        $VisitorCheckIn->firstname = $request->firstname;
        $VisitorCheckIn->lastname = $request->lastname;
        $VisitorCheckIn->licenseplate = $request->licenseplate;
        $VisitorCheckIn->nationalnumber = $request->nationalnumber;
        $VisitorCheckIn->nationality = $request->nationality;
        $VisitorCheckIn->gender = $request->gender;
        $VisitorCheckIn->birthdate = $request->birthdate;
        $VisitorCheckIn->birthplace = $request->birthplace;
        $VisitorCheckIn->photoblob = $request->photoblob;
        $VisitorCheckIn->country_iso = 'BE';
        $VisitorCheckIn->address_street = $request->address_street;
        $VisitorCheckIn->address_number = $request->address_number;
        $VisitorCheckIn->address_zip = $request->address_zip;
        $VisitorCheckIn->address_city = $request->address_city;
        if($request->has('contact_phone') && $request->contact_phone !== '')
        {
            $VisitorCheckIn->contact_phone = $request->contact_phone;
        }
        if($request->has('contact_email') && $request->contact_email !== '')
        {
            $VisitorCheckIn->contact_email = $request->contact_email;
        }
        if($request->has('licenseplate') && $request->licenseplate !== '')
        {
            $VisitorCheckIn->licenseplate = $request->licenseplate;
        }
        if($request->has('reason') && $request->reason !== '')
        {
            $VisitorCheckIn->reason = $request->reason;
        }
        $VisitorCheckIn->save();

        return redirect(route('eid.index'));
    }
}
