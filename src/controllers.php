<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

$app->before(function() use ($app) {
	$app['twig']->addGlobal('user', $app['user']);
});

$app->get('/', function () use ($app) {
	$token = $app['security.token_storage']->getToken();
	if($token) {
		$user = $token->getUser();
	} else {
		$user = null;
	}
    return $app['twig']->render('index.html.twig', array('user' => $user));
})
->bind('homepage')
;
$app->get('/', 'Controller\Home::index')->bind('homepage');

$app->get('/test/insert/user', 'Controller\\Tests::insertUser');

$app->get('/test/insert/category', 'Controller\\Tests::insertCategory');

$app->get('/test/insert/joke', 'Controller\\Tests::insertJoke');

$app->match('/add/joke', 'Controller\\Joke::editJoke')->method('GET|POST');

$app->match('/edit/joke/{jokeId}', 'Controller\\Joke::editJoke')->method('GET|POST');

$app->get('/login', 'Controller\\Login::index');

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
