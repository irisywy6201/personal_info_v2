<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Mail;

class SendLostToMilitaryMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendLostToMilitaryMail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send the mail of the lost thing which is needed to sent to military';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
    	Mail::send('emails.lostandfound.ForwardingList',[],function($message){

            $message->subject('該移轉至軍訓室的遺失物清單');
            $message->to('a0988358096@gmail.com');
        });
    }
}
