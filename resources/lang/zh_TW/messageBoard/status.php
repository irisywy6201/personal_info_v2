<?php

use App\Entities\Question;

return [
	Question::STATUS_NO_STATUS => '所有狀態',
	Question::STATUS_UNSOLVED => '未解決',
	Question::STATUS_SOLVED => '已解決',
	Question::STATUS_AUTO_SOLVED => '自動被系統設為已解決'
];

?>