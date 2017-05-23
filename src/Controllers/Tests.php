<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Controllers;

use Silex\Application;

/**
 * Description of Test
 *
 * @author Formateur
 */
class Tests {
	public function insertUser(Application $app) {
		
		$password = uniqid();
		
		$user = $app['dao.users']->buildEntity(array(
			'role'		=>	'ROLE_USER',
			'username'	=>	'admin',
			'password'	=>	'admin',
			'email'		=>	'toto@email.com',
			'salt'		=>	substr(md5(uniqid()), 0, 23)
		));
		
		$encoder = $app['security.encoder_factory']->getEncoder($user);
		
		$user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
		$app['dao.users']->insert($user);
		
		return 'user inserted : '.implode(',', (array)$user);
	}
}
