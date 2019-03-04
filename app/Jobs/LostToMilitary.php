<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\lostandfound;

class LostToMilitary extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $thing;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        //
        $this->thing = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //change isMilitary column to true
        lostandfound::find($this->thing)->where('status',0)->update(array('ForwardStatus' => 'Forwarding'));
    }
}
