<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceRequestController extends Controller
{
    public function index()
    {
        $invoiceRequests = auth()->user()->tenant->invoicerequests()->get();

        return view('invoicerequests.index', compact('invoiceRequests'));
    }

    public function create()
    {
        return view('invoicerequests.create');
    }
}
