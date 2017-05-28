<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controller;

use Silex\Application;

/**
 * Description of Test
 *
 * @author Formateur
 */
class Tests {
	public function insertUser(\App\CustomApp $app) {
		
		$password = uniqid();
		
		$user = $app['dao.users']->buildEntity(array(
			'role'		=>	'ROLE_USER',
			'username'	=>	'admin',
			'password'	=>	'admin',
			'email'		=>	'toto@email.com',
			'salt'		=>	substr(md5(uniqid()), 0, 23)
		));
		
		$user->setPassword($app->encodePassword($user->getPassword(), $user->getSalt()));
		
		$app['dao.users']->insert($user);
		
		return 'user inserted : '.implode(',', (array)$user);
	}
	
	public function insertCategory(Application $app) {
		
		$category = $app['dao.categories']->buildEntity(array(
			'name'		=>	'dark humour',
		));
		
		
		$app['dao.categories']->insert($category);
		
		return 'category inserted : '.implode(',', (array)$category);
	}
	
	public function insertJoke(Application $app) {
		
		$jokes = $app['dao.jokes']->buildEntity(array(
			'title'			=>	'Toto va à l\'école',
			'text'			=>	'C\'est Toto qui rentre dans un café et plouf... Comment ça c\'est pas drôle ?',
			'image'			=> 'game.png',
			'category_id'	=> 2
		));
		
		
		$app['dao.jokes']->insert($jokes);
		
		return 'joke inserted' ;
	}
}
