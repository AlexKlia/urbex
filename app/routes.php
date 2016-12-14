<?php
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
        ['GET|POST', '/login', 'Users#login', 'users_login'],
        ['GET', '/logout', 'Users#logout', 'users_logout'],
        ['GET|POST', '/sign-in', 'Users#signIn', 'users_sign_in'],
	);