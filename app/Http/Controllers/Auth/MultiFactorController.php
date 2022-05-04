<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserMultifactor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MultiFactorController extends Controller
{
    public function index()
    {
        auth()->user()->generateMFA();

        return view('auth.mfa');
    }

    public function resent()
    {
        auth()->user()->resentMFA();

        return view('auth.mfa');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mfa_code' => 'required',
        ]);

        $code = $request->mfa_code;
        $getHttpChecks = getHttpChecks();

        $multifactor = UserMultifactor::whereUserId(auth()->user()->id)->whereCode($code)->whereUserIp($getHttpChecks['ip'])->whereUserAgent($getHttpChecks['useragent'])->where('code_valid_until', '>', Carbon::now())->whereValidated(false)->orderBy('created_at', 'desc')->first();

        if (!is_null($multifactor)) {
            $multifactor->validated = true;
            $multifactor->save();

            Session::put('user_2fa', auth()->user()->id);

            return to_route('index');
        }

        flash()->error(__('law.wrong_code'));

        return back();
    }

    public function resend_code()
    {

    }
}
