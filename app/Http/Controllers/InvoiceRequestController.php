<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRequest;
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

    public function edit(InvoiceRequest $invoiceRequest)
    {
        return view('invoicerequests.edit', compact('invoiceRequest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_date' => 'required',
            'supplier' => 'required',
            'total_invoice_amount' => 'required',
        ]);

        $invoiceRequest = new InvoiceRequest();
        $invoiceRequest->tenant_id = auth()->user()->tenant_id;
        $invoiceRequest->category_id = $request->category_id;
        $invoiceRequest->requester_id = auth()->user()->id;
        $invoiceRequest->invoice_date = $request->invoice_date;
        $invoiceRequest->supplier = $request->supplier;
        $invoiceRequest->internal_information = $request->internal_information;
        $invoiceRequest->extra_info = $request->extra_info;
        $invoiceRequest->environment_assesment = $request->environment_assesment;
        $invoiceRequest->safety_assesment = $request->safety_assesment;
        $invoiceRequest->total_invoice_amount = fixDouble($request->total_invoice_amount);
        $invoiceRequest->currency = $request->currency;
        $invoiceRequest->save();

        foreach ($invoiceRequest->category->categoryusers as $user) {
            $invoiceRequest->approvers()->create(['user_id' => $user->user_id]);
        }

        return to_route('rfa.edit', $invoiceRequest);
    }

    public function update(InvoiceRequest $invoiceRequest, Request $request)
    {
        $validated = $request->validate([
            'invoice_date' => 'required',
            'supplier' => 'required',
            'total_invoice_amount' => 'required',
        ]);

        $invoiceRequest->category_id = $request->category_id;
        $invoiceRequest->invoice_date = $request->invoice_date;
        $invoiceRequest->supplier = $request->supplier;
        $invoiceRequest->internal_information = $request->internal_information;
        $invoiceRequest->extra_info = $request->extra_info;
        $invoiceRequest->environment_assesment = $request->environment_assesment;
        $invoiceRequest->safety_assesment = $request->safety_assesment;
        $invoiceRequest->total_invoice_amount = fixDouble($request->total_invoice_amount);
        $invoiceRequest->currency = $request->currency;
        $invoiceRequest->save();

        return back();
    }
}
