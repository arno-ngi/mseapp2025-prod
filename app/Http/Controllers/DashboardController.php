<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        //Auth::login(User::find(9));
        $approvers = Approver::whereUserId(auth()->user()->id)->whereIn('status', [1,2])->get();

        return view('index', compact('approvers'));
    }

    public function myprofile()
    {
        $user = auth()->user();

        return view('myprofile.index', compact('user'));
    }
}
