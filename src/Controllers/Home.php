<?php

namespace Controllers;

/**
 * Description of Home
 *
 * @author cevantime
 */
class Home {
	
	public function index (\Silex\Application $app) {
		$jokes = array(
			array(
				'id' => '123',
				'title' => 'Mon titre',
				'img' => 'img/portfolio/cabin.png',
				'resume' => 'Je suis un résumé',
				'date' => '143425354',
				'category' => 'Devinette'
			)
		);
		return $app['twig']->render('home/index.html.twig', array('jokes' => $jokes));
	}
	
	public function login(\Silex\Application $app){
		return $app['twig']->render('home/login.html.twig');
	}
}
