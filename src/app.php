<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;

$app = new Application();

$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new SessionServiceProvider());

$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
		'user' => array(
			'pattern' => '^/',
			'http' => true,
			'anonymous' => true,
			'form' => array('login_path' => '/connexion', 'check_path' => '/login_check'),
			'users' => function() use($app) {
				return new DAO\UsersDAO($app['db']);
			}
		),
	)
));



$app->register(new \Services\DAOServiceProvider());


$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

return $app;
