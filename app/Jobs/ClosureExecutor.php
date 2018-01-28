<?php

namespace App\Jobs;

use Closure;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClosureExecutor extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $job;
    private $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Closure $job, $parameters = [])
    {
        $this->job = $job;
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->job($this->parameters);
    }
}
