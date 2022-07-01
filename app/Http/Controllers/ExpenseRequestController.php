<?php

namespace App\Http\Controllers;

use App\Models\ExpenseRequest;
use App\Models\InvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

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
        $activitylogs = Activity::whereSubjectId($expenseRequest->id)->whereSubjectType(get_class($expenseRequest))->with('causer')->orderBy('id', 'desc')->get();

        return view('expenserequests.edit', compact('expenseRequest', 'activitylogs'));
    }


    public function makeclosed(ExpenseRequest $expenseRequest)
    {
        $expenseRequest->status = 5;
        $expenseRequest->save();

        activity()
            ->performedOn($expenseRequest)
            ->log('Status changed - CLOSED');

        return back();
    }

    public function changestatus(ExpenseRequest $expenseRequest, $status)
    {

        $approver = $expenseRequest->approvers()->where('user_id', '=', auth()->user()->id)->first();
        $approver->status = $status;
        $approver->save();

        $accepted = false;
        $allaccepted = true;
        if ($status != 4) {
            $status = 2;

            foreach ($expenseRequest->approvers()->get() as $approver) {

                if (!is_null($approver) && $approver->status == '3') {
                    $accepted = true;
                } else {
                    $allaccepted = false;
                    $accepted = false;
                }
            }
            if ($allaccepted) {
                $status = 3;
            } else {
                $status = 2;
            }
        } else {
            $status = 4;
        }
        $expenseRequest->status = $status;
        $expenseRequest->save();

        activity()
            ->performedOn($expenseRequest)
            ->log('Status changed');

        return back();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
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
            'supplier' => 'required',
            'total_cost' => 'required',
        ]);

        $expenseRequest->tenant_id = auth()->user()->tenant_id;
        $expenseRequest->category_id = $request->category_id;
        $expenseRequest->invoice_request_id = $request->invoice_request_id;
        $expenseRequest->requester_id = auth()->user()->id;
        $expenseRequest->internal_information = $request->internal_information;
        $expenseRequest->payment_type = $request->payment_type;

        $expenseRequest->requester_id = auth()->user()->id;
        if($expenseRequest->expense_date !== $request->expense_date)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed expense_date from ' . $expenseRequest->expense_date . ' to ' . $request->expense_date);
        }
        $expenseRequest->expense_date = $request->expense_date;

        if($expenseRequest->supplier !== $request->supplier)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed supplier from ' . $expenseRequest->supplier . ' to ' . $request->supplier);
        }
        $expenseRequest->supplier = $request->supplier;

        if($expenseRequest->bankstatement !== $request->bankstatement)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed bankstatement from ' . $expenseRequest->bankstatement . ' to ' . $request->bankstatement);
        }
        $expenseRequest->bankstatement = $request->bankstatement;

        if($expenseRequest->payment_type !== $request->payment_type)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed payment_type from ' . $expenseRequest->payment_type . ' to ' . $request->payment_type);
        }
        $expenseRequest->payment_type = $request->payment_type;

        if($expenseRequest->iban !== $request->iban)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed iban from ' . $expenseRequest->iban . ' to ' . $request->iban);
        }
        $expenseRequest->iban = $request->iban;

        if($expenseRequest->internal_information !== $request->internal_information)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed internal_information from ' . $expenseRequest->internal_information . ' to ' . $request->internal_information);
        }
        $expenseRequest->internal_information = $request->internal_information;
        if($expenseRequest->total_cost !== $request->total_cost)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed total_cost from ' . $expenseRequest->total_cost . ' to ' . $request->total_cost);
        }

        $expenseRequest->total_cost = fixDouble($request->total_cost);
        if($expenseRequest->currency !== $request->currency)
        {
            activity()
                ->performedOn($expenseRequest)
                ->log('Item updated ' . $expenseRequest->slug . ': Changed currency from ' . $expenseRequest->currency . ' to ' . $request->currency);
        }

        $expenseRequest->currency = $request->currency;
        if ($request->user_id != '0') {
            $expenseRequest->user_id = $request->user_id;
        } else {
            $expenseRequest->user_id = null;
        }
        $expenseRequest->save();

        activity()
            ->performedOn($expenseRequest)
            ->log('Item updated ' . $expenseRequest->slug);

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
