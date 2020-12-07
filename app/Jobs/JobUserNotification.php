<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\UserNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class JobUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $usersNotification;
    public $detailsTransfer;
    public function __construct($usersNotification, $detailsTransfer)
    {        
        $this->usersNotification = $usersNotification;
        $this->detailsTransfer = $detailsTransfer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {                
        $this->usersNotification
                ->notify(new UserNotification
                        ($this->detailsTransfer)
        );
    }
}
