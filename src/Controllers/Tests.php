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
		
		$user = $app['dao.users']->buildEntity(array(
			'role'		=>	'ROLE_USER',
			'username'	=> 'toto',
			'email'		=> 'toto@email.com'
		));
		
		$encoder = $app['security.encoder_factory']->getEncoder($user);
		
		$user->setPassword($encoder->encodePassword('toto', $user->getSalt()));

		$app['dao.users']->insert($user);
		
		return 'success';
	}
}
