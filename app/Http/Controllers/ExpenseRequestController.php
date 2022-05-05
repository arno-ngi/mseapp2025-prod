<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\InvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExpenseRequestController extends Controller
{
    public function index()
    {
        $expenseRequests = auth()->user()->tenant->expenserequests()->get();

        return view('expenserequests.index', compact('expenseRequests'));
    }

    public function create()
    {
        return view('expenserequests.create');
    }

    public function edit(ExpenseRequest $expenseRequest)
    {
        return view('expenserequests.edit', compact('expenseRequest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_date' => 'required',
            'supplier' => 'required',
            'total_cost' => 'required',
        ]);

        $expenseRequest = new ExpenseRequest();
        $expenseRequest->tenant_id = auth()->user()->tenant_id;
        $expenseRequest->category_id = $request->category_id;
        $expenseRequest->invoice_request_id = $request->invoice_request_id;
        $expenseRequest->requester_id = auth()->user()->id;
        $expenseRequest->expense_date = $request->expense_date;
        $expenseRequest->supplier = $request->supplier;
        $expenseRequest->internal_information = $request->internal_information;
        $expenseRequest->iban = $request->iban;
        $expenseRequest->bankstatement = $request->bankstatement;
        $expenseRequest->payment_type = $request->payment_type;
        $expenseRequest->total_cost = fixDouble($request->total_cost);
        $expenseRequest->currency = $request->currency;
        if ($request->user_id != '0') {
            $expenseRequest->user_id = $request->user_id;
        } else {
            $expenseRequest->user_id = null;
        }
        $expenseRequest->save();

        foreach ($expenseRequest->category->categoryusers as $user) {
            $expenseRequest->approvers()->create(['user_id' => $user->user_id]);
        }

        if (!is_null($request->invoice_request_id)) {
            $invoiceRequest = InvoiceRequest::find($request->invoice_request_id);
            foreach ($invoiceRequest->requestitems as $requestitem) {
                $expenseRequest->requestitems()->create(['quantity' => $requestitem->quantity, 'description' => $requestitem->description, 'price' => $requestitem->price]);
            }
        }

        return redirect(route('expenserequest.edit', $expenseRequest));
    }

    public function update(ExpenseRequest $expenseRequest, Request $request)
    {
        $validated = $request->validate([
            'expense_date' => 'required',
            'supplier' => 'required',
            'total_cost' => 'required',
        ]);

        $expenseRequest->tenant_id = auth()->user()->tenant_id;
        $expenseRequest->category_id = $request->category_id;
        $expenseRequest->invoice_request_id = $request->invoice_request_id;
        $expenseRequest->requester_id = auth()->user()->id;
        $expenseRequest->expense_date = $request->expense_date;
        $expenseRequest->supplier = $request->supplier;
        $expenseRequest->internal_information = $request->internal_information;
        $expenseRequest->iban = $request->iban;
        $expenseRequest->bankstatement = $request->bankstatement;
        $expenseRequest->payment_type = $request->payment_type;
        $expenseRequest->total_cost = fixDouble($request->total_cost);
        $expenseRequest->currency = $request->currency;
        if ($request->user_id != '0') {
            $expenseRequest->user_id = $request->user_id;
        } else {
            $expenseRequest->user_id = null;
        }
        $expenseRequest->save();

        return back();
    }

    public function store_files(ExpenseRequest $expenseRequest, Request $request)
    {
        $file = $request->file('rfafile');
        $fileprefix = Str::slug('upload-' . Str::random(10));
        $savepath = 'uploads/' . $fileprefix . '_' . $file->getClientOriginalName();
        $originalname = $file->getClientOriginalName();
        Storage::put('public/' . $savepath, $file->get());
        $expenseRequest->extrafiles()->create(['filepath' => $savepath, 'filename' => $originalname]);

        return response()->json([
            'status' => 'ok'
        ]);
    }
}
