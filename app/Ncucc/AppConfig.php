<?php

namespace App\Ncucc;

class AppConfig {
	// for NcuSD email
	//const SD_EMAIL = 'ncucc@g.ncu.edu.tw';
	const SD_EMAIL = 'a0988358096@gmail.com';

	const SD_ADMIN = 'center18';

	// for NetID
	const netidHostDomain = '140.115.197.247';
	const netidPrefix = 'https://portal.ncu.edu.tw/user/';

	const appName = 'ISMS';

	const ROLE_USER = 1;
	const ROLE_FACULTY = 2;
	const ROLE_STUDENT = 4;
	const ROLE_ALUMNI = 8;
	const ROLE_SUSPENSION = 16;
	const ROLE_ANY_STUDENT = 32;
	const ROLE_FACEBOOK = 64;
	const ROLE_SYSUSER = 128;
	const ROLE_ADMIN = 1024;

	/* the limited IP */
	public static $matchIP = array (
		'140.115.54.158','140.115.11.1','140.115.11.2','140.115.11.3','140.115.11.4'
	);

	public static $netidAllowedRoles = array (
		'ROLE_STUDENT', 'ROLE_FACULTY', 'ROLE_ALUMNI', 'ROLE_FACEBOOK',
		'ROLE_USER'
	);

	public static $roleMap = array (
		'ROLE_USER' => AppConfig::ROLE_USER,
		'ROLE_FACULTY' => AppConfig::ROLE_FACULTY,
		'ROLE_STUDENT' => AppConfig::ROLE_STUDENT,
		'ROLE_ALUMNI' => AppConfig::ROLE_ALUMNI,
		'ROLE_SUSPENSION' => AppConfig::ROLE_SUSPENSION,
		'ROLE_FACEBOOK' => AppConfig::ROLE_FACEBOOK,
		'ROLE_SYSUSER' => AppConfig::ROLE_SYSUSER,
		'ROLE_ADMIN' => AppConfig::ROLE_ADMIN
	);

	/**
	 *
	 * The use of roleInclude or roleExclude
	 *
	 * 1. assign only one rule or one mix rule(addrole + role)
	 * ex: 'navbarItem' => ['roleInclude' => AppConfig::ROLE_ADMIN],
	 * ex: 'navbarItem' => ['roleInclude' => ((AppConfig::ROLE_STUDENT+1)+AppConfig::ROLE_ADMIN)],
	 *
	 * 2. assign multiple rule or multiple mix rule(addrole + role)
	 * ex: 'navbarItem' => ['roleInclude' => [AppConfig::ROLE_ADMIN, AppConfig::ROLE_SYSUSER] ],
	 * ex: 'navbarItem' => ['roleInclude' => [((AppConfig::ROLE_STUDENT+1)+AppConfig::ROLE_ADMIN), ((AppConfig::ROLE_STUDENT+1)+AppConfig::ROLE_SYSUSER)] ],
	 *
	 */
	public static $navbar = [//判斷身分
		'/' => [],
		'faq' => [],
		'forgetpass' => [
			'!role' => AppConfig::ROLE_USER
		],
		'setNewPass' => [
			'role' => AppConfig::ROLE_USER
		],
		'http://halen.cc.ncu.edu.tw/kms.php' => [],
		'msg_board' => [],
		'laf' => [],
		'HDDestroy' => [
			'role' => AppConfig::ROLE_USER
		],
		'deskRecord' => [
			'roleInclude' => [
				AppConfig::ROLE_ADMIN,
				AppConfig::ROLE_SYSUSER
			],
			// 'roleExclude' => (AppConfig::ROLE_FACULTY+1+AppConfig::ROLE_SYSUSER)
			/*'roleExclude' => [AppConfig::ROLE_FACULTY+1+AppConfig::ROLE_SYSUSER
			]*/
		],
		'laf' => [],
		'HDDestroy' => [
			'role' => AppConfig::ROLE_USER
		],
		'admin' => [
			'role' => AppConfig::ROLE_ADMIN
		],
		'auth_soft'=>[
			
		],

		/*
		'regist' => array (
			'!role' => AppConfig::ROLE_SYSUSER,
			'badge' => array('id' => 'menu-badge-regist', 'value' => '' )
		),
		'project' => array(
			'submenu' => array(
				'a' => array(),
				'b' => array()
			)
		),
		'repos' => array(
			'submenu' => array(
				'sshkey' => array(),
				'divider' => array('divider' => true),
			)
		),
		'usermgr' => array(
			'submenu' => array(
				'user' => array(),
				'divider' => array('divider' => true),
				'user1' => array('route' => 'usermgr')
			),
			'badge' => array('id' => 'menu-badge-usrmgr', 'value' => ''),
			'role' => AppConfig::ROLE_ADMIN
		),
		'management' => array(
			'submenu' => array(
				'user' => array(),
				'divider' => array( 'divider' => true ),
				'user1' => array()
			),
			'badge' => array('id' => 'menu-badge-management', 'value' => ''),
			'role' => AppConfig::ROLE_ADMIN
		),
		*/
	];

	public static $alerts = [
		'alertClasses' => [
			'success' => 'alert-success',
			'info' => 'alert-info',
			'warning' => 'alert-warning',
			'danger' => 'alert-danger'
		],
		'alertIcons' => [
			'success' => 'glyphicon glyphicon-ok-sign',
			'info' => 'glyphicon-info-sign',
			'warning' => 'glyphicon-warning-sign',
			'danger' => 'glyphicon-exclamation-sign'
		]
	];
}

?>
