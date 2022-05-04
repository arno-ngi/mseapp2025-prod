<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AppSettingController extends Controller
{
    public function index()
    {
        $appSettings = AppSetting::orderBy('setting_key')->get();

        return view('appsettings.index', compact('appSettings'));
    }

    public function edit(AppSetting $appSetting)
    {
        return view('appsettings.edit', compact('appSetting'));
    }

    public function update(AppSetting $appSetting, Request $request)
    {
        if ($request->hasFile('file1')) {
            $file = $request->file('file1');
            $fileprefix = Str::slug('setting-' . Str::random(10));
            $savepath = 'settings/' . $fileprefix . '_' . $file->getClientOriginalName();
            Storage::put('public/' . $savepath, $file->get());
            $appSetting->setting_value = $savepath;
        } else {
            $appSetting->setting_value = $request->setting_value;
        }

        $appSetting->save();

        Cache::flush();

        flash()->success(__('law.updated_succesfully'));

        return redirect(route('appsettings.index'));
    }
}
