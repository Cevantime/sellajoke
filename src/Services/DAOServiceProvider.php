<?php
namespace Services;
/**
 * Description of DAOServiceProvider
 *
 * @author Formateur
 */
class DAOServiceProvider implements \Pimple\ServiceProviderInterface {
	
	public function register(\Pimple\Container $app) {
		$app['dao.users'] = function() use ($app){
			return new \DAO\UsersDAO($app['db']);
		};
	}

}
