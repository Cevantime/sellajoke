<?php

namespace Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Connection {

	public function login(Application $app, Request $request) {
		return $app['twig']->render('login.html.twig', array(
			'error' => $app['security.last_error']($request),
			'last_username' => $app['session']->get('_security.last_username'),
		));
	}

}
