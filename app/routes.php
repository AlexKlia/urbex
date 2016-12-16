<?php
	
	$w_routes = array(
		['GET',         '/',                        'Default#home',             'default_home'],
        ['GET',         '/accueil',                 'Pictures#displayAccueil',  'pictures_lastpictures'],
        ['GET',         '/accueil/page/[i:page]',   'Pictures#displayAccueil',  'pictures_pagination'],
        ['GET|POST',    '/accueil/ajax-operation',  'Pictures#ajaxOperation',   'pictures_ajax_operationVote'],


    );