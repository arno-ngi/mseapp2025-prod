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

        if(isset($request->type)) {
            if($request->type === 'ir')
            {
                return redirect(url('/rfa/'.$request->modelid.'?tab=files'));
            }
            if($request->type === 'er')
            {
                return redirect(url('/expenserequest/'.$request->modelid.'?tab=files'));
            }
        }
        return redirect(url('/users/'.$useruuid.'?tab=files'));
    }
}
