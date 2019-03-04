<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Entities\DynamicLink;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class MakeDynamicLinkExpired extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $dynamicLinkId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->dynamicLinkId = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DynamicLink::where('id', $this->dynamicLinkId)->delete();
    }
}
