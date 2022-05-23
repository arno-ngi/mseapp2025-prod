<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class BarcodeController extends Controller
{
    public function index()
    {
        $barcodes = auth()->user()->tenant->barcodes()->get();

        return view('barcodes.index', compact('barcodes'));
    }

    public function edit(Barcode $barcode)
    {

        return view('barcodes.edit', compact('barcode'));
    }

    public function pdf(Barcode $barcode)
    {
        $data = array('barcode' => $barcode);
        $pdf = PDF::loadView('barcodes.pdf', $data);

        return $pdf->download('barcodes_'.Str::slug($barcode->name).'.pdf');
    }

    public function create()
    {
        return view('barcodes.create');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $barcode = new Barcode();
        $barcode->tenant_id = auth()->user()->tenant_id;
        $barcode->creator_id = auth()->user()->id;
        $barcode->name = $request->name;
        $barcode->startnumber = $request->startnumber;
        $barcode->quantity = $request->quantity;
        $barcode->save();

        return to_route('barcodes.index');

    }
    public function update(Barcode $barcode, Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $barcode->name = $request->name;
        $barcode->startnumber = $request->startnumber;
        $barcode->quantity = $request->quantity;
        $barcode->save();

        return back();
    }
}
