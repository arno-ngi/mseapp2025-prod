<?php

namespace App\Http\Controllers;

use App\Models\User;

class ColorController extends Controller
{
    public function switch()
    {
        $currentcolor = auth()->user()->color_mode;

        $user = User::find(auth()->user()->id);
        $user->color_mode = $currentcolor === 'light' ? 'dark' : 'light';
        $user->save();

        return back();
    }
}
