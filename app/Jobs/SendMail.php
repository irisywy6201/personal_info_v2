<?php

namespace App\Jobs;

use \Mail;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // the View of the e-mail.
        $mailView = $this->data['mailView'];
        // used by the View of e-mail.
        $mailViewData = array_key_exists('mailViewData', $this->data) ? $this->data['mailViewData'] : [];
        // used for setting up the e-mail to be sent.
        $emailData = [
            'receivers' => $this->data['receivers'],
            'subject' => $this->data['subject']
        ];

        Mail::send($mailView, $mailViewData, function($message) use ($emailData)
        {
            $message->subject($emailData['subject']);

            $receivers = $emailData['receivers'];

            if (is_array($receivers)) {
                for ($i = 0; $i < count($receivers); $i += 1) {
                    $message->to($receivers[$i]);
                }
            }
            else {
                $message->to($receivers);
            }
        });
    }
}
