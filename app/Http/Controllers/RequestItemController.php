<?php

namespace App\Http\Controllers;

use App\Models\RequestItem;
use Illuminate\Http\Request;

class RequestItemController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required',
            'price' => 'required',
        ]);

        $modeltype = $request->modeltype;
        $modelid = $request->modelid;

        $model = getModelFromType($modeltype, $modelid);

        $model->requestitems()->create(['quantity' => $request->quantity, 'description' => $request->description, 'price' => fixDouble($request->price)]);

        if($modeltype === 'invoicerequest') {
            return redirect(route('rfa.edit', $model).'?tab=requestitems');
        } else {

        }
    }

    public function update(RequestItem $requestItem, Request $request)
    {
        $requestItem->quantity = $request->quantity;
        $requestItem->description = $request->description;
        $requestItem->price = fixDouble($request->price);
        $requestItem->save();

        return back();
    }
}
