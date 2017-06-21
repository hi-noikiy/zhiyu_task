<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailer extends Job implements SelfHandling
{

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        //
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

        Log::info("jinqu");exit;
        Mail::raw('test', function($message){
            $message->subject('tes sb');
            $message->from('mzd_test01@163.com', 'com ww');
            $message->to($this->email, 'omg');
        });
    }
}
