<?php

namespace App\Jobs;

use Carbon\Carbon;
use \Lang;
use \Queue;
use \URL;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Entities\Question;
use App\Entities\User;

class BoardNotifier extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $params;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $lastReplier = null;
        $params = $this->params;

        if ($this->isMessageExists($params['messageID']) && !$this->isMessageSolved($params['messageID']) && !$this->isCheckPointOutOfDate($params['messageID'], $params['replyID'])) {
            $lastReplier = $this->getLastReplierID($params['messageID']);

            if ($lastReplier && User::find($lastReplier)->isStaff()) {
                Question::where('id', $params['messageID'])->update(['status' => Question::STATUS_AUTO_SOLVED]);
            }
            else {
                $this->sendNotifyMailToContactPerson($params['messageID'], $params['days'], $params['receivers']);

                if ($params['daysToCheckAgain']) {
                    $params['days'] = $params['days'] + $params['daysToCheckAgain'];

                    Queue::later(Carbon::now()->addDays($params['daysToCheckAgain']), new BoardNotifier($params));
                }
            }
        }
    }

    /**
     * Check if the message exists or not.
     *
     * @param int $id The ID number of the message.
     * @return Return bool True if message exists, return False
     * otherwise.
     */
    private function isMessageExists($id)
    {
        if (Question::find($id)) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Check if the message is solved or not.
     *
     * @param int $id The ID number of the message.
     * @return bool Return True if the message is solved,
     * return False if the message does not exist or the message
     * is not solved.
     */
    private function isMessageSolved($id)
    {
        if (Question::find($id)->status >= Question::STATUS_SOLVED) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Check if the check point is out of date or not.
     *
     * @param Integer messageID The ID number of the message.
     * @param Integer replyID The ID number of the reply which
     * fires this check point.
     * @return Returns True if the check point is not out of date,
     * returns False otherwise.
     */
    private function isCheckPointOutOfDate($messageID, $replyID)
    {       
        if ($replyID == $this->getLastReplyID($messageID)) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Helper function of sendNotifyMail().
     *
     * @param Integer days How many days the message is not replied
     * by contact person.
     * @param Array receivers The contact persons' e-mail addresses.
     */
    public function sendNotifyMailToContactPerson($messageID, $days, $receivers)
    {
        if ($receivers) {
            $data['receivers'] = $receivers;
            $data['subject'] = Lang::get('email.notifyAdmin.subject.0') . $days . Lang::get('email.notifyAdmin.subject.1');
            $data['mailView'] = 'emails.messageBoard.notifyAdmin';
            $data['mailViewData'] = [
                'days' => $days,
                'link' => URL::to('https://sd.cc.ncu.edu.tw/msg_board/' . $messageID)
            ];

            Queue::push(new SendMail($data));
        }
    }

    /**
     * Retrieve the ID number of the last reply.
     *
     * @param Integer id The ID number of the message.
     * @return Integer Returns the ID number of the last reply,
     * if the message does not exits, return Null.
     */
    private function getLastReplyID($id) {
        return Question::find($id)->replies()
            ->orderBy('created_at', 'desc')
            ->pluck('id');
    }

    /**
     * Retrieve the last replier, and return it as a User object.
     *
     * @param Integer id The ID number of the message.
     * @return User Return the last replier as a User object, if
     * the message does not exist, return Null.
     */
    private function getLastReplierID($id) {
        return $lastReplierID = Question::find($id)->replies()
            ->orderBy('created_at', 'desc')
            ->pluck('user_id');
    }
}
