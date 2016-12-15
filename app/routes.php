<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
        ['GET|POST', '/login', 'Users#login', 'users_login'],
        ['GET', '/logout', 'Users#logout', 'users_logout'],
        ['GET|POST', '/sign-in', 'Users#signIn', 'users_sign_in'],
        ['GET|POST',	'/confirm-account/[:token]',		'Users#confirm',	'user_confirm_account'],
        ['GET|POST',	'/user/password-recovery',					'Users#passwordRecovery',	'user_password_recovery'],
        ['GET|POST',	'/user/reset-password/[:token]',			'Users#resetPassword',	'user_reset_password'],

    );