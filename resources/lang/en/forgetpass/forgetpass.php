<?php
	return
	[
		'forgetpass' 	=> 'Forget Password',
		'identify'		=> 
		[
			'student'	=> 'Student',
			'staff'		=> 'Staff',
			'alumni'	=> 'Alumni'
		],

		'personalInfo'	=> 
		[
			'name'		=> 'Name:',
			'account'	=> 'Account:',
			'ideNumber'	=> 'Identity Card Number:',
			'birthday'	=> 'Birthday:',
		],

		'personalInfoWarn'	=>
		[
			'realName'			=> 'Please enter your real name <br>(If your name has rare words in Mandarin Chinese, please do not enter this word in order to avoid incorrect data comparison)',
			'selectIdentify'	=> '(Please select your identity first)',
			'staffEmail'		=> 'Please enter your email account if you are staff (if you want to modify your portal password, please contact the Personnel Office)',
			'studentSchoolID'	=> 'Please enter your "student ID" if you are a student in NCU now',
			'alumniSchoolID'	=> 'Please enter your "student ID" if you are alumni of NCU',
			'firstUpperCase'	=> 'Please enter the first letter capitalized (If you are a foreigner, please enter your school account)',
			'useSelector'		=> 'Please use the selector to avoid clicking malformed',
		],
		'submit'		=> 'Submit',
		'noYet30Min'	=> 'you can not modify password twice in 30 minutes',
		'mail'	=>
		[
			'mailSent'				=> 'Your mail has been sent',
			'networkOrServerError'	=> 'Network or Server error, please try again',
			'modifyMailFail'		=> ' Modify password Fail',

		],

		'returnWrong'	=>
		[
			'staffEmailWrong'		=> 'Input data incorrect (Please enter your email account if you are staff. If you want to modify your portal password, please contact the Personnel Office)',
			'networkOrServerError' 	=> 'Network or Server error, please try again',
			'inputWrong'			=> 'Input data incorrect',
		],

		'recaptchaFail'		=> 'Non-robotic verification fails, please try again',

		'30MinFail'			=>
		[
			'ifNotReceiveMail' 		=> 'If you find that has yet to receive a verification mail',
			'emailYouTypeIn30Min'	=> '1. It the email you enter in 30 minute: ',
			'pleaseCheckMail'		=> 'Please check the email and resend the mail again if the address is incorrect',
			'checkSpamMail'			=> '2. Please check your junk mail box, it may be mistaken for junk mail',
		],

		'defaultRemind'		=>
		[
			'onceIn30Min' 		=> 'Please note that you can only make one change password within 30 minutes',
			'checkInDetail'		=> 'Please check the personal information you type in detail',
			'typeInputAbove' 	=> 'Please click the following button after you finish the blanks above, the system will send a mail to the computer central',
		],

		'cannotModify'	=> "I can't modify my password ",
		'enterEmail'	=> 'please enter your email',
		'email'			=> 'email:',
		'phone'			=> 'phoneNumber:',
		'phoneOrHome'	=> '(Optional) Please enter the phone number (enter ZIP code with local calls please)',

		'zipCodeSearch' => 'ZIP code checking',
		'sendTheMail'	=> 'send Mail',

		'recaptcha'		=> 'Please finish google recaptcha to confirm that you are not a robot'
	]
?>