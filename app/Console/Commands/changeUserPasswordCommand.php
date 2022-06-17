<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use phpseclib3\Net\SSH2;

class changeUserPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ssh:changepass {username} {password}';

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
        $username = $this->argument('username');
        $newpassword = $this->argument('password');

        try {
            $ssh = new SSH2('remote.mse-europe.net', '2222', 360);
            $ssh->login('mse.local\ngiadmin', 'bLDH*.5Pp');
        } catch (\ErrorException $e) {
            $this->info('Connection failed - aborting');
            return false;
        }
        $this->info('SSH Login');
        $this->info('-----------------------------------------');
        $command = 'powershell Set-ADAccountPassword -Identity '.$username.' -Reset -NewPassword (ConvertTo-SecureString -AsPlainText "'.$newpassword.'" -Force)';

        $remoteresult = $ssh->exec($command);

        return 0;
    }
}
