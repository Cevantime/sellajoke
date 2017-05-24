<?php

use App\CustomApp;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\SecurityServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\LocaleServiceProvider;

$app = new CustomApp();

$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new LocaleServiceProvider());
$app->register(new TranslationServiceProvider(), array(
    'locale_fallbacks' => array('en'),
));

$app->register(new SecurityServiceProvider(), array(
    'security.firewalls' => array(
		
		// on définit un premier pare-feu pour la partie front-office
		
		'front' => array(
			// ce pare-feu concerne toutes les urls atteintes via la protocole http
			'pattern' => '^/',
			'http' => true,
			
			// ce pare-feu doit permettre aux utilisateurs de naviguer sur le site même 
			// si ils ne sont pas connectés
			'anonymous' => true,
			
			/* 
			 * le service de sécurité a besoin de connaître la route vers le 
			 * formulaire de login (login_path) pour être en mesure de rediriger l'utilisateur
			 * vers celui-ci si l'authentification échoue. 
			 * De plus, on définit la route (check_path) sur laquelle doit pointer notre
			 * formulaire de connexion pour être traité par le service de sécurité.
			 */
			
			'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
			
			/**
			 * Nous fournissons à notre service de sécurité un user provider
			 * ce qui nous permettra d'aller chercher directement des utilisateurs
			 * en base de données.
			 */
			'users' => function() use($app) {
				return new DAO\UsersDAO($app['db']);
			}
		),
				
		// on définit un deuxième pare-feu pour la partie backoffice
		
		'bo' => array(
			// ce pare-feu protège toutes les routes commençant par "/admin"
			'pattern' => '^/admin',
			
			'http' => true,
			
			// on ne souhaite pas autoriser les connexions anonymes au backoffice !
			'anonymous' => false,
			
			'form' => array('login_path' => '/login_admin', 'check_path' => 'admin/login_check'),
			
			/**
			 * Nous fournissons cette fois un simple tableau contenant en clé les 
			 * noms d'utilisateurs autorisés et en valeur un tableau comprenant 
			 * les rôles et les mot de passe utilisateur. Si l'on souhaite rendre 
			 * évolutif le nombre d'administrateurs, il est possible de créer un
			 * user provider dédié
			 */
			
			'users' => array(
				// mdp = admin
				'admin' => array('$2y$13$NhmQ7LGidxWTbYWoQs0iAuy8ZhBEyz09v1jTs40EWlXA7pFxh0jGO', 'ROLE_ADMIN'),
				// TODO rajouter d'autres administrateurs !
			)
		)
	)
));

// Traduction des messages d'erreur
$app['translator.domains'] = array(
    'messages' => array(
       
        'fr' => array(
			'The credentials were changed from another session.' => 'Les identifiants ont été changés dans une autre session.',
			'The presented password cannot be empty.' => 'Le mot de passe ne peut pas être vide.',
			'The presented password is invalid.' => 'Le mot de passe entré est invalide.',
			'Bad credentials.' => 'Les identifiants sont incorrects'
        ),
		
		'en' => array(
			'Bad credentials.' => 'Invalid identifiers.'
		)
    ),
    'validators' => array(
		'en' => array(
			
		),
        'fr' => array(
            
        ),
    ),
);

$app->register(new \Services\DAOServiceProvider());


$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // on ajout nos extensions personnalisées
	$twig->addExtension(new TwigExtensions\AppExtensions());
	
    return $twig;
});

return $app;
