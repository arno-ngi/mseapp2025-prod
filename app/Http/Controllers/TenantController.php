<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::withCount(['users'])->get();

        return view('tenants.index', compact('tenants'));
    }

    public function create()
    {
        return view('tenants.create');
    }

    public function edit(Tenant $tenant)
    {
        return view('tenants.edit', compact('tenant'));
    }

    public function switch(Tenant $tenant)
    {
        $user = auth()->user();
        $user->tenant_id = $tenant->id;
        $user->save();

        flash()->success(__('law.updated_succesfully'));

        return back();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $tenant = new Tenant();
        $tenant->name = $request->name;
        $tenant->mail_info = $request->mail_info;
        $tenant->save();

        return redirect(route('tenants.edit', $tenant));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);

        $tenant->name = $request->name;
        $tenant->mail_info = $request->mail_info;
        $tenant->is_active = $request->has('is_active') ? true : false;

        $tenant->o365_client_id = $request->o365_client_id;
        $tenant->o365_client_secret = $request->o365_client_secret;

        if ($request->hasFile('file1')) {
            $file = $request->file('file1');
            $fileprefix = Str::slug('tenant-' . Str::random(10));
            $savepath = 'tenants/' . $fileprefix . '_' . $file->getClientOriginalName();
            Storage::put('public/' . $savepath, $file->get());
            $tenant->logo = $savepath;
        }

        if ($request->hasFile('file2')) {
            $file = $request->file('file2');
            $fileprefix = Str::slug('tenant-' . Str::random(10));
            $savepath = 'tenants/' . $fileprefix . '_' . $file->getClientOriginalName();
            Storage::put('public/' . $savepath, $file->get());
            $tenant->logo_mail = $savepath;
        }

        $tenant->save();

        flash()->success(__('law.updated_succesfully'));

        return back();
    }
}
