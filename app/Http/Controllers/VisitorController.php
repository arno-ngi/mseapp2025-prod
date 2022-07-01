<?php

namespace App\Http\Controllers;

use App\Models\VisitorCheckIn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $VisitorCheckIns = VisitorCheckIn::all();

        return view('visitors.index', compact('VisitorCheckIns'));
    }

    public function docheckout(VisitorCheckIn $VisitorCheckIn)
    {
        $VisitorCheckIn->checkout = Carbon::now();
        $VisitorCheckIn->save();

        activity()
            ->performedOn($VisitorCheckIn)
            ->log('Visitor Registration check out');

        return back();
    }
}
