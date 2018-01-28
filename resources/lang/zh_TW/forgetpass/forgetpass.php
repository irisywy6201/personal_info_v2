<?php
	return
	[
		'forgetpass' 	=> '忘記密碼',
		'identify'		=> 
		[
			'student'	=> '學生',
			'staff'		=> '教職員',
			'alumni'	=> '校友'
		],

		'personalInfo'	=> 
		[
			'name'		=> '姓名:',
			'account'	=> '帳號:',
			'ideNumber'	=> '身分證字號:',
			'birthday'	=> '出生年月日:',
		],

		'personalInfoWarn'	=>
		[
			'realName'			=> '請輸入真實姓名 (若您的名字中有罕見字(造字) 請勿輸入此字以免比對資料錯誤)',
			'selectIdentify'	=> '(請先選擇身分)',
			'staffEmail'		=> '教職員請輸入 email 帳號 (若要修改 portal 密碼請洽人事室)',
			'studentSchoolID'	=> '在學學生請輸入"學號"',
			'alumniSchoolID'	=> '畢業校友請輸入"學號"',
			'firstUpperCase'	=> '第一個英文字母請輸入大寫 (若您非中華民國國籍者，請輸入您的學校帳號)',
			'useSelector'		=> '請利用選擇器點選以免格式錯誤',
		],
		'submit'		=> '送出',
		'noYet30Min'	=> '距離上次更改密碼尚未超過 30 分鐘',
		'mail'	=>
		[
			'mailSent'				=> '您的信件已經寄出',
			'networkOrServerError'	=> '網路或是伺服器錯誤 請再試一次',
			'modifyMailFail'		=> ' 修改密碼失敗',

		],

		'returnWrong'	=>
		[
			'staffEmailWrong'		=> '輸入資料錯誤 (若為教職員請勿輸入 portal 帳號 本系統僅支援 email 帳號之密碼修改)',
			'networkOrServerError' 	=> '網路或是伺服器錯誤 請再試一次',
			'inputWrong'			=> '輸入資料錯誤',
		],

		'recaptchaFail'		=> '非機器人驗證失敗 請您再試一次',

		'30MinFail'			=>
		[
			'ifNotReceiveMail' 		=> '若您發現遲遲沒有收到驗證信件',
			'emailYouTypeIn30Min'	=> '1. 這是您在這30分鐘內填寫的信箱: ',
			'pleaseCheckMail'		=> '請確認是否正確，若有錯誤請在30分鐘之後重新填寫',
			'checkSpamMail'			=> '2. 請檢查您的垃圾信件匣，可能被誤判為垃圾信件',
		],

		'defaultRemind'		=>
		[
			'onceIn30Min' 		=> '請注意，您在 30 分鐘之內只能做一次更改密碼',
			'checkInDetail'		=> '請務必詳細確認您輸入的個人資料',
			'typeInputAbove' 	=> '請將上方空格填寫完畢之後點選下列按鈕，系統將會寄信通知計算機中心處理',
		],

		'cannotModify'	=> '我無法更改密碼',
		'enterEmail'	=> '請輸入email',
		'email'			=> '信箱:',
		'phone'			=> '電話:',
		'phoneOrHome'	=> '(選填)請輸入電話號碼，若為市話請輸入區碼',

		'zipCodeSearch' => '區碼查詢',
		'sendTheMail'	=> '寄出信件',

		'recaptcha'		=> '請完成非機器人驗證動作'
	]
?>