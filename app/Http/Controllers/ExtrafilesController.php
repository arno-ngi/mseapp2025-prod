<?php

namespace App\Http\Controllers;

use App\Models\Extrafiles;
use Illuminate\Http\Request;

class ExtrafilesController extends Controller
{
    public function destroy(Request $request)
    {
        $extrafile = Extrafiles::find($request->fileid);
        $useruuid = $request->useruuid;

        $extrafile->delete();

        return redirect(url('/users/'.$useruuid.'?tab=files'));
    }
}
