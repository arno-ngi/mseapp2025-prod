<?php

namespace App\Http\Controllers;

use App\Models\Approver;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        //Auth::login(User::find(9));
        $approvers = Approver::whereUserId(auth()->user()->id)->whereIn('status', [1,2])->get();

        //$invoiceRequests = InvoiceRequest::whereUserId(auth()->user('approvers_id')->tenant->invoicerequests()->get());
        $invoiceRequests = auth()->user()->tenant->invoicerequests()->whereIn('status', [1,2])->get();
        $expenseRequests = auth()->user()->tenant->expenserequests()->whereIn('status', [1,2])->get();


        return view('index', compact('approvers', 'invoiceRequests','expenseRequests'));
    }

    public function myprofile()
    {
        $user = auth()->user();

        return view('myprofile.index', compact('user'));
    }
}


