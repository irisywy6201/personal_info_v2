<?php
return [
	'email' => '備用信箱',
	// New backup e-mail.
	'greeting' => '親愛的 :user 用戶您好！',
	'textualDescription' => '為了提供您完善的密碼救援程序，請先於以下表單中輸入您的備用信箱，往後若有密碼遺失的情形出現時，我們會將您的密碼寄送至此備用信箱中，讓您的密碼可以有多一份保障',
	'browseAsGuest' => '另外，您可以以訪客身份繼續瀏覽此網頁',
	'endingSentences' => '若造成您的不便我們深感抱歉，還請見諒，謝謝您的合作！',
	'inputName' => '請輸入真實姓名',
	'inputEmail' => '請輸入備用信箱位置',
	'namePlaceHolder' => '例如：王大明',
	'emailPlaceHolder' => '範例： abcd1234@gmail.com',
	'notCCEmail' => '請勿使用學校學務信箱,例如："xxx@cc.ncu.edu.tw"',
	'sendFailure' => '備用信箱設定失敗',
	'submit' => '送出',

	// Verification e-mail sent.
	'emailSet' => '{1} 您的":email"備用信箱已於新生帳號啟動時設定完成！|{0} 您的":email"備用信箱已經設定完成！',
	'emailSent' => '請至您所設定的備用信箱中收取驗證信，並按下驗證連結以完成最後的驗證步驟',
	'notReceiveEmail' => '若您沒有收到認證信，請檢查您的垃圾信件夾，或者您可以',
	'resendVarificationEmail' => '重寄驗證信',

	// Verification result.
	'verifySuccess' => '信箱驗證成功',
	'successMsg' => '備用信箱已經獲得認證，感謝您的使用',
	'verifyFailure' => '信箱驗證失敗',
	'linkExpired' => '此連結已經過期，請重新申請備用信箱',
	'hashCodeError' => 'Hash code 發生錯誤',
	'systemError' => '此為系統問題，對於造成這樣的結果我們深感抱歉，我們會盡速排除錯誤，還請見諒！',

	// E-mail address has been used.
	'hasBeenUsed' => '備用信箱":email"已經被使用且認證成功！',

	// Resend verification e-mail
	'mailSent' => '認證信已寄出',
	'resendVeriEmailFailure' => '重寄驗證信失敗',

	// User has benn registered.
	'hasBeenRegistered' => '您的:email備用信箱已成功申請且認證，無須再次申請',

	// Edit e-mail
	'yourCurrentEmailIs' => '您當前的備用信箱為： :email',
	'inputNewEmail' => '請輸入新的備用信箱',

	// Delete e-mail
	'emailDeleteSuccess' => '備用信箱刪除成功',
	'emailDeleteFailure' => '備用信箱刪除失敗',
	'emailNotExist' => '此備用信箱已經不存在',

	// Helper message
	'helperMessage' => [
		'若有任何問題，請至',
		'頁面留言，或寄信至 ncucc@g.ncu.edu.tw，讓我們為您服務。謝謝您的合作！'
	]
];
?>