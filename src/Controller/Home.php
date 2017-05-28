<?php

namespace Controller;

/**
 * Description of Home
 *
 * @author cevantime
 */
class Home {
	
	public function index (\Silex\Application $app) {
		$jokes = $app['dao.jokes']->findLast(array(), 5);
		
		return $app['twig']->render('home/index.html.twig', array('jokes' => $jokes));
	}
	
}
