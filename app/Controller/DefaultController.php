<?php

namespace Controller;

use \W\Controller\Controller;

class DefaultController extends Controller
{

	/**
	 * Page d'accueil par défaut
	 */
	public function home()
	{
		$this->show('default/home');
	}

    /**
     * Page a propos
     */
    public function about()
    {
        $this->show('default/about');
    }

}