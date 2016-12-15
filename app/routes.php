<?php
	
	$w_routes = array(
		['GET',      '/',               'Default#home',    'default_home'],
        ['GET|POST', '/add',            'Pictures#add',    'pictures_add'],
        ['GET|POST', '/ajax-operation', 'Pictures#geo',    'pictures_ajax-operation']

	);