<?php

namespace App\Http\Controllers;

use App\Models\InvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceRequestController extends Controller
{
    public function index()
    {
        $invoiceRequests = auth()->user()->invoicerequests()->get();

        return view('invoicerequests.index', compact('invoiceRequests'));
    }

    public function create()
    {
        return view('invoicerequests.create');
    }

    public function edit(InvoiceRequest $invoiceRequest)
    {
        $activitylogs = Activity::whereSubjectId($invoiceRequest->id)->whereSubjectType(get_class($invoiceRequest))->with('causer')->orderBy('id', 'desc')->get();

        return view('invoicerequests.edit', compact('invoiceRequest', 'activitylogs'));
    }

    public function makeclosed(InvoiceRequest $invoiceRequest)
    {
        $invoiceRequest->status = 5;
        $invoiceRequest->save();

        activity()
            ->performedOn($invoiceRequest)
            ->log('Status changed - CLOSED');

        return back();
    }

    public function changestatus(InvoiceRequest $invoiceRequest, $status)
    {
        $approver = $invoiceRequest->approvers()->where('user_id', '=', auth()->user()->id)->first();
        $approver->status = $status;
        $approver->save();

        $accepted = false;
        $allaccepted = true;
        if ($status != 4) {
            $status = 2;

            foreach ($invoiceRequest->approvers()->get() as $approver) {

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
        $invoiceRequest->status = $status;
        $invoiceRequest->save();

        activity()
            ->performedOn($invoiceRequest)
            ->log('Status changed');

        return back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier' => 'required',
            'total_invoice_amount' => 'required',
        ]);

        $invoiceRequest = new InvoiceRequest();
        $invoiceRequest->tenant_id = auth()->user()->tenant_id;
        $invoiceRequest->user_id = auth()->user()->tenant_id;


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

        if($request->final_amount != $request->total_invoice_amount) {
            $validated = $request->validate([
                'supplier' => 'required',
                'total_invoice_amount' => 'required',
                'final_amount_reason' => 'required',
            ]);
        } else {
            $validated = $request->validate([
                'supplier' => 'required',
                'total_invoice_amount' => 'required',
            ]);
        }
        $invoiceRequest->category_id = $request->category_id;
        $invoiceRequest->invoice_date = $request->invoice_date;
        if ($invoiceRequest->supplier !== $request->supplier) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed supplier from ' . $invoiceRequest->supplier . ' to ' . $request->supplier);
        }
        $invoiceRequest->supplier = $request->supplier;

        if ($invoiceRequest->internal_information != $request->internal_information) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed internal_information from ' . $invoiceRequest->internal_information . ' to ' . $request->internal_information);
        }
        $invoiceRequest->internal_information = $request->internal_information;

        if ($invoiceRequest->extra_info !== $request->extra_info) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed extra_info from ' . $invoiceRequest->extra_info . ' to ' . $request->extra_info);
        }
        $invoiceRequest->extra_info = $request->extra_info;

        if ($invoiceRequest->environment_assesment !== $request->environment_assesment) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed environment_assesment from ' . $invoiceRequest->environment_assesment . ' to ' . $request->environment_assesment);
        }
        $invoiceRequest->environment_assesment = $request->environment_assesment;

        if ($invoiceRequest->safety_assesment !== $request->safety_assesment) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed safety_assesment from ' . $invoiceRequest->safety_assesment . ' to ' . $request->safety_assesment);
        }
        $invoiceRequest->safety_assesment = $request->safety_assesment;

        if ($invoiceRequest->total_invoice_amount !== $request->total_invoice_amount) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed total_invoice_amount from ' . $invoiceRequest->total_invoice_amount . ' to ' . $request->total_invoice_amount);
        }
        $invoiceRequest->total_invoice_amount = fixDouble($request->total_invoice_amount);

        if ($invoiceRequest->currency !== $request->currency) {
            activity()
                ->performedOn($invoiceRequest)
                ->log('Item updated ' . $invoiceRequest->slug . ': Changed currency from ' . $invoiceRequest->currency . ' to ' . $request->currency);
        }
        $invoiceRequest->currency = $request->currency;
        $invoiceRequest->safety_description = $request->safety_description;
        $invoiceRequest->final_amount = $request->final_amount;
        $invoiceRequest->final_amount_reason = $request->final_amount_reason;
        $invoiceRequest->save();

        activity()
            ->performedOn($invoiceRequest)
            ->log('Item updated ' . $invoiceRequest->slug);

        return back();
    }

    public function makepending(InvoiceRequest $invoiceRequest)
    {
        $invoiceRequest->status = 2;
        $invoiceRequest->save();

        activity()
            ->performedOn($invoiceRequest)
            ->log('Status changed - PENDING');

        return back();
    }

    public function makerejected(InvoiceRequest $invoiceRequest)
    {
        $invoiceRequest->status = 4;
        $invoiceRequest->save();

        activity()
            ->performedOn($invoiceRequest)
            ->log('Status changed - REJECTED');

        return back();
    }

    public function store_files(InvoiceRequest $invoiceRequest, Request $request)
    {
            $file = $request->file('rfafile');
            $fileprefix = Str::slug('upload-' . Str::random(10));
            $savepath = 'uploads/' . $fileprefix . '_' . $file->getClientOriginalName();
            $originalname = $file->getClientOriginalName();
            Storage::put('public/' . $savepath, $file->get());
        if ($request->is_invoice === 'yes') {
            $invoiceRequest->extrafiles()->create(['filepath' => $savepath, 'filename' => $originalname, 'is_invoice' => true]);
        } else {
            $invoiceRequest->extrafiles()->create(['filepath' => $savepath, 'filename' => $originalname]);
        }

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function pdf(InvoiceRequest $invoiceRequest)
    {


        $pdf = Pdf::loadView('invoicerequests.pdf', compact('invoiceRequest'));

        return $pdf->download('invoicerequest.pdf');
    }
}
