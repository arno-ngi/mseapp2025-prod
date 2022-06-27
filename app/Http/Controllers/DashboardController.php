<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $approvers = Approver::whereUserId(auth()->user()->id)->whereIn('status', [1,2])->get();

        return view('index', compact('approvers'));
    }

    public function myprofile()
    {
        $user = auth()->user();

        return view('myprofile.index', compact('user'));
    }
}
