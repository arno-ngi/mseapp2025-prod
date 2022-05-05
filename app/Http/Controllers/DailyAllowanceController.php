<?php

namespace App\Http\Controllers;

use App\Models\DailyAllowance;
use Illuminate\Http\Request;

class DailyAllowanceController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'visit_to' => 'required',
        ]);

        $modeltype = $request->modeltype;
        $modelid = $request->modelid;

        $model = getModelFromType($modeltype, $modelid);

        $model->allowances()->create(
            [
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'visit_to' => $request->visit_to,
                'entertainment' => $request->entertainment,
                'tme_inhouse' => $request->tme_inhouse,
            ]);

        if($modeltype === 'invoicerequest') {
            return redirect(route('rfa.edit', $model).'?tab=allowances');
        } else {
            return redirect(route('expenserequest.edit', $model).'?tab=allowances');
        }
    }

    public function update(DailyAllowance $dailyAllowance, Request $request)
    {
        $validated = $request->validate([
            'from_date' => 'required',
            'to_date' => 'required',
            'visit_to' => 'required',
        ]);

        $dailyAllowance->from_date = $request->from_date;
        $dailyAllowance->to_date = $request->to_date;
        $dailyAllowance->visit_to = $request->visit_to;
        $dailyAllowance->entertainment = $request->entertainment;
        $dailyAllowance->tme_inhouse = $request->tme_inhouse;
        $dailyAllowance->save();

        return back();
    }
}
