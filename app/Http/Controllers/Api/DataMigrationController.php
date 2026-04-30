<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ExpenseRequest;
use App\Models\InvoiceRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class DataMigrationController extends Controller
{
    public function export(Request $request)
    {
        // Simple token check
        if ($request->header('X-Migration-Token') !== config('app.migration_token', 'migration-secret-token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = [
            'tenants' => Tenant::all(),
            'users' => User::with('roles')->get(),
            'categories' => Category::all(),
            'invoice_requests' => InvoiceRequest::with(['requestitems', 'extrafiles', 'allowances'])->get(),
            'expense_requests' => ExpenseRequest::with(['requestitems', 'extrafiles', 'allowances'])->get(),
        ];

        return response()->json($data);
    }
}
