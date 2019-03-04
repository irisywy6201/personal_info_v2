<?php

use App\Entities\Question;

return [
	Question::STATUS_NO_STATUS => 'All statuses',
	Question::STATUS_UNSOLVED => 'Unsolved',
	Question::STATUS_SOLVED => 'Solved',
	Question::STATUS_AUTO_SOLVED => 'Automatically set to solved by system'
];

?>