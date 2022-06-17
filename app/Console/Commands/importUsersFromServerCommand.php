<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use phpseclib3\Net\SSH2;

class importUsersFromServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            //if(!app()->isLocal()) {
                $ssh = new SSH2('remote.mse-europe.net', '2222', 360);
            //} else {
            //    $ssh = new SSH2('10.32.1.19', '22', 360);
            //}
            $ssh->login('mse.local\ngiadmin', 'bLDH*.5Pp');
        } catch (\ErrorException $e) {
            $this->info('Connection failed - aborting');
            return false;
        }
        $this->info('SSH Login');
        $this->info('-----------------------------------------');
        $command = 'powershell Get-ADUser -Filter * -Properties Samaccountname,Enabled,GivenName,Surname,EmailAddress,HomeDirectory,ScriptPath,LastLogonDate,TelephoneNumber,DisplayName';

        $remoteresult = $ssh->exec($command);

        $remoteresult = explode("\r\n\r\n", $remoteresult);
        $remoteresult = array_diff($remoteresult, array(''));

        foreach ($remoteresult as $arrayitem) {
            if (!Str::startsWith($arrayitem, "Win32")) {
                $domainuserinfo = explode("\r\n", $arrayitem);

                $username = null;
                $givenname = null;
                $surname = null;
                $useremail = null;
                $lastlogin = null;

                foreach ($domainuserinfo as $infoline) {

                    if ($infoline !== "") {
                        $userinfo = explode(" : ", $infoline);

                        if (array_key_exists(1, $userinfo)) {
                            $keyname = trim($userinfo[0]);
                            $value = $userinfo[1];
                            if ($value !== "") {
                                if ($keyname === "Enabled") {
                                    $user_enabled = trim(utf8_encode(($value)));
                                }

                                if ($keyname === "SamAccountName") {
                                    $username = trim(utf8_encode(($value)));
                                }

                                if ($keyname === "EmailAddress") {
                                    $useremail = trim(strtolower(utf8_encode(($value))));
                                }

                                if ($keyname === "LastLogonDate") {
                                    $lastlogin = trim(utf8_encode(($value)));
                                }

                                if ($keyname === "GivenName") {
                                    $givenname = trim(utf8_encode(($value)));
                                }

                                if ($keyname === "Surname") {
                                    $surname = trim(utf8_encode(($value)));
                                }
                            }
                        }
                    }
                }

                if (!is_null($username) && $username !== '' && $username !== 'Guest' && $givenname !== '' && $useremail !== '' && !is_null($useremail) && !Str::contains($username, 'Health')) {
                    $this->info('create user: ' . $useremail);

                    $user = User::whereEmail($useremail)->first();
                    if (is_null($user)) {
                        $user = new User();
                        $user->is_clientvisible = $user_enabled === 'False' ? 0 : 1;
                        $user->tenant_id = 1;

                    }
                    $user->username = $username;
                    $user->firstname = utf8_encode($givenname);
                    $user->name = utf8_encode($surname);
                    //$user->lastseen = $lastlogin === '' ? null : date_create_from_format('d/m/Y H:i:s', str_replace('"', '', $lastlogin));
                    $user->is_onserver = true;
                    $user->is_deleted = false;
                    $user->is_active = $user_enabled === 'False' ? 0 : 1;
                    if($givenname === "" || is_null($givenname)){
                        $user->is_clientvisible = 0;
                    }
                     if($surname === "" || is_null($surname)){
                        $user->is_clientvisible = 0;
                    }
                    $user->email = $useremail;
                    $user->ad_email = $useremail;
                    $user->password = Hash::make('1234');
                    $user->save();
                }
            }

        }

    }
}
