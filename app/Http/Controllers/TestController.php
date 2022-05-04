<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use phpseclib3\Net\SSH2;

class TestController extends Controller
{
    public function test1()
    {
        try {
            $ssh = new SSH2('remote.mse-europe.net', '2222', 360);
            $ssh->login('mse.local\ngiadmin', '');
        } catch (\ErrorException $e) {
            $this->info('Connection failed - aborting');
            return false;
        }
        $command = 'powershell';
        $remoteresult = $ssh->exec($command);
        $command = '(new-object directoryservices.directoryentry "","mse.local\ngiadmin", "").psbase.name -ne $null';

        $remoteresult = $ssh->exec($command);
dd($remoteresult);

    }
}
