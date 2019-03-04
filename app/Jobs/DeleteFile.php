<?php

namespace App\Jobs;

use \File;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeleteFile extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $paths;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($paths)
    {
        $this->paths = $paths;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        File::delete($this->paths);
    }
}
