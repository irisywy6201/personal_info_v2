<?php
return [
	'email' => 'backup e-mail',
	// New backup e-mail.
	'greeting' => 'Dear :user!',
	'textualDescription' => 'In order to provide a complete password recovery procedure to you, please fill your backup e-mail address into the form here. Therefore, if your password is lost in the future, we can send you an e-mail with a link for you to change your password, guaranteeing the safety of your password.',
	'browseAsGuest' => 'In addition, there\'s no problem for you to keep browsing this website as a guest.',
	'endingSentences' => 'We apologize if this brings you any inconvenience, thank you.',
	'inputName' => 'Please input your real name',
	'inputEmail' => 'Please input your backup e-mail address',
	'namePlaceHolder' => 'For example: John Wang',
	'emailPlaceHolder' => 'Example: abcd1234@gmail.com',
	'notCCEmail' => 'Please avoid using the NCU web mail address, for example: "xxx@cc.ncu.edu.tw"',
	'sendFailure' => 'Failed to setup the backup E-mail address',
	'submit' => 'Submit',

	// Verification e-mail sent.
	'emailSet' => '{1} Your backup e-mail address ":email" has been set when registering portal account!|{0} Your backup e-mail address ":email" has been set!',
	'emailSent' => 'Please login to your e-mail account and click on the verification link in the verification mail we sent to you to complete the final step.',
	'notReceiveEmail' => 'If you do not receive the verification mail, please check your spam folder, or you can',
	'resendVarificationEmail' => 'resend verification mail',

	// Verification result.
	'verifySuccess' => 'Successfully verified the backup e-mail address',
	'successMsg' => 'This backup e-mail address has been verified, thank you for your registering.',
	'verifyFailure' => 'Failed to verify backup e-mail address',
	'linkExpired' => 'This link has expired, please apply a new backup e-mail address again.',
	'hashCodeError' => 'Hash code error',
	'systemError' => '此為系統問題，對於造成這樣的結果我們深感抱歉，我們會盡速排除錯誤，還請見諒！',

	// E-mail address has been used.
	'hasBeenUsed' => 'The e-mail address ":email" has been used!',

	// Resend verification e-mail
	'mailSent' => 'Verification mail has been sent',
	'resendVeriEmailFailure' => 'Failed to resend the verification mail',

	// User has benn registered.
	'hasBeenRegistered' => 'Your backup e-mail address ":email" has been verified successfully. It\'s no necessary for you to add a backup e-mail address again.',

	// Edit e-mail
	'yourCurrentEmailIs' => 'Your current backup e-mail address is: :email',
	'inputNewEmail' => 'Please input a new backup e-mail address',

	// Delete e-mail
	'emailDeleteSuccess' => 'Successfully deleted the backup e-mail address',
	'emailDeleteFailure' => 'Failed to delete the backup e-mail address',
	'emailNotExist' => 'This e-mail address does not exist',

	// Helper message
	'helperMessage' => [
		'If you have any problem, please leave a message on',
		'page or mail to ncucc@g.ncu.edu.tw, thank you.'
	]
];
?>