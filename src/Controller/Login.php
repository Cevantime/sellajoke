<?php

namespace Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Login
{
    public function index(Application $app, Request $request)
    {
        return $app['twig']->render('login.html.twig', [
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        ]);
    }
}
