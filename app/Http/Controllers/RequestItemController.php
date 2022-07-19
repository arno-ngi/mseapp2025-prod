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
            return redirect(route('expenserequest.edit', $model).'?tab=requestitems');
        }
    }

    public function update(RequestItem $requestItem, Request $request)
    {
        $modeltype = $request->modeltype;
        $modelid = $request->modelid;

        $model = getModelFromType($modeltype, $modelid);

        $requestItem->quantity = $request->quantity;
        $requestItem->description = $request->description;
        $requestItem->price = fixDouble($request->price);
        $requestItem->save();

        if($requestItem->quantity == 0) {
            $requestItem->delete();
        }

        if($modeltype === 'invoicerequest') {
            return redirect(route('rfa.edit', $model).'?tab=requestitems');
        } else {
            return redirect(route('expenserequest.edit', $model).'?tab=requestitems');
        }
    }

    public function delete(RequestItem $requestItem, Request $request)
    {

        $requestItem->delete();

        if(isset($request->type)) {
            if($request->type === 'ir')
            {
                return redirect(url('/rfa/'.$request->modelid.'?tab=requestitems'));
            }
            if($request->type === 'er')
            {
                return redirect(url('/expenserequest/'.$request->modelid.'?tab=requestitems'));
            }
        }
        return back();
    }
}
