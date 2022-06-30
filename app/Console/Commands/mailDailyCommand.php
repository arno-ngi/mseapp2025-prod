<?php

namespace App\Console\Commands;

use App\Models\Approver;
use App\Notifications\dailyNotification;
use Illuminate\Console\Command;

class mailDailyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:daily';

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
        $alreadysent = [];
        foreach(Approver::whereStatus(1)->get() as $approver) {
            if(!in_array($approver->user_id, $alreadysent))
                {
                    $approver->user->notify(new dailyNotification());
                    $this->info('mailing: ' . $approver->user->email);
                    array_push($alreadysent, $approver->user_id);
                }
        }
    }
}
